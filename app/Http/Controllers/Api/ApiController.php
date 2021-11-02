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
        $project_data = Project::find($id);
        $project_data['language'] = $this->languages[$project_data['language']];
        $project_data['sub_language'] = $this->languages[$project_data['sub_language']];
        $login_user = Auth::user();
        if($project_data['user_id'] == $login_user->id) {
            $project_data['application_flag'] = "my_projejct";
            $project_data = json_encode($project_data);

            return response($project_data);
        }
        //ログインuserが既に申請済みだったらtrue
        $application_check = ProjectApplication::where('project_id', $project_data['id'])->where('application_id', $login_user->id)->first();
        $project_data['application_flag'] = $application_check ? "applied" : "unapplied";
        $project_data = json_encode($project_data);

        return response($project_data);
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

    public function application(Request $request) {
        try {
            $login_user = Auth::user();
            $project_data = $request->all();
            if($login_user->id == $project_data['user_id']) {
                return response()->json(['status_code' => '400', 'msg' => '自分が作成したプロジェクトです', 'flag' => 'my_project']);
            }
            //既存のものがあれば追加しない
            $upsert = ProjectApplication::updateOrCreate(
                ['application_id' => $login_user->id, 'project_id' => $project_data['id'], 'deleted_at' => null],
                ['status' => '1', 'application_id' => $login_user->id, 'author_id' => $project_data['user_id'], 'project_id' => $project_data['id']]
            );
            if($upsert->wasRecentlyCreated) {
                return response()->json(['status_code' => '200', 'msg' => '申請に成功しました', 'flag' => 'applied']);
            } else {
                return response()->json(['status_code' => '400', 'err_msg' => '既に申請済みです', 'flag' => 'unapplied']);
            }
        } catch(\Exception $ex) {
            return response()->json(['status_code' => '400', 'err_msg' => $ex->getMessage()]);
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
