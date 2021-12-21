@extends('template.base')
@section('individual_stylesheet')
<link rel="stylesheet" href="/css/make_project.css">
@endsection
@section('contents')

<div class="contents">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="page_title"><i class="fas fa-user"></i><span style="margin-left: 1rem;">ユーザー登録</span></div>
    {{--
        {{ Form::open(['action' => 'Auth\RegisterController@register', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
    --}}
        {{Form::open(['route' => 'register.main.check', 'method' => 'post', 'enctype' => 'multipart/form-data'])}}
    <div class="main_contents">

        
        <div class="inner contact">
                <!-- Form Area -->
                <div class="contact-form">
                    <!-- Form -->
                        <!-- Left Inputs -->
                        <input type="hidden" name="email_token" value="{{ $email_token }}">
                        <div class="col-xs-6 wow animated slideInLeft flex-form mt2" data-wow-delay=".5s">
                            <!-- Name -->
                            {{Form::text('user_name', null, ['class' => 'form', 'id' => 'user_name', 'placeholder' => 'ユーザー名'])}}
                            {{Form::select('sex', ['男性' => '男性', '女性' => '女性', 'その他' => 'その他'], 'ordinarily', ['class' => 'form','id' => 'sex'])}}
                        </div>
                        {{--
                        <div class="col-xs-6 wow animated slideInRight flex-form mt2" data-wow-delay=".5s">
                            <!-- Name -->
                            {{Form::password('password', ['class' => 'form','id' => 'password', 'placeholder' => 'パスワード'])}}
                            {{Form::password('password_confirmation', ['class' => 'form','id' => 'password_confirm', 'placeholder' => 'パスワード確認'])}}
                        </div>
                        --}}
                        <div class="col-xs-6 wow animated slideInRight flex-form mt2" data-wow-delay=".5s">
                            {{Form::select('age', $age, 'ordinarily', ['class' => 'form','id' => 'age', 'placeholder' => '年齢'])}}
                            {{Form::select('engineer_history', ['0' => 'なし', '1' => '~1年', '2' => '~2年', '3' => '~3年', '4' => '~4年', '5' => '~5年', '5' => 'それ以上'], 'ordinarily', ['class' => 'form','id' => 'engineer_history', 'placeholder' => 'エンジニア歴'])}}
                        </div>
                        <div class="col-xs-6 wow animated slideInLeft mt2" data-wow-delay=".5s" style="text-align: center;">
                            <input type="hidden" name="doui" value="off">
                            <p><a href="">利用規約はこちら</a></p>
                            {{Form::checkbox('doui', 'on', false, ['id' => 'doui', 'style' => 'transform:scale(2.0);margin-right: 1rem;'])}}{{Form::label('doui','利用規約に同意する')}}
                        </div>
                        {{--
                        <div class="col-xs-6 wow animated slideInLeft flex-form mt2" data-wow-delay=".5s">
                            {{Form::email('email', null, ['class' => 'form','id' => 'email','placeholder' => 'Eメール'])}}
                        </div>
                        --}}
                        <div class="relative fullwidth col-xs-12">
                            <button type="submit" id="submit" name="submit" class="form-btn semibold">登録する</button> 
                        </div>
                        <div class="clear"></div>

                    <div class="mail-message-area">
                        <div class="alert gray-bg mail-message not-visible-message">
                            <strong>Thank You !</strong> Your email has been delivered.
                        </div>
                    </div>

                </div><!-- End Contact Form Area -->
            </div><!-- End Inner -->


<center> Visit Developer's Website <a href="http://shuvohabib.com" target="blank">Shuvo Habib </a> </center>
    </div>
        {{Form::close()}}
</div>
@endsection