<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\User;
use App\Project;
use App\ProjectApplication;
use Illuminate\Support\Facades\Auth;


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
        return view('top');
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
            'project_name.max' => ':attributeは50文字までです'
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
        $project_instance->save();
        
        return redirect('/make')->with('flash_message', 'プロジェクト作成が完了しました');
    }
    public function seek_project() {
        $projects = Project::all();
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
        if($target_user->id == $logging_id) {
            $display_flag = 1;
        } else {
            $display_flag = 0;
        }
        /*
        display_flagがtrueの場合のみ、参加申請中を表示
        */
        $now_applications = Project::join('project_applications','projects.id','=','project_applications.project_id')->where('project_applications.application_id', $target_user->id)->where('project_applications.status', 1)->where('project_applications.deleted_at', null)->get();
        $target_user['sex'] = $this->gender[$target_user['sex']];
        //掲載中のプロジェクト
        $now_available_projects = Project::where('user_id', $target_user->id)->get();
        
        return view('personal.my_page', ['login_user_infomation' => $target_user, 'now_available_projects' => $now_available_projects, 'now_applications' => $now_applications, 'display_flag' => $display_flag]);
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
    
    public function application_list(Request $request) {
        $target_user = Auth::user();
        $application_list = ProjectApplication::where('author_id', $target_user->id)->join('projects','project_applications.project_id','=','projects.id')->get();
        foreach($application_list as $app) {
            $app->application_user_info = User::select('user_name')->where('id', $app->application_id)->get();
            $app->application_date = ProjectApplication::select('created_at')->where('application_id', $app->application_id)->get();
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
}
