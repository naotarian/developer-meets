@extends('template.base')
@section('individual_stylesheet')
<link rel="stylesheet" href="/css/personal/my_page.css">
<link rel="stylesheet" href="/css/common.css">
@endsection
@section('contents')
<div class="contents">
  <div class="left_bar card pconly">
      <div class="nav flex-column nav-pills my_nav card-body" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a href="/get_request_image?id={{$target_user['url_code']}}&name={{$target_user['icon_image']}}&dir=icon" data-lightbox="user_icon" data-title="アイコン画像拡大">
          <img src="/get_request_image?id={{$target_user['url_code']}}&name={{$target_user['icon_image']}}&dir=icon" style="width:200px;">
        </a>
      <ul class="list-group list-group-flush">
        <li class="list-group-item"><a class="cg" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
        <li class="list-group-item"><a class="cg" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false"><i class="fa fa-address-card"></i>Profile</a></li>
      </ul>
      </div>
    </div>
    <div class="sp_icon sponly">
      <a href="/get_request_image?id={{$target_user['url_code']}}&name={{$target_user['icon_image_sp']}}&dir=icon" data-lightbox="user_icon" data-title="アイコン画像拡大">
        <img src="/get_request_image?id={{$target_user['url_code']}}&name={{$target_user['icon_image_sp']}}&dir=icon">
      </a>
      <p class="p1 fwb" style="margin-bottom: 0;">{{$target_user->user_name}}<br><span class="comment_sp">{{$target_user->comment}}</span></p>
    </div>
    <div class="my_page_sp_menu sponly">
      <ul class="list-group list-group-flush">
        <li class="list-group-item"><a class="cg" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
        <li class="list-group-item"><a class="cg" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false"><i class="fa fa-address-card"></i>Profile</a></li>
      </ul>
    </div>
  <div class="row center sidebar_fixed">
    <div class="col-9 spmt4">
      <div class="tab-content" id="v-pills-tabContent">{{--HOME--}}
        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
          <p class="mypage_title"><i class="fas fa-tasks icon_color mr1"></i>プロジェクト参加履歴</p>
        <div class="row">
          @foreach($join_projects as $join_project)
          <div class="col-sm-6 mb2">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">{{$join_project->project_name}}</h5>
                <p class="card-text">{{$join_project->detail}}</p>
                <a href="/seek/detail/{{$join_project->id}}" class="btn btn-primary">このプロジェクトについて</a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        <p class="mypage_title"><i class="fas fa-clipboard-list icon_color mr1"></i>掲載中プロジェクト</p>
        <div class="row">
          @foreach($now_available_projects as $key => $project)
          <div class="col-sm-6 mb2">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">{{$project->project_name}}</h5>
                <p class="card-text">{{$project->project_detail}}</p>
                <a href="/seek/detail/{{$project->id}}" class="btn btn-primary">このプロジェクトについて</a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      
          </div>
        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
          <dl class="my_infomations pconly">
            <dt>ユーザー名</dt>
            <dd>{{$target_user->user_name}}<br>
            <dt>性別</dt>
            <dd>{{$target_user->sex}}</dd>
            <dt>年齢</dt>
            <dd>{{$target_user->age}}歳</dd>
            <dt>一言コメント</dt>
            <dd>{{$target_user->comment}}</dd>
            <dt>エンジニア歴</dt>
            <dd>{{$target_user->engineer_history}}年</dd>
            <dt>URL</dt>
            <dd><a href="{{$target_user->free_url}}" target="_blank">{{$target_user->free_url}}</a></dd>
            <dt>プロフィール</dt>
            <dd>{{$target_user->self_introduction}}</dd>
          </dl>
        </div>
      </div>
    </div>
  </div>
</div>

<br>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

@endsection