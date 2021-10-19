<?php

namespace App\Http\Controllers;
use App\Project;
use App\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    
    public function __construct () {
        $this->gender = config('app.gender');
        $this->gender = config('app.gender');
        $this->purposes = config('app.purposes');
        $this->tools = config('app.tools');
        $this->languages = config('app.languages');
    }
    public function seek_project(Request $request) {
        $seek_datas = $request->all();
        //nullは指定なし扱い
        if($seek_datas['language'] == null) {
            $seek_datas['language'] = 99;
        }
        if($seek_datas['purpose'] == null) {
            $seek_datas['purpose'] = 99;
        }
        if($seek_datas['gender'] == null) {
            $seek_datas['gender'] = 0;
        }
        //言語と目的で絞り込み
        if($seek_datas['purpose'] == 99 && $seek_datas['language'] == 99) {
            $projects = Project::all();
        } elseif($seek_datas['purpose'] == 99) {
            $projects = Project::where('language', $seek_datas['language'])->get();
        } elseif($seek_datas['language'] == 99) {
            $projects = Project::where('purpose', $seek_datas['purpose'])->get();
        } else {
            $projects = Project::where('purpose', '=', $seek_datas["purpose"])->where(function($query) use ($seek_datas) {
                    $query->where('language', '=', $seek_datas["language"])
                    ->orWhere('sub_language', '=', $seek_datas["language"]);
                })->get();
        }
        /*
        男女指定があった場合はフィルターかける
        values()でindex振り直し
        */
        if($seek_datas['gender'] != 0) {
            if($seek_datas['gender'] == 2) {
                //女性指定
                $projects = $projects->filter(function ($value, $key) {
                    return $value['men_and_women'] == 2;
                })->values();
            } else {
                //男性指定
                $projects = $projects->filter(function ($value, $key) {
                    return $value['men_and_women'] == 1;
                })->values();
            }
        }

        //表示用データ生成
        foreach($projects as $project) {
            $project->purpose = $this->purposes[$project->purpose];
            $project->men_and_women = $this->gender[$project->men_and_women];
            $project->tools = $this->tools[$project->tools];
            $project->language = $this->languages[$project->language];
            $project->sub_language = $this->languages[$project->sub_language];
            $project->year = $project->minimum_years_old . '歳~' . $project->max_years_old . '歳';
            $project->user = User::where('id', $project->user_id)->first();
        }
        
        return response()->json(
            ['status' => true, 'datas' => $projects],
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );
  
        
    }
}
