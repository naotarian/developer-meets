<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/seek';
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
     public function redirectToProvider() {
       return Socialite::driver("github")->redirect();
     }
     
     public function handleProviderCallback() {
   try {
     $user = Socialite::with("github")->user();
   } catch (Exception $e) {
     return redirect('/welcome'); // エラーならウェルカムページに転送
   }

   // nameかnickNameをuserNameにする
   if ($user->getName()) {
     $userName = $user->getName();
   } else {
     $userName = $user->getNickName();
   }

   // mailアドレスおよび名前を保存
   $authUser = User::firstOrCreate([
     'email' => $user->getEmail(),
     'user_name' => $userName
   ]);
   if(!$authUser['url_code']) {
       $authUser['url_code'] = hash('crc32', $authUser['id']);
       $authUser->save();
   }
   auth()->login($authUser); // ログイン
   return redirect()->to('/'); // homeページに転送
 }
    
    public function redirectToTwitterProvider()
   {
       return Socialite::driver('twitter')->redirect();
   }
}
