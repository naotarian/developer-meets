@extends('template.base')
@section('individual_stylesheet')
<link rel="stylesheet" href="/css/top.css">
@endsection
@section('contents')

<div class="contents">
    <div class="main_visual">
        <div class="btn_area_top pconly">
            <a href="seek" class="btn-animation-01"><span>プロジェクトを探す<span></a>
            <a href="make" class="btn-animation-02"><span>プロジェクトを作る<span></a>
        </div>
    </div>
    <div class="context">
        <h1>思考を合わせて<ruby>形<rt style="font-size: 1rem;">コード</rt></ruby>にしよう。</h1>
        @guest
            <ul class="auth">
                <li>
                   <div class="button20">
                      <a class="nav-link" href="{{ route('login') }}">ログイン</a>
                    </div>
                </li>
                <li>
                   <div class="button20">
                      <a class="nav-link" href="{{ route('register') }}">新規作成</a>
                    </div>
                </li>
                <!--<li><a href="" class="btn btn-flat"><span>新規登録</span></a></li>-->
            </ul>
        @endguest
        @auth
        <ul class="auth">
                <li>
                   <div class="button20">
                      <!--<a href="">ログアウト</a>-->
                      <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        ログアウト
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    </div>
                </li>
                <!--<li><a href="" class="btn btn-flat"><span>新規登録</span></a></li>-->
            </ul>
        @endauth
    </div>


    <div class="area" >
        <ul class="circles">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
        </ul>
    </div>
</div>
@endsection