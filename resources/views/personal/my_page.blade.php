@extends('template.base')
@section('individual_stylesheet')
<link rel="stylesheet" href="/css/personal/my_page.css">
@endsection
@section('contents')

<div class="contents">
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
      <p class="mypage_title">プロジェクト参加履歴</p>
      <div class="row">
        <div class="col-sm-6 mb2">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">プロジェクトタイトル</h5>
              <p class="card-text">プロジェクトの詳細</p>
              <a href="#" class="btn btn-primary">このプロジェクトについて</a>
            </div>
          </div>
        </div>
        <div class="col-sm-6 mb2">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">プロジェクトタイトル</h5>
              <p class="card-text">プロジェクトの詳細</p>
              <a href="#" class="btn btn-primary">このプロジェクトについて</a>
            </div>
          </div>
        </div>
        <div class="col-sm-6 mb2">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">プロジェクトタイトル</h5>
              <p class="card-text">プロジェクトの詳細</p>
              <a href="#" class="btn btn-primary">このプロジェクトについて</a>
            </div>
          </div>
        </div>
        <div class="col-sm-6 mb2">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">プロジェクトタイトル</h5>
              <p class="card-text">プロジェクトの詳細</p>
              <a href="#" class="btn btn-primary">このプロジェクトについて</a>
            </div>
          </div>
        </div>
        <div class="col-sm-6 mb2">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">プロジェクトタイトル</h5>
              <p class="card-text">プロジェクトの詳細</p>
              <a href="#" class="btn btn-primary">このプロジェクトについて</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
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
    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">contact</div>
  </div>
    
</div>
@endsection