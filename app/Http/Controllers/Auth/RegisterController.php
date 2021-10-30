<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function register(Request $request)
    {
        $data = $request->all();
        $messages = [
            'required' => ' :attributeを入力してください',
            'user_name.unique' => ':attributeはすでに使用されています。',
            'string' => ':attributeは文字で入力してください。',
            'email' => ':attributeはメールアドレス形式で入力してください。',
            'max' => ':attributeは255文字までで入力してください。',
            'integer' => ':attributeは整数で入力してください。',
            'sex.integer' => ':attributeを正しく入力してください。',
            'age.between' => ':attributeは16~99で入力してください。',
            'sex.between' => ':attributeを正しく入力してください。',
            'engineer_history.between' => ':attributeを正しく選択してください。',
            'engineer_history.integer' => ':attributeを正しく選択してください。',
            'password.min' => ':attributeは6文字以上で入力してください。',
            'password.confirmed' => ':attribute確認が異なっています。',
        ];
        $validator = Validator::make($data,[
            'user_name' => 'required|unique:users|max:255',
            'email' => 'required|unique:users|string|email|max:255',
            'age' => 'integer|between:16,99',
            'sex' => 'integer|between:1,3',
            'engineer_history' => 'integer|between:0,5',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
            $messages = array_values($messages);
        }
        $register = User::create([
            'user_name' => $data['user_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'sex' => $data['sex'],
            'engineer_history' => $data['engineer_history'],
            'age' => $data['age'],
        ]);
        
        $register['url_code'] = hash('crc32', $register['id']);
        $register->save();
        return redirect('/');
    }
}
