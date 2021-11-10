@extends('template.base')
@section('individual_stylesheet')
<link rel="stylesheet" href="/css/top.css">
@endsection
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