@extends('template.base')
@section('individual_stylesheet')
<link rel="stylesheet" href="/css/personal/my_page.css">
<link rel="stylesheet" href="/css/common.css">
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
@section('title', 'ユーザー情報ページ|Developer-Meets')
@section('contents')
<div class="contents">
    <div class="grid_wrapper">
        <div class="profile_card">
            <div class="card" style="width: 18rem;">
              <a href="/get_request_image?id={{$target_user['url_code']}}&name={{$target_user['icon_image']}}&dir=icon" data-lightbox="user_icon" data-title="アイコン画像拡大">
                <img src="/get_request_image?id={{$target_user['url_code']}}&name={{$target_user['icon_image']}}&dir=icon" style="width:100%;">
              </a>
              <div class="card-body">
                <h5 class="card-title">{{$target_user->user_name}}</h5>
                <p class="card-text">{{$target_user->comment}}</p>
              </div>
              <ul class="list-group list-group-flush">
                @if($target_user->age)
                <li class="list-group-item"><span class="small_title">年齢<br></span>{{$target_user->age}}歳</li>
                @endif
                @if($target_user->engineer_history)
                <li class="list-group-item"><span class="small_title">エンジニア歴<br></span>{{$target_user->engineer_history}}</li>
                @endif
                @if($target_user->free_url)
                <li class="list-group-item"><a href="{{$target_user->free_url}}" target="_blank" style="color: #747373;">{{$target_user->free_url}}</a></li>
                @endif
                @if($target_user->self_introduction)
                <li class="list-group-item">{{$target_user->self_introduction}}</li>
                @endif
              </ul>
            </div>
        </div>
      <div class="main_page_content">
          <div class="sp_icon sponly">
            <a href="/get_request_image?id={{$target_user['url_code']}}&name={{$target_user['icon_image']}}&dir=icon" data-lightbox="user_icon" data-title="アイコン画像拡大">
              <img src="/get_request_image?id={{$target_user['url_code']}}&name={{$target_user['icon_image']}}&dir=icon">
            </a>
            <p class="p1 fwb" style="margin-bottom: 0;">{{$target_user->user_name}}<br><span class="comment_sp">{{$target_user->comment}}</span></p>
          </div>
          <div id="profile_ac" class="sponly">詳しく</div>
          <div class="profile_ac">
            <div class="other_profile">
              @if($target_user->age)
              <div class="other_items"><span class="comment_sp">年齢<br></span>{{$target_user->age}}歳</div>
              @endif
              @if($target_user->engineer_history)
              <div class="other_items"><span class="comment_sp">エンジニア歴<br></span>{{$target_user->engineer_history}}</div>
              @endif
              @if($target_user->self_introduction)
              <div class="other_items free_url">{{$target_user->self_introduction}}</div>
              @endif
              @if($target_user->free_url)
              <div class="other_items free_url"><span class="comment_sp">外部URL<br></span><a href="{{$target_user->free_url}}" target="_blank">{{$target_user->free_url}}</a></div>
              @endif
            </div>
          </div>
        <div class="row center sidebar_fixed">
          <div class="col-9 spmt4">
            <div class="tab-content" id="v-pills-tabContent">
              <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                <p class="mypage_title"><i class="fas fa-tasks icon_color mr1"></i>プロジェクト参加履歴</p>
              <div class="row">
                @if(count($join_projects) != 0)
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
                @else
                プロジェクト参加履歴がありません。
                @endif
              </div>
              <p class="mypage_title"><i class="fas fa-clipboard-list icon_color mr1"></i>掲載中プロジェクト</p>
              <div class="row">
                @if(count($join_projects) != 0)
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
                @else
                現在掲載中のプロジェクトはありません。
                @endif
              </div>
          </div>
      </div>
    </div>
  </div>
</div>

<br>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
@endsection
@section('scripts')
$('#profile_ac').click(function() {
if($('.profile_ac').css('display') == 'none') {
  $('#profile_ac').text('閉じる');
} else {
  $('#profile_ac').text('詳しく');
}
$('.profile_ac').slideToggle();
});
@endsection