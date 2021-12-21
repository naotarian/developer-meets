@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">本会員登録確認</div>
@if($errors->any())
            <div class="error">
                <strong>【内容にエラー】</strong><br>
                <dl>
                    <dt>下記項目をご確認ください。</dt>
                @foreach ($errors->all() as $error)
                    <dd>{{ $error }}</dd>
                @endforeach
                </dl>
            </div>
        @endif
                <div class="card-body">
                    {{Form::open(['route' => 'register.main.registered', 'method' => 'post', 'enctype' => 'multipart/form-data'])}}
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">名前</label>
                            <div class="col-md-6">
                                <span class="">{{$user->user_name}}</span>
                                <input type="hidden" name="user_name" value="{{$user->user_name}}">
                                <input type="hidden" name="email_token" value="{{$email_token}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">年齢</label>
                            <div class="col-md-6">
                                <span class="">{{$user->age}}歳</span>
                                <input type="hidden" name="age" value="{{$user->age}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">性別</label>
                            <div class="col-md-6">
                                <span class="">@if($user->sex == 1) 男 @elseif($user->sex == 2)女@elseその他@endif</span>
                                <input type="hidden" name="sex" value="{{$user->sex}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">エンジニア歴</label>
                            <div class="col-md-6">
                                <span class="">{{$user->engineer_history}}程度</span>
                                <input type="hidden" name="engineer_history" value="{{$user->engineer_history}}">
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    本登録
                                </button>
                                <a href="/register/verify/{{$email_token}}" class="btn btn-primary">
                                    戻る
                                </a>
                            </div>
                        </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection