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
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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
        $res = $login_user ? ['status_code' => 200, 'msg' => 'logged in.', 'user' => $login_user] : ['status_code' => 400, 'msg' => 'not logged in.'];
        return response($res);
    }

    // IDを受け取り、そのuserのアイコン画像パスを返すAPI
    public function user_icon($id) {
        $user = User::where('id', $id)->first();
        if ($user) {
            if(!$user['icon_image']) {
                $filepath = '';
                return Response($filepath);
            }
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
        //ユーザー情報も全部入れ込む
        $comments = Comment::where('project_id', $id)->get();
        if ($comments) {
            foreach($comments as $comment) {
                $comment['user'] = User::where('id', $comment['user_id'])->first();
            }
        }
        $project_data['comments'] = $comments;
        $project_data['commented_user'] = [];
        if($project_data['comments']) {
            foreach($project_data['comments'] as $user) {
                $data = json_decode($user, true);
                array_push($project_data['commented_user'],$data['user_id']);
            }
        }
        $project_data['commented_user'] = array_values(array_unique($project_data['commented_user']));

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
        $projects = Project::all();
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
                return response()->json(['status_code' => 400, 'msg' => '自分が作成したプロジェクトです', 'flag' => 'my_project']);
            }
            //既存のものがあれば追加しない
            $upsert = ProjectApplication::updateOrCreate(
                ['application_id' => $login_user->id, 'project_id' => $project_data['id'], 'deleted_at' => null],
                ['status' => '1', 'application_id' => $login_user->id, 'author_id' => $project_data['user_id'], 'project_id' => $project_data['id']]
            );
            if($upsert->wasRecentlyCreated) {
                return response()->json(['status_code' => 200, 'msg' => '申請に成功しました', 'flag' => 'applied']);
            } else {
                return response()->json(['status_code' => 400, 'err_msg' => '既に申請済みです', 'flag' => 'unapplied']);
            }
        } catch(\Exception $ex) {
            return response()->json(['status_code' => 400, 'err_msg' => $ex->getMessage()]);
        }
    }

    public function new_comment(Request $request) {
        try{
            $login_user = Auth::user();
            $data = [];
            $data['user_id'] = $login_user['id'];
            $data['project_id'] = $request['project_id'];
            $data['target_user_id'] = $request['target_user_id'];
            $data['comment'] = $request['comment'];
            $new_comment = new Comment();
            $new_comment->fill($data)->save();
            $comments = Comment::where('project_id', $data['project_id'])->get();
            if ($comments) {
                foreach($comments as $comment) {
                    $comment['user'] = User::where('id', $comment['user_id'])->first();
                }
            }
            return response()->json(['status_code' => 200, 'comments' => $comments]);
        } catch(\Exception $ex) {
            return response()->json(['status_code' => 400, 'err_msg' => $ex->getMessage()]);
        }
    }

    public function edit_comment(Request $request) {
        try {
            $login_user = Auth::user();
            $comment_id = $request['comment_id'];
            $target_comment = Comment::where('user_id', $login_user['id'])->where('id', $comment_id)->first();
            if(!$target_comment) {
                $display_comments = Comment::where('project_id', $request['project_id'])->get();
                return response()->json(['status_code' => 200, 'comments' => $display_comments]);
            }
            //fillするために空配列作成
            $data = [];
            $data['user_id'] = $login_user['id'];
            $data['project_id'] = $request['project_id'];
            $data['target_user_id'] = $request['target_user_id'];
            $data['comment'] = $request['comment'];
            $target_comment->fill($data);
            if($target_comment->isDirty()) {
                $target_comment->save();
            }
            $display_comments = Comment::where('project_id', 1)->get();
            return response()->json(['status_code' => 200, 'comments' => $display_comments]);
        } catch(\Exception $ex) {
            return response()->json(['status_code' => 400, 'err_msg' => $ex->getMessage()]);
        }
    }

    public function delete_comment(Request $request) {
        try {
            $target_comment = Comment::where('id', $request['comment_id'])->first();
            $project_id = $target_comment['project_id'];
            $target_comment->delete();
            $comments = Comment::where('project_id', $project_id)->get();
            if ($comments) {
                foreach($comments as $comment) {
                    $comment['user'] = User::where('id', $comment['user_id'])->first();
                }
            }
            return response()->json(['status_code' => 200, 'comments' => $comments]);
        } catch(\Exception $ex) {
            return response()->json(['status_code' => 400, 'err_msg' => $ex->getMessage()]);
        }
    }

    public function create_project(Request $request) {
        try {
            $user = Auth::user();
            $datas = $request->all();
            $datas['user_id'] = $user->id;
            $datas['status'] = '募集中';
            $datas['project_detail'] = !empty($datas['project_detail']) ? $datas['project_detail'] : '';
            $datas['max_years_old'] = !empty($datas['max_years_old']) ? $datas['max_years_old'] : 0;
            $datas['minimum_years_old'] = !empty($datas['minimum_years_old']) ? $datas['minimum_years_old'] : 0;
            $datas['remarks'] = !empty($datas['remarks']) ? $datas['remarks'] : '';
            $datas['work_frequency'] = !empty($datas['work_frequency']) ? $datas['work_frequency'] : null;
            $datas['number_of_application'] = (int)str_replace('人', '', $datas['number_of_application']);
            if ($datas['minimum_experience'] == '未経験可') { $datas['minimum_experience'] = 0; }
            if ($datas['minimum_experience'] == '~1年') { $datas['minimum_experience'] = 1; }
            if ($datas['minimum_experience'] == '~2年') { $datas['minimum_experience'] = 2; }
            if ($datas['minimum_experience'] == '~3年') { $datas['minimum_experience'] = 3; }
            if ($datas['minimum_experience'] == '4年以上') { $datas['minimum_experience'] = 4; }
            $datas['minimum_experience'] = str_replace('人', '', $datas['minimum_experience']);
            $img = $datas['project_image'];
            $datas['project_image'] = NULL;
            // プロジェクトインスタンスを作成
            $project_instance = Project::create($datas);
            //作成したprojectのurl_codeを生成
            $project_instance['url_code'] = hash('crc32', $project_instance['id']);
            // プロジェクト画像保存処理
            if(!empty($img)) {
                $url_code = $project_instance['url_code'];
                $now = Carbon::now('Asia/Tokyo');
                //画像名は年月日時分秒にして被らないようにする
                $image_name = $now->year.$now->month.$now->day.$now->hour.$now->minute.$now->second.'.jpg';
                //画像を保存するディレクトリを作成
                $dir = $user->url_code.'/project/'.$url_code;
                $path = storage_path('app').'/images/'.$dir;
                if (!file_exists($path)) {
                    Storage::disk('images')->makeDirectory($dir);
                }

                //現状の画像ファイルは削除処理
                $files = Storage::allFiles('images/'.$dir);
                if($files) {
                    foreach($files as $f) {
                        Storage::delete($f);
                    }
                }
                // デコード処理
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace('data:image/jpeg;base64,', '', $img);
                $img = str_replace('data:image/jpg;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $fileData = base64_decode($img);

                // storageに保存
                Storage::disk('images')->put('/'.$dir.'/'.$image_name, $fileData);

                // ファイル名をDBに保存
                $project_instance['project_image'] = $image_name;
                $project_instance->save();
            }
            return response()->json(['status_code' => 200]);
        } catch (\Exception $ex) {
            return response()->json(['status_code' => 400, 'err_msg' => $ex->getMessage()]);
        }
    }

    public function edit_project(Request $request) {
        try {
            $datas = $request->all();
            $user = Auth::user();
            //編集するプロジェクト
            $target_project_data = Project::find($datas['project_id']);
            $datas['number_of_application'] = (int)str_replace('人', '', $datas['number_of_application']);
            if ($datas['minimum_experience'] == '未経験可') { $datas['minimum_experience'] = 0; }
            if ($datas['minimum_experience'] == '~1年') { $datas['minimum_experience'] = 1; }
            if ($datas['minimum_experience'] == '~2年') { $datas['minimum_experience'] = 2; }
            if ($datas['minimum_experience'] == '~3年') { $datas['minimum_experience'] = 3; }
            if ($datas['minimum_experience'] == '4年以上') { $datas['minimum_experience'] = 4; }
            $datas['minimum_experience'] = str_replace('人', '', $datas['minimum_experience']);
            $img = $datas['project_image'];
            $datas['project_image'] = NULL;
            if(!empty($img)) {
                $url_code = $target_project_data['url_code'];
                $now = Carbon::now('Asia/Tokyo');
                //画像名は年月日時分秒にして被らないようにする
                $image_name = $now->year.$now->month.$now->day.$now->hour.$now->minute.$now->second.'.jpg';
                //画像を保存するディレクトリを作成
                $dir = $user->url_code.'/project/'.$url_code;
                $path = storage_path('app').'/images/'.$dir;
                if (!file_exists($path)) {
                    Storage::disk('images')->makeDirectory($dir);
                }
                //現状の画像ファイルは削除処理
                $files = Storage::allFiles('images/'.$dir);
                if($files) {
                    foreach($files as $f) {
                        Storage::delete($f);
                    }
                }
                // デコード処理
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace('data:image/jpeg;base64,', '', $img);
                $img = str_replace('data:image/jpg;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $fileData = base64_decode($img);
                // storageに保存
                Storage::disk('images')->put('/'.$dir.'/'.$image_name, $fileData);
                // ファイル名をDBに保存
                $datas['project_image'] = $image_name;
            }
            $target_project_data->fill($datas);
            $target_project_data->save();
            return response()->json(['status_code' => 200]);
        } catch (\Exception $ex) {
            return response()->json(['status_code' => 400, 'err_msg' => $ex->getMessage()]);
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
