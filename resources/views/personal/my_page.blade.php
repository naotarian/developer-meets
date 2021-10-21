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
      <p class="mypage_title"><i class="fas fa-tasks icon_color mr1"></i>プロジェクト参加履歴</p>
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
      </div>
      @if (session('withdrawal_message'))
        <div class="flash_message">
            {{ session('withdrawal_message') }}
        </div>
        @php session()->forget('withdrawal_message') @endphp
      @endif
      @if (session('nothing_data'))
        <div class="flash_message">
            {{ session('nothing_data') }}
        </div>
        @php session()->forget('nothing_data') @endphp
      @endif
      <p class="mypage_title"><i class="fas fa-clipboard-list icon_color mr1"></i>掲載中プロジェクト</p>
      <div class="row">
        @foreach($now_available_projects as $key => $project)
        <div class="col-sm-6 mb2">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">{{$project->project_name}}</h5>
              <p class="card-text">{{$project->project_detail}}</p>
              <a href="#" class="btn btn-primary">このプロジェクトについて</a>
              <a href="/application_list/{{$project->id}}" class="btn btn-primary">参加申請</a>
              <button type="submit" class="btn btn-outline-success" data-toggle="modal" data-target="#withdrawalModalCenter{{$key}}">掲載終了</button>
            </div>
          </div>
        </div>
        {{--ここからmodal--}}
        <div class="modal fade" id="withdrawalModalCenter{{$key}}" tabindex="-1" role="dialog" aria-labelledby="withdrawalModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">プロジェクト名 : {{$project->project_name}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                このプロジェクトの掲載を終了しますか？
              </div>
              <div class="modal-footer">
                {{--
              <input type="hidden" name="project_info" value="{{$now}}">
                <button type="submit" class="btn btn-primary">掲載を終了する</button>
                --}}
                <a href="/withdrawal/{{$project->id}}" class="btn btn-primary">掲載取りやめ</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
              </div>
            </div>
          </div>
        </div>{{--closeModal--}}
        @endforeach
      </div>
      @if (session('delete_message'))
        <div class="flash_message">
            {{ session('delete_message') }}
        </div>
        @php session()->forget('delete_message') @endphp
      @endif
      
      {{--自分のページのみ表示--}}
      @if($display_flag)
      <p class="mypage_title"><i class="fas fa-clipboard-list icon_color mr1"></i>参加申請中プロジェクト</p>
      <div class="row">
        @foreach($now_applications as $key => $now)
        <div class="col-sm-6 mb2">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">{{$now->project_name}}</h5>
              <p class="card-text">{{$now->project_detail}}</p>
              <a href="#" class="btn btn-primary">このプロジェクトについて</a>
              <button type="submit" class="btn btn-outline-success" data-toggle="modal" data-target="#cancelModalCenter{{$key}}">参加申請取り消し</button>
              <!--<a href="/application_list" class="btn btn-primary">参加申請取り消し</a>-->
            </div>
          </div>
        </div>
        
        <div class="modal fade" id="cancelModalCenter{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                {{Form::open(['route' => 'cancel', 'method' => 'post', 'enctype' => 'multipart/form-data'])}}
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">プロジェクト名 : {{$now->project_name}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                このプロジェクトへの参加申請をキャンセルしますか？
              </div>
              <div class="modal-footer">
              <input type="hidden" name="project_info" value="{{$now}}">
                <button type="submit" class="btn btn-primary">参加申請をキャンセルする</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
              </div>
              {{Form::close()}}
            </div>
          </div>
        </div>{{--closeModal--}}
        @endforeach
      </div>
      @endif
    </div>{{--myTabContent--}}
    
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