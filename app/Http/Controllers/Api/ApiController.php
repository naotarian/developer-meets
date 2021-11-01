<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Project;
use App\ProjectApplication;
use App\Http\Library\CallTwitterApi;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function __construct () {
        $this->gender = config('app.gender');
        $this->gender = config('app.gender');
        $this->purposes = config('app.purposes');
        $this->tools = config('app.tools');
        $this->languages = config('app.languages');
    }

    public function test() {
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

        $projects = json_encode($projects);
        $array_datas = json_encode($array_datas);

        return response(
            [$projects, $array_datas]
        );
    }

    public function project_detail($id) {
        $target_project = Project::find($id);
        $target_project['language'] = $this->languages[$target_project['language']];
        $target_project['sub_language'] = $this->languages[$target_project['sub_language']];
        $target_user = Auth::user();
        if($target_project['user_id'] == $target_user->id) {
            $flag = 3;
            $target_project['application_flag'] = $flag;
            $target_project = json_encode($target_project);
    
            return response($target_project);
        }
        //ログインuserが既に申請済みだったらtrue
        $application_check = ProjectApplication::where('project_id', $target_project['id'])->where('application_id', $target_user->id)->first();
        if(!$application_check) {
            $flag = 2;
        } else {
            $flag = 1;
        }
        
        $target_project['application_flag'] = $flag;
        $target_project = json_encode($target_project);

        return response($target_project);
    }

    public function all_projejct() {
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
        $all_project = json_encode($projects);
        return response($all_project);

    }
    
    public function application($id) {
        $target_user = Auth::user();
        $project_info = Project::find($id);
        if($target_user->id == $project_info['user_id']) {
            $result = true;
            return response()->json($result);
        }
        //既存のものがあれば追加しない
        $upsert = ProjectApplication::updateOrCreate(
            ['application_id' => $target_user->id, 'project_id' => $project_info['id'], 'deleted_at' => null],
            ['status' => '1', 'application_id' => $target_user->id, 'author_id' => $project_info['user_id'], 'project_id' => $project_info['id']]
        );
        if($upsert->wasRecentlyCreated) {
            $result = true;
            return response()->json($result);
        } else {
            $result = true;
            return response()->json($result);
        }
        
    }

    public function twitterApi(Request $request)
    {
        $t = new CallTwitterApi();
        $d = $t->serachTweets("JavaScript");

        $array = array();
        foreach($d as $d) {
          $array[] = array($t->statusesOembed($d->id));
        }
        return view('top', ['twitter' => $array]);
    }
}
