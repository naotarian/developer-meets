<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use Carbon\Carbon;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // 'email' => 'required|string|email|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users,email,NULL,id,deleted_at,NULL',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    public function pre_check(Request $request){
        $this->validator($request->all())->validate();
        $request->flashOnly('email');

        $bridge_request = $request->all();
        // password マスキング
        $bridge_request['password_mask'] = '************';

        return view('auth.register_check')->with($bridge_request);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_verify_token' => base64_encode($data['email']),
        ]);

        $email = new EmailVerification($user);
        Mail::to($user->email)->send($email);

        return $user;
    }


    public function register(Request $request)
    {
        event(new Registered($user = $this->create( $request->all() )));

        return view('auth.registered');
    }
    
     public function showForm($email_token)
  {
    // 使用可能なトークンか
    if ( !User::where('email_verify_token',$email_token)->exists() )
    {
      return view('auth.main.register')->with('message', '無効なトークンです。');
    } else {
      $user = User::where('email_verify_token', $email_token)->first();
      // 本登録済みユーザーか
      if ($user->status == config('const.USER_STATUS.REGISTER')) //REGISTER=1
      {
        logger("status". $user->status );
        return view('auth.main.register')->with('message', 'すでに本登録されています。ログインして利用してください。');
      }
      // ユーザーステータス更新
      $user->status = config('const.USER_STATUS.MAIL_AUTHED');
      if($user->save()) {
        return view('auth.main.register', compact('email_token'));
      } else{
        return view('auth.main.register')->with('message', 'メール認証に失敗しました。再度、メールからリンクをクリックしてください。');
      }
    }
  }
    
    public function mainCheck(Request $request)
  {
    $request->validate([
      'user_name' => 'required|unique:users,user_name,NULL,id,deleted_at,NULL|max:255',
      'age' => 'integer|between:16,99',
      'sex' => 'integer|between:1,3',
      'engineer_history' => 'integer|between:0,5',
    ]);
    //データ保持用
    $email_token = $request->email_token;
    $user = new User();
    $user->user_name = $request->user_name;
    $user->age = $request->age;
    $user->engineer_history = $request->engineer_history;
    $user->sex = $request->sex;


    return view('auth.main.register_check', compact('user','email_token'));
  }
    
    public function mainRegister(Request $request)
  {
    // $request->validate([
    //   'user_name' => 'required|unique:users|max:255',
    //   'age' => 'integer|between:16,99',
    //   'sex' => 'integer|between:1,3',
    //   'engineer_history' => 'integer|between:0,5',
    // ]);
    $user = User::where('email_verify_token',$request->email_token)->first();
    $user->status = config('const.USER_STATUS.REGISTER');
    $user->user_name = $request->user_name;
    $user->sex = $request->sex;
    $user->age = $request->age;
    $user->engineer_history = $request->engineer_history;
    $user->save();
    $user->url_code = hash('crc32', $user->id);
    $user->save();

    return view('auth.main.registered');
  }
    
    
    

    // use RegistersUsers;

    // /**
    //  * Where to redirect users after registration.
    //  *
    //  * @var string
    //  */
    // protected $redirectTo = RouteServiceProvider::HOME;

    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    // /**
    //  * Get a validator for an incoming registration request.
    //  *
    //  * @param  array  $data
    //  * @return \Illuminate\Contracts\Validation\Validator
    //  */
    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //     ]);
    // }
    // protected function tentative_validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //     ]);
    // }

    // /**
    //  * Create a new user instance after a valid registration.
    //  *
    //  * @param  array  $data
    //  * @return \App\User
    //  */
    // public function register(Request $request)
    // {
        
    //     $data = $request->all();
    //     $messages = [
    //         'required' => ' :attributeを入力してください',
    //         'user_name.unique' => ':attributeはすでに使用されています。',
    //         'string' => ':attributeは文字で入力してください。',
    //         'email' => ':attributeはメールアドレス形式で入力してください。',
    //         'max' => ':attributeは255文字までで入力してください。',
    //         'integer' => ':attributeは整数で入力してください。',
    //         'sex.integer' => ':attributeを正しく入力してください。',
    //         'age.between' => ':attributeは16~99で入力してください。',
    //         'sex.between' => ':attributeを正しく入力してください。',
    //         'engineer_history.between' => ':attributeを正しく選択してください。',
    //         'engineer_history.integer' => ':attributeを正しく選択してください。',
    //         'password.min' => ':attributeは6文字以上で入力してください。',
    //         'password.confirmed' => ':attribute確認が異なっています。',
    //     ];
    //     $validator = Validator::make($data,[
    //         'user_name' => 'required|unique:users|max:255',
    //         'email' => 'required|unique:users|string|email|max:255',
    //         'age' => 'integer|between:16,99',
    //         'sex' => 'integer|between:1,3',
    //         'engineer_history' => 'integer|between:0,5',
    //         'password' => 'required|min:6|confirmed',
    //         'password_confirmation' => 'required',
    //     ],$messages);
    //     if($validator->fails()){
    //         return back()->withErrors($validator)->withInput();
    //         $messages = array_values($messages);
    //     }
    //     $register = User::create([
    //         'user_name' => $data['user_name'],
    //         'email' => $data['email'],
    //         'password' => Hash::make($data['password']),
    //         'sex' => $data['sex'],
    //         'engineer_history' => $data['engineer_history'],
    //         'age' => $data['age'],
    //     ]);
        
    //     $register['url_code'] = hash('crc32', $register['id']);
    //     $register->save();
    //     return redirect('/');
    // }
    
    // public function pre_check(Request $request){
    //     $this->tentative_validator($request->all())->validate();
    //     //flash data
    //     $request->flashOnly('email');

    //     $bridge_request = $request->all();
    //     // password マスキング
    //     $bridge_request['password_mask'] = '******';

    //     return view('auth.register_check')->with($bridge_request);
    // }
    // protected function create(array $data)
    // {
    //     $user = User::create([
    //         'email' => $data['email'],
    //         'password' => Hash::make($data['password']),
    //         'email_verify_token' => base64_encode($data['email']),
    //     ]);
    //     $email = new EmailVerification($user);
    //     Mail::to($user->email)->send($email);
    //     return $user;
    // }
    
}
