@extends('template.base')
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
@section('title', 'プロジェクト作成ページ|Developer-Meets')
@section('contents')
<div id="project_edit"></div>
<script src="{{ mix('/js/components/Pages/ProjectEditPage.js') }}"></script>
@endsection