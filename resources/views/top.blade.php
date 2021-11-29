@extends('template.base')
@section('individual_stylesheet')
<link rel="stylesheet" href="/css/top.css">
@endsection
@section('meta_keyword', 'スキル,プログラミング,学習,リリース,アプリ,Web制作,LP作成,Webサービス,Web開発,モバイルアプリ,iOSアプリ,Androidアプリ,共同開発,開発仲間')
@section('meta_description', 'Developer-Meetsはエンジニアのスキルマッチングサービス。気の合う人を募集し、楽しくアプリ制作ができます。')
@section('meta_Author', 'Developer-Meets開発チーム')
@section('meta_Copyright', 'Copyright &copy; 2021 Developer-Meets All Rights Reserved.')
@section('meta_og_image', '')
@section('meta_og_title', 'プログラミング、共同開発ならDeveloper-Meets。アプリ企画からリリースまで協力する仲間を見つけよう。')
@section('meta_og_site_name', 'Developer-Meets')
@section('meta_og_url', 'https://developer-meets.com')
@section('meta_og_description', 'Developer-Meetsはエンジニアのスキルマッチングサービス。気の合う人を募集し、楽しくアプリ制作ができます。')
@section('meta_og_type', 'website')
@section('title', 'プログラミング、共同開発ならDeveloper-Meets。アプリ企画からリリースまで協力する仲間を見つけよう。')
@section('contents')
<div class="contents">
    <!-- バナー（リンクあり） -->
    <a class="news-banner" href="ここにリンクを記入">
        <div class="news-banner__content">
            <p>
                @foreach($slide_text_sorted as $data)
                    <span style="margin-right: 100px;">{{$data['slide_text']}}</span>
                @endforeach
            </p>
        </div>
    </a>
    <div class="context">
        <h1>思考を合わせて<ruby>形<rt style="font-size: 1rem;">コード</rt></ruby>にしよう。</h1>
        <!-- 新規作成ボタン -->
        @guest
            <ul class="auth">
                <li><div class="button20"><a class="nav-link" href="{{ route('register') }}">新規作成</a></div></li>
            </ul>
        @endguest
        <!-- Twitter -->
        <div class="twitter">
        @foreach ($twitter as $twitter)
            {!! $twitter[0] !!}<br>
        @endforeach
        </div>
    </div>
    <!-- 動く背景のやつ -->
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