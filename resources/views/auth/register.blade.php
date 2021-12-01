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
    <div class="page_title" style="color: gray;">仮登録</div>
    <p style="text-align: center;color: grey;">ご入力いただいたメールアドレス宛に、本登録用のURLを添付いたします。<br>パスワードはログイン時に必要になりますので、忘れないようにしてください。</p>
        {{ Form::open(['route' => 'register.pre_check', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
    <div class="main_contents">
        <div class="inner contact">
                <!-- Form Area -->
                <div class="contact-form">
                    <!-- Form -->
                        <div class="col-xs-6 wow animated slideInLeft flex-form mt2" data-wow-delay=".5s">
                            {{Form::email('email', null, ['class' => 'form','id' => 'email','placeholder' => 'Eメール'])}}
                        </div>
                        <!-- Left Inputs -->
                        <div class="col-xs-6 wow animated slideInRight flex-form mt2" data-wow-delay=".5s">
                            <!-- Name -->
                            {{Form::password('password', ['class' => 'form','id' => 'password', 'placeholder' => 'パスワード'])}}
                            {{Form::password('password_confirmation', ['class' => 'form','id' => 'password_confirm', 'placeholder' => 'パスワード確認'])}}
                        </div>
                        
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