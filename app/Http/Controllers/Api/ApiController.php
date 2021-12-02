<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Project;
use App\Comment;
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
    // ログインuser情報を返すAPI
    public function login_user_info() {
        $login_user = Auth::user();
        $res = $login_user ? ['status_code' => '200', 'msg' => 'logged in.', 'user' => $login_user] : ['status_code' => '400', 'msg' => 'not logged in.'];
        return response($res);
    }

    // IDを受け取り、そのuserのアイコン画像パスを返すAPI
    public function user_icon($id) {
        $user = User::where('id', $id)->first();
        if ($user) {
            $filepath = storage_path('app/images/'.$user['url_code'].'/icon/'.$user['icon_image']);
            return Response()->file($filepath);
        }
    }

    // IDを受け取り、そのprojectの画像パスを返すAPI
    public function project_image($id) {
        $project_data = Project::find($id);
        $creater = User::where('id', $project_data['user_id'])->first();
        $project_creater_hash = $creater['url_code'];
        $project_id_hash = $project_data['url_code'];
        $project_image_name = $project_data['project_image'];
        if ($project_image_name) {
            $filepath = storage_path('app/images/'.$project_creater_hash.'/project/'.$project_id_hash.'/'.$project_image_name);
            return Response()->file($filepath);
        } else {
            $filepath = public_path().'/images/share/no_image.jpeg';
            return Response()->file($filepath);
        }
    }

    public function project_detail($id) {
        //配列形式で取得
        $project_data = Project::find($id)->toArray();
        $project_data['user_url_code'] = hash('crc32', $project_data['user_id']);
        $project_data['created_by'] = User::where('id', $project_data['user_id'])->first();
        //配列で取得した$project_dataの中にコメント群と、会話に参加しているユーザーのidを入れてreturnする
        $project_data['comments'] = Comment::where('project_id', $id)->get();
        $project_data['comment_users_id'] = [];
        if($project_data['comments']) {
            foreach($project_data['comments'] as $user) {
                $data = json_decode($user, true);
                array_push($project_data['comment_users_id'],$data['user_id']);
            }
        }
        $project_data['comment_users_id'] = array_values(array_unique($project_data['comment_users_id']));

        $login_user = Auth::user();
        //ログインしてない場合（フロント側でそもそも押せないように制御）
        if(!$login_user) {
            $project_data['application_flag'] = "not_login";
            $project_data = json_encode($project_data);
            return response($project_data);
        }
        //自分のプロジェクトの場合（フロント側でそもそも押せないように制御）
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
    
    public function new_comment(Request $request) {
        try{
            $login_user = Auth::user();
            $request = [];
            $request['user_id'] = $login_user['id'];
            $request['project_id'] = 1;
            $request['target_user_id'] = '1,2,3';
            $request['comment'] = 'GET動詞が付くルートにアクセスするには、普通にブラウザからURLを入力すると、GETリクエストでのアクセスとなりますので、
            GET動詞の付くルートが適応されます。';
            $new_comment = new Comment();
            $new_comment->fill($request);
            $new_comment->save();
            $display_comments = Comment::where('project_id', 1)->get();
            return response()->json(['status_code' => '200', 'comments' => $display_comments]);
        } catch(\Exception $ex) {
            return response()->json(['status_code' => '400', 'err_msg' => $ex->getMessage()]);
        }
    }
    
    public function edit_comment(Request $request) {
        try {
            $login_user = Auth::user();
            //ここは動的になる
            $comment_id = 1;
            $target_comment = Comment::where('user_id', $login_user['id'])->where('id', $comment_id)->first();
            if(!$target_comment) {
                return back()->with('msg', '対象コメントがありません。');
            }
            /*
                ここに編集処理
            */
            $display_comments = Comment::where('project_id', 1)->get();
            return response()->json(['status_code' => '200', 'comments' => $display_comments]);
        } catch(\Exception $ex) {
            return response()->json(['status_code' => '400', 'err_msg' => $ex->getMessage()]);
        }
    }
    
    public function delete_comment(Request $request) {
        try {
            $login_user = Auth::user();
            //ここは動的になる
            $comment_id = 2;
            $target_comment = Comment::where('user_id', $login_user['id'])->where('id', $comment_id)->delete();
            $display_comments = Comment::where('project_id', 1)->get();
            return response()->json(['status_code' => '200', 'comments' => $display_comments]);
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
