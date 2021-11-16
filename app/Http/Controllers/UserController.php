<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
class UserController extends Controller
{
    public function quit() {
        $user = Auth::user();
        // dd($user);
        return view('auth.quit_confirm', ['user' => $user]);
    }
    
    public function quit_post(Request $request) {
        $user = User::where('user_name', $request['user_name'])->first();
        $user->delete();
        return redirect('/');
    }
}
