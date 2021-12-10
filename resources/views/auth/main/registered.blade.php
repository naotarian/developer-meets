@extends('layouts.app')
@section('head_content')
<meta http-equiv="refresh" content="3; url=/">
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">本会員登録完了</div>
                    <div class="card-body">
                        <p>本会員登録が完了しました。</p>
                        3秒後にTOPページに移動します。
                        {{--
                        <a href="{{url('/login')}}" class="sg-btn">ログインはこちら</a>
                        --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection