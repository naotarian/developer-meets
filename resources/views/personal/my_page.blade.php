@extends('template.base')
@section('individual_stylesheet')
<link rel="stylesheet" href="/css/personal/my_page.css">
<link rel="stylesheet" href="/css/common.css">
@endsection
@section('contents')

    
<div class="contents">
  <div class="left_bar card pconly">
      <div class="nav flex-column nav-pills my_nav card-body" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a href="/get_request_image?id={{$login_user_infomation['url_code']}}&name={{$login_user_infomation['icon_image']}}&dir=icon" data-lightbox="user_icon" data-title="アイコン画像拡大">
          <img src="/get_request_image?id={{$login_user_infomation['url_code']}}&name={{$login_user_infomation['icon_image']}}&dir=icon" style="width:200px;">
        </a>
      <ul class="list-group list-group-flush">
        <li class="list-group-item"><a class="cg" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
        <li class="list-group-item"><a class="cg" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false"><i class="fa fa-address-card"></i>Profile</a></li>
        <li class="list-group-item"><a class="cg" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false"><i class="fa fa-cog"></i>Settings</a></li>
      @if($login_user_infomation['id'] == 1)
       <li class="list-group-item"><a class="cg" href="/admin">管理ページ</a></li>
      @endif
      </ul>
      </div>
    </div>
    <div class="sp_icon sponly">
      <a href="/get_request_image?id={{$login_user_infomation['url_code']}}&name={{$login_user_infomation['icon_image_sp']}}&dir=icon" data-lightbox="user_icon" data-title="アイコン画像拡大">
        <img src="/get_request_image?id={{$login_user_infomation['url_code']}}&name={{$login_user_infomation['icon_image_sp']}}&dir=icon">
      </a>
      <p class="p1 fwb">{{$login_user_infomation->user_name}}</p>
    </div>
    <div class="my_page_sp_menu sponly">
      <ul class="list-group list-group-flush">
        <li class="list-group-item"><a class="cg" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
        <li class="list-group-item"><a class="cg" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false"><i class="fa fa-address-card"></i>Profile</a></li>
        <li class="list-group-item"><a class="cg" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false"><i class="fa fa-cog"></i>Settings</a></li>
      @if($login_user_infomation['id'] == 1)
        <li class="list-group-item"><a href="/admin">管理ページ</a></li>
      @endif
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
        @if (session('withdrawal_message'))
          <div class="flash_message">
              {{ session('withdrawal_message') }}
          </div>
          @php session()->forget('withdrawal_message') @endphp
        @endif
        @if (session('edit_project_message'))
          <div class="flash_message">
              {{ session('edit_project_message') }}
          </div>
          @php session()->forget('edit_project_message') @endphp
        @endif
        {{--
        @if (session('nothing_data'))
          <div class="flash_message">
              {{ session('nothing_data') }}
          </div>
          @php session()->forget('nothing_data') @endphp
        @endif
        --}}
        <p class="mypage_title"><i class="fas fa-clipboard-list icon_color mr1"></i>掲載中プロジェクト</p>
        <div class="row">
          @foreach($now_available_projects as $key => $project)
          <div class="col-sm-6 mb2">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">{{$project->project_name}}</h5>
                <p class="card-text">{{$project->project_detail}}</p>
                <a href="/seek/detail/{{$project->id}}" class="btn btn-primary">このプロジェクトについて</a>
                <a href="/application_list/{{$project->id}}" class="btn btn-primary">参加申請</a>
                <a href="/project/edit/{{$project->id}}" class="btn btn-primary">編集</a>
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
                {{--
                <p class="card-text">{{$now->project_detail}}</p>
                --}}
                <div class="card-text">{{$now->project_detail}}</div>
                <a href="/seek/detail/{{$now->project_id}}" class="btn btn-primary">このプロジェクトについて</a>
                <button type="submit" class="btn btn-outline-success" data-toggle="modal" data-target="#cancelModalCenter{{$key}}">参加申請取り消し</button>
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
          
          
          </div>
        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
          @if($display_flag)
            <a href="/edit_proifile/{{$login_user_infomation['id']}}" class="btn btn-primary">編集</a>
          @endif
          
          <dl class="my_infomations pconly">
            <dt>ユーザー名</dt>
            <dd>{{$login_user_infomation->user_name}}<br>
            <dt>性別</dt>
            <dd>{{$login_user_infomation->sex}}</dd>
            <dt>年齢</dt>
            <dd>{{$login_user_infomation->age}}歳</dd>
            <dt>一言コメント</dt>
            <dd>{{$login_user_infomation->comment}}</dd>
            <dt>エンジニア歴</dt>
            <dd>{{$login_user_infomation->engineer_history}}年</dd>
            <dt>URL</dt>
            <dd><a href="{{$login_user_infomation->free_url}}" target="_blank">{{$login_user_infomation->free_url}}</a></dd>
            <dt>プロフィール</dt>
            <dd>{{$login_user_infomation->self_introduction}}</dd>
          </dl>
        </div>
        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">...</div>
        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
      </div>
    </div>
  </div>
</div>

<br>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

@endsection