<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\User;
use App\Project;
use App\ProjectApplication;
use App\SlideText;
use App\Http\Library\CallTwitterApi;
use App\Http\Library\SaveImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;


class DynamicController extends Controller
{
    
    public function __construct () {
        $this->gender = config('app.gender');
        $this->men_and_women = config('app.men_and_women');
        $this->purposes = config('app.purposes');
        $this->tools = config('app.tools');
        $this->languages = config('app.languages');
        $this->work_frequency = config('app.work_frequency');
    }
    public function index() {
        $t = new CallTwitterApi();
        $d = $t->serachTweets("駆け出しエンジニア");
        $array = array();
        foreach($d as $d) {
          $array[] = array($t->statusesOembed($d->id));
        }
        $slide_text = SlideText::where('status', 0)->get();
        $slide_text_sorted = $slide_text->sortBy('sort')->values()->toArray();
        return view('top', ['twitter' => $array, 'slide_text_sorted' => $slide_text_sorted]);
    }
    
    
   
    public function make_project() {
        $languages = $this->languages;
        $purposes = $this->purposes;
        $datas['languages'] = $this->languages;
        $datas['purposes'] = $this->purposes;
        $datas['tools'] = $this->tools;
        $datas['men_and_women'] = $this->men_and_women;
        $datas['work_frequency'] = $this->work_frequency;
        $datas['age'] = [];
        for($i = 15; $i < 60; $i++) {
            $datas['age'][$i] = $i;
        }
        
        return view('make_project', ['datas' => $datas]);
    }
    public function make_project_post(Request $request) {
        $user = Auth::user();
        $datas = $request->all();
        $messages = [
            'required' => ' :attributeを入力してください',
            'project_name.max' => ':attributeは50文字までです',
            'project_image.image' => '指定されたファイルが画像ではありません。',
            'project_image.mimes' => '指定された拡張子（PNG/JPG/GIF）ではありません。',
            'project_image.max' => '1MBを超えています。',
        ];
        $validator = Validator::make($datas,[
            'project_name' => 'required|max:50',
            'project_detail' => 'max:1000',
            'number_of_application' => 'required',
            'purpose' => 'required',
            'men_and_women' => 'required',
            'language' => 'required',
            'sub_language' => 'required',
            'minimum_experience' => 'required',
            'tools' => 'required',
            'project_image' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
            $messages = array_values($messages);
        }
        $datas['user_id'] = $user->id;
        $datas['status'] = 1;
        $datas['project_detail'] = !empty($datas['project_detail']) ? $datas['project_detail'] : '';
        $datas['max_years_old'] = !empty($datas['max_years_old']) ? $datas['max_years_old'] : 0;
        $datas['minimum_years_old'] = !empty($datas['minimum_years_old']) ? $datas['minimum_years_old'] : 0;
        $datas['remarks'] = !empty($datas['remarks']) ? $datas['remarks'] : '';
        //作業頻度は個数が増えそうにないので固定で入れでもいいと思う
        $datas['work_frequency'] = !empty($datas['work_frequency']) ?  $datas['work_frequency'] : null;
        // dd($datas);
        $project_instance = Project::create($datas);
        //作成したprojectのurl_codeを生成
        $project_instance['url_code'] = hash('crc32', $project_instance['id']);
        //画像登録があった場合
        if(!empty($request->file("project_image"))) {
            $input_name = 'project_image';
            $save_dir = '/project';
            $save_image_instance = new SaveImage();
            $save = $save_image_instance->save_image($request, $input_name, $save_dir, $user, $project_instance['url_code']);
            $image_name = $save['image_name'];
            $image_name_sp = $save['image_name_sp'];
        } else {
            $image_name = null;
            $image_name_sp = null;
        }
        
        if($image_name != null) {
            $project_instance['project_image'] = $image_name;
        }
        if($image_name_sp != null) {
            $project_instance['project_image_sp'] = $image_name_sp;
        }
        
        $project_instance->save();

        return redirect('/make')->with('flash_message', 'プロジェクト作成が完了しました');
    }
    
    public function project_edit($id) {
        $target_project = Project::find($id);
        $login_user = Auth::user();
        if($target_project['user_id'] != $login_user->id) {
            return redirect('/seek');
        }
        // $languages = $this->languages;
        // $purposes = $this->purposes;
        $datas['languages'] = $this->languages;
        $datas['purposes'] = $this->purposes;
        $datas['men_and_women'] = $this->men_and_women;
        $datas['tools'] = $this->tools;
        $datas['work_frequency'] = $this->work_frequency;
        
        $datas['age'] = [];
        for($i = 15; $i < 60; $i++) {
            $datas['age'][$i] = $i;
        }
        // $datas['work'] = array('0' => '週1~2時間', '1' => '週3~4時間', '2' => '週1日', '3' => '週2~3日', '4' => '週4~5日');
        // $datas['work_frequency'] = array_keys($datas['work'], $target_project['work_frequency']);
        // if(empty($datas['work_frequency'])) {
        //     $datas['work_frequency'][0] = null;
        // }
        return view('edit_project', ['project' => $target_project, 'datas' => $datas]);
    }
    
    public function edit_project_post(Request $request) {
        $project_data = $request->all();
        $login_user = Auth::user();
        $messages = [
            'required' => ' :attributeを入力してください',
            'project_name.max' => ':attributeは50文字までです',
            'project_image.image' => '指定されたファイルが画像ではありません。',
            'project_image.mimes' => '指定された拡張子（PNG/JPG/GIF）ではありません。',
            'project_image.max' => '1MBを超えています。',
        ];
        $validator = Validator::make($project_data,[
            'project_name' => 'required|max:50',
            'project_detail' => 'required|max:1000',
            'number_of_application' => 'required',
            'purpose' => 'required',
            'men_and_women' => 'required',
            'language' => 'required',
            'sub_language' => 'required',
            'minimum_experience' => 'required',
            'tools' => 'required',
            'project_image' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
            $messages = array_values($messages);
        }
        //編集するプロジェクト
        $target_project_data = Project::find($project_data['project_id']);
        //画像の変更があった場合
        if(!empty($request->file("project_image"))) {
            $input_name = 'project_image';
            $save_dir = '/project';
            $save_image_instance = new SaveImage();
            $save = $save_image_instance->save_image($request, $input_name, $save_dir, $login_user, $target_project_data['url_code']);
            $image_name = $save['image_name'];
        } else {
            $image_name = null;
        }
        if($image_name != null) {
            $project_data['project_image'] = $image_name;
        }
        $target_project_data->fill($project_data);
        $target_project_data->save();
        return redirect('/my_page')->with('edit_project_message', 'プロジェクト内容を編集しました');
    }
    
    public function seek_project() {
        $projects = Project::where('status', 1)->get();
        foreach($projects as $project) {
            // $project->purpose = $this->purposes[$project->purpose];
            // $project->men_and_women = $this->gender[$project->men_and_women];
            // $project->tools = $this->tools[$project->tools];
            // $project->language = $this->languages[$project->language];
            // $project->sub_language = $this->languages[$project->sub_language];
            $project->year = $project->minimum_years_old . '歳~' . $project->max_years_old . '歳';
            $project->user = User::where('id', $project->user_id)->first();
        }
        $array_datas = [];
        $array_datas['languages'] = $this->languages;
        $array_datas['purposes'] = $this->purposes;
        $array_datas['gender'] = $this->gender;
        
        return view('seek_project', ['datas' => $array_datas, 'projects' => $projects]);
    }
    
    public function user_info($user_name) {
        $login_user = Auth::user();
        $logging_id = $login_user['id'];
        $target_user = User::where('user_name', $user_name)->first();
        if($logging_id == $target_user->id) {
            return redirect('/my_page');
        }
        
        // if($target_user['sex']) {
        //     $target_user['sex'] = $this->gender[$target_user['sex']];
        // } else {
        //     $target_user['sex'] = '未設定';
        // }
        if($target_user['engineer_history'] == null) {
            $target_user['engineer_history'] = '未設定';
        }
        if($target_user['age'] == null) {
            $target_user['age'] = '未設定';
        }
        $join_projects = Project::join('project_applications','projects.id','=','project_applications.project_id')
        ->where('project_applications.application_id', $target_user->id)
        ->where('project_applications.status', 2)
        ->where('project_applications.deleted_at', null)
        ->get();
        $now_available_projects = Project::where('user_id', $target_user->id)->where('status', 1)->get();
        
        return view('personal.user_info', ['target_user' => $target_user,
                                         'now_available_projects' => $now_available_projects, 
                                        //  'now_applications' => $now_applications, 
                                        //  'display_flag' => $display_flag,
                                         'join_projects' => $join_projects
                                         ]);
    }
    public function my_page($user_name = 0) {
        $target_user = Auth::user();
        $logging_id = $target_user->id;
        if($user_name) {
            $target_user = User::where('user_name', $user_name)->first();
        }
        if(!$target_user) {
            return back()->with('nothing_user', 'ユーザーがいません。');
        }
        if($target_user->id == $logging_id) {
            $display_flag = 1;
        } else {
            $display_flag = 0;
        }
        /*
        display_flagがtrueの場合のみ、参加申請中を表示
        */
        $now_applications = Project::join('project_applications','projects.id','=','project_applications.project_id')
        ->where('project_applications.application_id', $target_user->id)
        ->where('project_applications.status', 1)
        ->where('project_applications.deleted_at', null)
        ->get();
        $join_projects = Project::join('project_applications','projects.id','=','project_applications.project_id')
        ->where('project_applications.application_id', $target_user->id)
        ->where('project_applications.status', 2)
        ->where('project_applications.deleted_at', null)
        ->get();
        // if($target_user['sex']) {
        //     $target_user['sex'] = $this->gender[$target_user['sex']];
        // } else {
        //     $target_user['sex'] = '未設定';
        // }
        if($target_user['engineer_history'] == null) {
            $target_user['engineer_history'] = '未設定';
        }
        if($target_user['age'] == null) {
            $target_user['age'] = '未設定';
        }
        //掲載中のプロジェクト
        $now_available_projects = Project::where('user_id', $target_user->id)->where('status', 1)->get();
        
        return view('personal.my_page', ['login_user_infomation' => $target_user,
                                         'now_available_projects' => $now_available_projects, 
                                         'now_applications' => $now_applications, 
                                         'display_flag' => $display_flag,
                                         'join_projects' => $join_projects
                                         ]);
    }
    
    public function edit_profile($id) {
        $login_user = Auth::user();
        if($login_user->id != $id) {
            return redirect('/my_page');
        }
        $edit_user = User::find($id);
        return view('personal.edit_user', ['login_user_infomation' => $edit_user]);
    }
    
    public function edit_profile_post(Request $request) {
        $datas = $request->all();
        $login_user = Auth::user();
        $messages = [
            'image' => '指定されたファイルが画像ではありません。',
            'mimes' => '指定された拡張子（PNG/JPG/GIF）ではありません。',
            'comment.max' => ':attributeは40文字までです。',
            'self_introduction.max' => ':attributeは1000文字までです。',
            'icon_image.max' => '1MBを超えています。',
            'integer' => ':attributeが不正な値です。',
        ];
        $validator = Validator::make($datas,[
            'icon_image' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
            'free_url' => 'url',
            'sex' => 'required',
            'email' => 'email:strict,dns,spoof|unique:users,email,'.$login_user->id.',id,deleted_at,NULL',
            // 'email' => 'required|string|email|max:255|unique:users,email,NULL,id,deleted_at,NULL',
            'comment' => 'max:40',
            'self_introduction' => 'max:1000',
            'age' => 'required|integer',
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
            $messages = array_values($messages);
        }

        if(!empty($request->file("icon_image"))) {
                $input_name = 'icon_image';
                $save_dir = '/icon';
                $save_image_instance = new SaveImage();
                $save = $save_image_instance->save_image($request, $input_name, $save_dir, $login_user);
                $image_name = $save['image_name'];
            } else {
                $image_name = null;
            }
        $target_user = User::where('user_name', $request['user_name'])->first();
        if($image_name != null) {
            $datas['icon_image'] = $image_name;
        }
        $target_user->fill($datas);
        $save = $target_user->save();
        if($save) {
            $message = '変更しました。';
        } else {
            $message = '変更できませんでした。';
        }
        return redirect('/edit_profile/' . $target_user['id'])->with('edit_message', $message);
    }
    
    public function question(Request $request) {
        $project_info = json_decode($request['project_info'], true);
    }
    public function application(Request $request) {
        $target_user = Auth::user();
        $project_info = json_decode($request['project_info'], true);
        if($target_user->id == $project_info['user_id']) {
            return back()->with('my_project_message', '自身の作成プロジェクトへは参加申請を出せません。');
        }
        //既存のものがあれば追加しない
        $upsert = ProjectApplication::updateOrCreate(
            ['application_id' => $target_user->id, 'project_id' => $project_info['id']],
            ['status' => '1', 'application_id' => $target_user->id, 'author_id' => $project_info['user_id'], 'project_id' => $project_info['id']]
        );
        if($upsert->wasRecentlyCreated) {
            $message = '申請が完了しました。';
        } else {
            $message = '既に申請済みです。';
        }
        return back()->with('flash_message', $message);
    }
    
    public function application_list($id) {
        $target_user = Auth::user();
        $target_project = Project::where('user_id', $id)->first();
        if($target_project['id'] != $target_user['id']) {
            return redirect('/my_page');
        }
        $application_list = Project::join('project_applications','projects.id','=','project_applications.project_id')
        ->where('author_id', $target_user->id)
        ->where('project_id', $id)
        ->where('project_applications.status', 1)
        ->where('project_applications.deleted_at', null)
        ->get();
        $member_list = Project::join('project_applications','projects.id','=','project_applications.project_id')
        ->where('author_id', $target_user->id)
        ->where('project_id', $id)
        ->where('project_applications.status', 2)
        ->where('project_applications.deleted_at', null)
        ->get();
        foreach($application_list as $app) {
            $app->application_user_info = User::where('id', $app->application_id)->withTrashed()->first();
            if($app->application_user_info['deleted_at'] != null) {
                $app->application_user_info['user_name'] .= '(退会済み)';
            }
            //申請日をcreated_atから生成(project_id , application_idで絞る)
            $app->application_date = ProjectApplication::select('created_at')->where('application_id', $app->application_id)->where('project_id', $app->project_id)->get();
        }
        foreach($member_list as $member) {
            $member->application_user_info = User::where('id', $member->application_id)->withTrashed()->first();
            if($member->application_user_info['deleted_at'] != null) {
                $member->application_user_info['user_name'] .= '(退会済み)';
            }
            // $member->application_user_info = User::where('id', $member->application_id)->get();
        }
        // dd($member_list);
        return view('personal.application', ['application_list' => $application_list, 'member_list' => $member_list]);
    }
    
    public function cancel(Request $request) {
        $datas = json_decode($request['project_info'], true);
        $target_application = ProjectApplication::find($datas['id']);
        $target_application['status'] = 0;
        $target_application->save();
        $delete_application = $target_application->delete();
        

        if($delete_application) {
            $message = '申請を取り消しました。';
        } else {
            $message = '予期せぬエラー : 該当のプロジェクトはありません。';
        }
        return back()->with('delete_message', $message);
    }
    
    public function rejected($id) {
        $rejectd_application = ProjectApplication::find($id);
        $rejectd_application->status = 0;
        $rejectd_application->save();
        $rejectd = $rejectd_application->delete();
        
        if($rejectd) {
            $message = '申請を見送りました。';
        } else {
            $message = '予期せぬエラー : 該当のは参加申請はありません。';
        }
        return back()->with('rejected_message', $message);
        
    }
    
    public function withdrawal($id) {
        $withdrawal_project = Project::find($id);
        $withdrawal_project->status = 2;
        $withdrawal_project->save();
        $withdrawal_project->delete();
        if($withdrawal_project->status == 2) {
            $message = '掲載を終了しました。';
        } else {
            $message = '予期せぬエラー。';
        }
        
        return back()->with('withdrawal_message', $message);
    }
    
    public function approval($id) {
        $target_application = ProjectApplication::find($id);
        if($target_application->status == 2) {
            return back()->with('approval_message', '既に承認済みです。');
        }
        $target_project = Project::find($target_application['project_id']);
        
        $target_application->status = 2;
        $target_application->save();
        $target_project->number_of_application -= 1;
        if($target_project->number_of_application == 0) {
            $target_project->status = 4;
        }
        $target_project->save();
        return redirect('/my_page')->with('approval_message', '参加申請を承認しました。');
    }
    
    //userのアイコンorプロジェクトのサムネイルが欲しい時だけ使用する
    public function get_request_image(Request $request){
        $data = $request->all();
        if($data['dir'] == 'project') {
            $path = storage_path("app/images/" . $data["id"] . "/" . $data['dir'] . "/". $data['url_code'] . '/' . $data["name"]);
        } else {
            $path = storage_path("app/images/" . $data["id"] . "/" . $data['dir'] . "/" . $data["name"]);
        }
        return Response()->file($path);
    }
    
}
