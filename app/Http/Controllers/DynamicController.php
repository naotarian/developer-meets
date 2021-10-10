<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\User;
use App\Project;
use Illuminate\Support\Facades\Auth;

class DynamicController extends Controller
{
    
    public function __construct () {
        $this->sex = config('app.sex');
        $this->gender = config('app.gender');
        $this->purposes = config('app.purposes');
        $this->tools = config('app.tools');
        $this->languages = config('app.languages');
    }
    public function index() {
        return view('top');
    }
    
    public function seek_project() {
        $languages = ['Java', 'C#', 'C言語', 'Python'];
        $purposes = ['学習', 'つながり', 'リリース', '本気'];
        return view('seek_project', ['languages' => $languages, 'purposes' => $purposes]);
    }
    public function make_project() {
        return view('make_project');
    }
    public function make_project_post(Request $request) {
        $user = Auth::user();
        $datas = $request->all();
        // dd($datas);
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
    public function project_list() {
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
        return view('project_list', ['projects' => $projects]);
    }
    
    public function my_page() {
        $login_user = Auth::user();
        $login_user_infomation = User::where('id', $login_user->id)->first();
        $login_user_infomation->sex = $this->sex[$login_user_infomation->sex];
        return view('personal.my_page', ['login_user_infomation' => $login_user_infomation]);
    }
}
