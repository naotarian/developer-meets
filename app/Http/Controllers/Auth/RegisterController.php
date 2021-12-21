<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\TemporaryRegistration;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use App\Mail\EmailMainRegister;
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
        $user = TemporaryRegistration::create([
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
    if ( !TemporaryRegistration::where('email_verify_token',$email_token)->exists() )
    {
      return view('auth.main.register')->with('message', '無効なトークンです。');
    } else {
      $user = TemporaryRegistration::where('email_verify_token', $email_token)->first();
      // 本登録済みユーザーか
      if(User::where('email',$user['email'])->exists()) {
        return view('auth.main.register')->with('message', 'すでに本登録されています。ログインして利用してください。');
      }
      $age = [];
      for($i = 18; $i <= 70; $i++) {
          $age[$i] = $i;
      }
      return view('auth.main.register', compact('email_token', 'age'));
    }
  }
    
    public function mainCheck(Request $request)
  {
    $datas = $request->all();
    $messages = [
        'required' => ' :attributeを入力してください',
        'age.integer' => '年齢が不正な形式です。',
        'age.between' => '年齢は16~99までで登録してください。',
        'engineer_history.integer' => 'エンジニア歴が不正な値です。',
        'doui.in' => '利用規約に同意いただいてからの登録となります。',
    ];
    $validator = Validator::make($datas,[
          'user_name' => 'required|unique:users,user_name,NULL,id,deleted_at,NULL|max:255',
          'age' => 'required|integer|between:16,99',
          'engineer_history' => 'required|integer|between:0,5',
          'doui' => Rule::in(['on']),
        ],$messages);
    if($validator->fails()){
        return back()->withErrors($validator)->withInput();
    }
    //データ保持用
    $email_token = $request->email_token;
    $user = new User();
    $user->user_name = $request->user_name;
    $user->age = $request->age;
    $user->engineer_history = $request->engineer_history . '年';
    $user->sex = $request->sex;


    return view('auth.main.register_check', compact('user','email_token'));
  }
    
    public function mainRegister(Request $request)
  {
    if (!TemporaryRegistration::where('email_verify_token',$request['email_token'])->exists()) {
      return view('auth.main.register')->with('message', '無効なトークンです。');
      
    }
    
    $add_data = TemporaryRegistration::select(['email', 'password'])->where('email_verify_token',$request['email_token'])->orderBy('created_at', 'desc')->first();
    $user = new User();
    $user->user_name = $request->user_name;
    $user->sex = $request->sex;
    $user->age = $request->age;
    $user->engineer_history = $request->engineer_history;
    $user->email = $add_data['email'];
    $user->password = $add_data['password'];
    $user->save();
    $user->url_code = hash('crc32', $user->id);
    $user->save();
    TemporaryRegistration::where('email_verify_token',$request['email_token'])->delete();
    $email = new EmailMainRegister($user);
    Mail::to($user->email)->send($email);
    return view('auth.main.registered');
  }
}
