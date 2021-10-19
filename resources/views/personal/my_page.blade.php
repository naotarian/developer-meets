@extends('template.base')
@section('individual_stylesheet')
<link rel="stylesheet" href="/css/personal/my_page.css">
@endsection
@section('contents')

<div class="contents">
    <dl class="my_infomations">
      <dt>ユーザー名</dt>
      <dd>{{$login_user_infomation->user_name}}<br>
      複数行でも崩れません。</dd>
      
      
      <dt>性別</dt>
      <dd>{{$login_user_infomation->sex}}</dd>
      <dt>年齢</dt>
      <dd>{{$login_user_infomation->age}}歳</dd>
    
      <dt>一言コメント</dt>
      <dd>{{$login_user_infomation->comment}}</dd>
      <dt>エンジニア歴</dt>
      <dd>{{$login_user_infomation->engineer_history}}年</dd>
      <dt>URL</dt>
      <dd>{{$login_user_infomation->free_url}}</dd>
      
      
      
      
      <dt>プロフィール</dt>
      <dd>{{$login_user_infomation->self_introduction}}</dd>
    <dl>
</div>
@endsection