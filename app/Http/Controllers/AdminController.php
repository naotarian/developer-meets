<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SlideText;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
    
    public function __construct () {
        $this->middleware(function ($request, $next) {
            // ココに書く
            $user = Auth::user();
            if($user['id'] != 1) {
                return redirect('/');
            }
            return $next($request);
        });
    }
    
    public function index() {
        return view('admin.index');
    }
    public function slide_text() {
        $slide_text = SlideText::where('status', 0)->get();
        $slide_text_diasbled = SlideText::where('status', 1)->get();
        $slide_text_sorted = $slide_text->sortBy('sort')->values()->toArray();
        // dd($slide_text);
        return view('admin.slide_text', ['slide_text_sorted' => $slide_text_sorted, 'slide_text_diasbled'=> $slide_text_diasbled]);
    }
    
    public function slide_text_post(Request $request) {
        $new_slide_text = new SlideText();
        $new_slide_text->slide_text = $request->slide_text;
        $new_slide_text->sort = $request->sort;
        if($request->sort <= 0) {
            //status1 : 非表示
            $new_slide_text->status = 1;
        } else {
            //status0 : 表示
            $new_slide_text->status = 0;
        }
        $save = $new_slide_text->save();
        if($save) {
            return redirect('/admin/slide_text');
        } else {
            return redirect('/admin/slide_text')->withInput(['error' => '保存ができませんでした。']);
        }
    }
    public function slide_text_edit($id) {
        $edit_data = SlideText::find($id);
        return view('admin.edit_slide_text', ['edit_data' => $edit_data]);
    }
    
    public function slide_text_edit_post(Request $request) {
        $target_data = SlideText::find($request['slide_text_id']);
        $target_data['slide_text'] = $request['slide_text_edit'];
        $target_data['sort'] = $request['sort'];
        if($request['sort'] <= 0) {
            $target_data['status'] = 1;
        } else {
            $target_data['status'] = 0;
        }
        $save = $target_data->save();
        if($save) {
            return redirect('/admin/slide_text');
        }else {
            return redirect('/admin/slide_text')->withInput('error', 'エラーです');
        }
    }
}
