<?php

namespace App\Http\Library;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
class SaveImage
{


    public function __construct()
    {
        
    }
    /*
    引数1(array) : formリクエスト
    引数2(string) : 画像のinputname
    引数3(string) : 保存するディレクトリ名
    引数4(array) : ログイン中ユーザー情報
    引数5(string) : projectのurl_code(プロジェクト画像保存dir)
    
    引数5が0 → ユーザーアイコン設定
    引数5がstring → project画像設定
    */
    public function save_image(Request $request, $input_name, $save_dir, $user, $url_code = 0)
    {
        $extension = $request->file($input_name)->getClientOriginalExtension();
        $now = Carbon::now('Asia/Tokyo');
        //画像名は年月日時分秒にして被らないようにする
        $image_name = $now->year . $now->month . $now->day . $now->hour . $now->minute . $now->second . '.' . $extension;
        $image_name_sp = $now->year . $now->month . $now->day . $now->hour . $now->minute . $now->second . '_sp.' . $extension;
        //画像を保存するディレクトリpath
        if($url_code == 0) {
            $path = storage_path('app') . '/images/' . $user->url_code . $save_dir;
        } else {
            $path = storage_path('app') . '/images/' . $user->url_code . $save_dir . '/' . $url_code;
        }
        $fileExists = file_exists($path);
        //なければ作成
        
        if(!$fileExists) {
            if($url_code == 0) {
                Storage::disk('images')->makeDirectory($user->url_code . $save_dir);
            } else {
                Storage::disk('images')->makeDirectory($user->url_code . $save_dir . '/' . $url_code);
            }
        }
        
        //現状の画像ファイルは削除
        if($url_code == 0) {
            $files = Storage::allFiles('images/' . $user->url_code . $save_dir);
        } else {
            $files = Storage::allFiles('images/' . $user->url_code . $save_dir . '/' . $url_code);
        }
        if($files) {
            foreach($files as $f) {
                $del = Storage::delete($f);
            }
        }
        
        if($url_code == 0) {
            $save_path = storage_path('app/images/' . $user->url_code . $save_dir . '/') . $image_name;
            $save_path_sp = storage_path('app/images/' . $user->url_code . $save_dir . '/') . $image_name_sp;
        } else {
            $save_path = storage_path('app/images/' . $user->url_code . $save_dir . '/' . $url_code . '/') . $image_name;
            $save_path_sp = storage_path('app/images/' . $user->url_code . $save_dir . '/' . $url_code . '/') . $image_name_sp;
        }
        $image = Image::make($request->file($input_name))
                  ->crop(
                         $request->get('image_w'),
                         $request->get('image_h'),
                         $request->get('image_x'),
                         $request->get('image_y')
                       )->resize(128,128) //サムネイル用にリサイズ
                        ->save($save_path);
        $image_sp = Image::make($request->file($input_name))
                  ->crop(
                         $request->get('image_w'),
                         $request->get('image_h'),
                         $request->get('image_x'),
                         $request->get('image_y')
                       )
                        ->save($save_path_sp);
        \Log::info($image_name);
        $image_names['image_name'] = $image_name;
        $image_names['image_name_sp'] = $image_name_sp;
        return $image_names;
    }

}