<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\User;
use App\Project;
use App\ProjectApplication;
use App\SlideText;
use App\Http\Library\CallTwitterApi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;


class DynamicController extends Controller
{
    
    public function __construct () {
        $this->gender = config('app.gender');
        $this->gender = config('app.gender');
        $this->purposes = config('app.purposes');
        $this->tools = config('app.tools');
        $this->languages = config('app.languages');
    }
    public function index() {
        $t = new CallTwitterApi();
        $d = $t->serachTweets("JavaScript");

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
            'sex' => 'required',
            'skil' => 'required',
            'sub_skil' => 'required',
            'minimum_work_experience' => 'required',
            'tool' => 'required',
            'project_image' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
            $messages = array_values($messages);
        }
        
        $project_instance = new Project();
        $project_instance->user_id = $user->id;
        $project_instance->project_name = $datas['project_name'];
        $project_instance->project_detail = !empty($datas['project_detail']) ? $datas['project_detail'] : '';
        $project_instance->language = $datas['skil'];
        $project_instance->sub_language = $datas['sub_skil'];
        $project_instance->number_of_application = $datas['number_of_application'];
        $project_instance->minimum_experience = $datas['minimum_work_experience'];
        $project_instance->minimum_years_old = !empty($datas['minimum_years_old']) ? $datas['minimum_years_old'] : 0;
        $project_instance->max_years_old = !empty($datas['max_years_old']) ? $datas['max_years_old'] : 0;
        $project_instance->men_and_women = $datas['sex'];
        $project_instance->tools = $datas['tool'];
        $project_instance->purpose = $datas['purpose'];
        $project_instance->status = 1;
        $project_instance->remarks = !empty($datas['remarks']) ? $datas['remarks'] : '';
        //作業頻度は個数が増えそうにないので固定で入れでもいいと思う
        if(!empty($datas['work_frequency'])) {
            if($datas['work_frequency'] == 0) {
                $project_instance->work_frequency = '週1~2時間';
            } elseif($datas['work_frequency'] == 1) {
                $project_instance->work_frequency = '週3~4時間';
            } elseif($datas['work_frequency'] == 2) {
                $project_instance->work_frequency = '週1日';
            } elseif($datas['work_frequency'] == 3) {
                $project_instance->work_frequency = '週2~3日';
            } else {
                $project_instance->work_frequency = '週4~5日';
            }
        } else {
            $project_instance->work_frequency = null;
        }
        
        
        
        if(!empty($request->file("project_image"))) {
            //拡張子取得
            $extension = $request->file("project_image")->getClientOriginalExtension();
            $now = Carbon::now('Asia/Tokyo');
            //画像名は年月日時分秒にして被らないようにする
            $image_name = $now->year . $now->month . $now->day . $now->hour . $now->minute . $now->second . '.' . $extension;
            $image_name_sp = $now->year . $now->month . $now->day . $now->hour . $now->minute . $now->second . '_sp.' . $extension;
            //画像を保存するディレクトリpath
            $path = storage_path('app') . '/images/' . $user->url_code . '/project';
            $fileExists = file_exists($path);
            //なければ作成
            if(!$fileExists) {
                Storage::disk('images')->makeDirectory($user->url_code . '/project');
            }
            //storeAsからのicon保存先path
            $str_path = "/images/" . $user->url_code . '/project';
            //現状の画像ファイルは削除
            $files = Storage::allFiles('images/' . $user->url_code . '/project');
            if($files) {
                foreach($files as $f) {
                    $del = Storage::delete($f);
                }
            }
            $save_path = storage_path('app/images/' . $user->url_code . '/project/') . $image_name;
            $save_path_sp = storage_path('app/images/' . $user->url_code . '/project/') . $image_name_sp;
            // dd($save_path);
            $image = Image::make($request->file('project_image'))
                      ->crop(
                             $request->get('image_w'),
                             $request->get('image_h'),
                             $request->get('image_x'),
                             $request->get('image_y')
                           )->resize(128,128) //サムネイル用にリサイズ
                            ->save($save_path);
            $image_sp = Image::make($request->file('project_image'))
                      ->crop(
                             $request->get('image_w'),
                             $request->get('image_h'),
                             $request->get('image_x'),
                             $request->get('image_y')
                           )->resize(375,150) //サムネイル用にリサイズ
                            ->save($save_path_sp);
            //画像を保存
            // $save_image = $request->file('icon_image')->storeAs($str_path,$image_name);
            // $save_image = $image->storeAs($str_path,$image_name);
        } else {
            $image_name = null;
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
    public function seek_project() {
        $projects = Project::where('status', 1)->get();
        foreach($projects as $project) {
            $project->purpose = $this->purposes[$project->purpose];
            $project->men_and_women = $this->gender[$project->men_and_women];
            $project->tools = $this->tools[$project->tools];
            $project->language = $this->languages[$project->language];
            $project->sub_language = $this->languages[$project->sub_language];
            $project->year = $project->minimum_years_old . '歳~' . $project->max_years_old . '歳';
            $project->user = User::where('id', $project->user_id)->first();
        }
        $array_datas = [];
        $array_datas['languages'] = $this->languages;
        $array_datas['purposes'] = $this->purposes;
        $array_datas['gender'] = $this->gender;
        
        return view('seek_project', ['datas' => $array_datas, 'projects' => $projects]);
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
        if($target_user['sex']) {
            $target_user['sex'] = $this->gender[$target_user['sex']];
        } else {
            $target_user['sex'] = '未設定';
        }
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
    
    public function edit_proifile($id) {
        $login_user = Auth::user();
        if($login_user->id != $id) {
            return redirect('/my_page');
        }
        $edit_user = User::find($id);
        return view('personal.edit_user', ['login_user_infomation' => $edit_user]);
    }
    
    public function edit_proifile_post(Request $request) {
        $datas = $request->all();
        $messages = [
            'image' => '指定されたファイルが画像ではありません。',
            'mimes' => '指定された拡張子（PNG/JPG/GIF）ではありません。',
            'max' => '1MBを超えています。',
        ];
        $validator = Validator::make($datas,[
            'icon_image' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
            $messages = array_values($messages);
        }
        $login_user = Auth::user();
        if(!empty($request->file("icon_image"))) {
            //拡張子取得
            $extension = $request->file("icon_image")->getClientOriginalExtension();
            $now = Carbon::now('Asia/Tokyo');
            //画像名は年月日時分秒にして被らないようにする
            $image_name = $now->year . $now->month . $now->day . $now->hour . $now->minute . $now->second . '.' . $extension;
            $image_name_sp = $now->year . $now->month . $now->day . $now->hour . $now->minute . $now->second . '_sp.' . $extension;
            //画像を保存するディレクトリpath
            $path = storage_path('app') . '/images/' . $login_user->url_code . '/icon';
            $fileExists = file_exists($path);
            //なければ作成
            if(!$fileExists) {
                Storage::disk('images')->makeDirectory($login_user->url_code . '/icon');
            }
            //storeAsからのicon保存先path
            $str_path = "/images/" . $login_user->url_code . '/icon';
            //現状の画像ファイルは削除
            $files = Storage::allFiles('images/' . $login_user->url_code . '/icon');
            if($files) {
                foreach($files as $f) {
                    $del = Storage::delete($f);
                }
            }
            $save_path = storage_path('app/images/' . $login_user->url_code . '/icon/') . $image_name;
            $save_path_sp = storage_path('app/images/' . $login_user->url_code . '/icon/') . $image_name_sp;
            // dd($save_path);
            $image = Image::make($request->file('icon_image'))
                      ->crop(
                             $request->get('image_w'),
                             $request->get('image_h'),
                             $request->get('image_x'),
                             $request->get('image_y')
                           )->resize(128,128) //サムネイル用にリサイズ
                            ->save($save_path);
            $image_sp = Image::make($request->file('icon_image'))
                      ->crop(
                             $request->get('image_w'),
                             $request->get('image_h'),
                             $request->get('image_x'),
                             $request->get('image_y')
                           )->resize(375,150) //サムネイル用にリサイズ
                            ->save($save_path_sp);
            //画像を保存
            // $save_image = $request->file('icon_image')->storeAs($str_path,$image_name);
            // $save_image = $image->storeAs($str_path,$image_name);
        } else {
            $image_name = null;
        }
        
        
        $target_user = User::where('user_name', $request['user_name'])->first();
        $target_user['age'] = $request['age'];
        $target_user['comment'] = $request['edit_comment'];
        $target_user['email'] = $request['edit_email'];
        $target_user['self_introduction'] = $request['edit_self_introduction'];
        $target_user['free_url'] = $request['edit_url'];
        $target_user['sex'] = $request['edit_gender'];
        if($image_name != null) {
            $target_user['icon_image'] = $image_name;
        }
        if($image_name_sp != null) {
            $target_user['icon_image_sp'] = $image_name_sp;
        }
        $save = $target_user->save();
        if($save) {
            $message = '変更しました。';
        } else {
            $message = '変更できませんでした。';
        }
        return redirect('/edit_proifile/' . $target_user['id'])->with('edit_message', $message);
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
        $application_list = Project::join('project_applications','projects.id','=','project_applications.project_id')
        ->where('author_id', $target_user->id)
        ->where('project_id', $id)
        ->where('project_applications.deleted_at', null)
        ->get();
        // if(count($application_list) == 0) {
        //     return back()->with('nothing_data', '該当のプロジェクトは存在していません。');
        // }
        foreach($application_list as $app) {
            $app->application_user_info = User::select('user_name')->where('id', $app->application_id)->get();
            //申請日をcreated_atから生成(project_id , application_idで絞る)
            $app->application_date = ProjectApplication::select('created_at')->where('application_id', $app->application_id)->where('project_id', $app->project_id)->get();
        }
        return view('personal.application', ['application_list' => $application_list]);
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
    public function get_request_user_image(Request $request){
        $data = $request->all();
        \Log::info('ここです');
        \Log::info($data["id"]);
        \Log::info($data["name"]);
        $path = storage_path("app/images/" . $data["id"] . "/icon/".$data["name"]);
        return Response()->file($path);
    }
    
}
