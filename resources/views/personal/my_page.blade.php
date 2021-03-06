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
@section('title', 'マイページ|Developer-Meets')
@section('contents')
<div class="contents">
    <div class="grid_wrapper">
        <div class="profile_card">
            <div class="card" style="width: 18rem;">
              <a href="/get_request_image?id={{$login_user_infomation['url_code']}}&name={{$login_user_infomation['icon_image']}}&dir=icon" data-lightbox="user_icon" data-title="アイコン画像拡大">
                <img src="/get_request_image?id={{$login_user_infomation['url_code']}}&name={{$login_user_infomation['icon_image']}}&dir=icon" style="width:100%;">
              </a>
              <div class="card-body">
                <h5 class="card-title">{{$login_user_infomation->user_name}}</h5>
                <p class="card-text">{{$login_user_infomation->comment}}</p>
              </div>
              <ul class="list-group list-group-flush">
                @if($login_user_infomation->age)
                <li class="list-group-item"><span class="small_title">年齢<br></span>{{$login_user_infomation->age}}歳</li>
                @endif
                @if($login_user_infomation->engineer_history)
                <li class="list-group-item"><span class="small_title">エンジニア歴<br></span>{{$login_user_infomation->engineer_history}}</li>
                @endif
                @if($login_user_infomation->free_url)
                <li class="list-group-item"><a href="{{$login_user_infomation->free_url}}" target="_blank" style="color: #747373;" class="Item"><span class="Item-Text">{{$login_user_infomation->free_url}}</span></a></li>
                @endif
                @if($login_user_infomation->self_introduction)
                <li class="list-group-item">{{$login_user_infomation->self_introduction}}</li>
                @endif
                @if($display_flag)
                <li class="list-group-item"><a href="/edit_profile/{{$login_user_infomation['id']}}" class="Item"><span class="Item-Text">Edit Profile</span></a></li>
                @endif
                <li class="list-group-item"><a href="/quit" target="_blank" style="color: #747373;" class="Item"><span class="Item-Text">退会する</span></a></li>
              </ul>
              
            </div>
        </div>
      <div class="main_page_content">
          
          <div class="sp_icon sponly">
            <a href="/get_request_image?id={{$login_user_infomation['url_code']}}&name={{$login_user_infomation['icon_image']}}&dir=icon" data-lightbox="user_icon" data-title="アイコン画像拡大">
              <img src="/get_request_image?id={{$login_user_infomation['url_code']}}&name={{$login_user_infomation['icon_image']}}&dir=icon">
            </a>
            <p class="p1 fwb" style="margin-bottom: 0;">{{$login_user_infomation->user_name}}<br><span class="comment_sp">{{$login_user_infomation->comment}}</span></p>
          </div>
          <div id="profile_ac" class="sponly">詳しく</div>
          <div class="profile_ac">
            <div class="other_profile">
              <div class="other_items"><span class="comment_sp">年齢<br></span>{{$login_user_infomation->age}}歳</div>
              <div class="other_items"><span class="comment_sp">エンジニア歴<br></span>{{$login_user_infomation->engineer_history}}</div>
              <div class="other_items free_url self_introduction">{{$login_user_infomation->self_introduction}}</div>
              <div class="other_items free_url"><span class="comment_sp">外部URL<br></span><a href="{{$login_user_infomation->free_url}}" target="_blank" style="color: #747373;">{{$login_user_infomation->free_url}}</a></div>
              <div class="other_items free_url"><a href="/edit_profile/{{$login_user_infomation['id']}}" style="color: #747373;">Edit Profile</a></div>
            </div>
          </div>
        <div class="row center sidebar_fixed">
          <div class="spmt4">
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
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">参加履歴がありません。</h5>
                    <p class="card-text">ここにはあなたが参加したプロジェクト履歴が表示されます。</p>
                    <a href="/seek" class="btn btn-primary">プロジェクトを探しに行く</a>
                  </div>
                </div>
                @endif
              </div>
              @if (session('withdrawal_message'))
                <div class="flash_message">
                    {{ session('withdrawal_message') }}
                </div>
                @php session()->forget('withdrawal_message') @endphp
              @endif
              @if (session('restart_message'))
                <div class="flash_message">
                    {{ session('restart_message') }}
                </div>
                @php session()->forget('restart_message') @endphp
              @endif
              @if (session('edit_project_message'))
                <div class="flash_message">
                    {{ session('edit_project_message') }}
                </div>
                @php session()->forget('edit_project_message') @endphp
              @endif

              <p class="mypage_title"><i class="fas fa-clipboard-list icon_color mr1"></i>掲載中プロジェクト</p>
              <div class="row">
                @if(count($now_available_projects) != 0)
                @foreach($now_available_projects as $key => $project)
                <div class="col-sm-6 mb2">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">{{$project->project_name}}</h5>
                      <p class="card-text">{{$project->project_detail}}</p>
                      <a href="/seek/detail/{{$project->id}}" class="btn btn-primary">このプロジェクトについて</a>
                      <a href="/application_list/{{$project->id}}" class="btn btn-primary">参加申請</a>
                      <a href="/project/edit/{{$project->id}}" class="btn btn-primary">編集</a>
                      @if($project->status == '募集中')
                      <button type="submit" class="btn btn-outline-success" data-toggle="modal" data-target="#withdrawalModalCenter{{$key}}">募集停止</button>
                      @else
                      <button type="submit" class="btn btn-outline-success" data-toggle="modal" data-target="#restart{{$key}}">募集再開</button>
                      @endif
                    </div>
                  </div>
                </div>
                
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
                        このプロジェクトの募集を停止しますか？
                      </div>
                      <div class="modal-footer">
               
                        <a href="/withdrawal/{{$project->id}}" class="btn btn-primary">募集停止</a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal fade" id="restart{{$key}}" tabindex="-1" role="dialog" aria-labelledby="withdrawalModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">プロジェクト名 : {{$project->project_name}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        このプロジェクトの募集を再開しますか？
                      </div>
                      <div class="modal-footer">
               
                        <a href="/restart/{{$project->id}}" class="btn btn-primary">募集再開</a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
                @else
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">掲載中のプロジェクトがありません。</h5>
                    <p class="card-text" style="height: auto;">ここにはあなたが掲載中のプロジェクトが表示されます。<br>全国のエンジニアたちに自分のプロジェクトを公開しましょう。<br>共感を得れば開発仲間を増やし、さらにプロジェクトを発展させるとこができます。</p>
                    <a href="/make" class="btn btn-primary">プロジェクトを作る</a>
                  </div>
                </div>
                @endif
              </div>
              @if (session('delete_message'))
                <div class="flash_message">
                    {{ session('delete_message') }}
                </div>
                @php session()->forget('delete_message') @endphp
              @endif
              
              
              @if($display_flag)
              <p class="mypage_title"><i class="fas fa-clipboard-list icon_color mr1"></i>参加申請中プロジェクト</p>
              <div class="row">
                @if(count($now_applications) != 0)
                @foreach($now_applications as $key => $now)
                <div class="col-sm-6 mb2">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">{{$now->project_name}}</h5>
       
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
                </div>
                @endforeach
                @else
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">現在参加申請中のプロジェクトがありません。</h5>
                    <p class="card-text" style="height: auto;">ここにはあなた現在参加申請中のプロジェクトが表示されます。<br>たくさんのプロジェクトの中から、より興味深いプロジェクトを見つけて参加申請をしてみましょう。</p>
                    <a href="/seek" class="btn btn-primary">プロジェクトを探しに行く</a>
                  </div>
                </div>
                @endif
              </div>
              @endif
                </div>
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