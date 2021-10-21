@extends('template.base')
@section('individual_stylesheet')
<link rel="stylesheet" href="/css/seek_project.css">
<link rel="stylesheet" href="/css/project_list.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('contents')

<div class="contents">
    <div class="acodion_seek sponly">
        検索メニュー表示
    </div>
    <div class="search-header">
        <div class="search_icon mr2">
            <i class="fa fa-laptop fa-2x icon_color mr1" aria-hidden="true"></i>
            {{Form::select('language', $datas['languages'], 'null', ['class' => 'form language','id' => 'languages', 'placeholder' => '言語で探す'])}}
        </div>
        <div class="search_icon mr2">
            <i class="fa fa-user fa-2x icon_color mr1" aria-hidden="true"></i>
            {{Form::select('purpose', $datas['purposes'], 'null', ['class' => 'form purpose','id' => 'purposes', 'placeholder' => '目的で探す'])}}
        </div>
        <div class="search_icon mr2">
            <i class="fa fa-male fa-2x icon_color"></i><i class="fa fa-female fa-2x icon_color mr1"></i>
            {{Form::select('gender', $datas['gender'], 'null', ['class' => 'form gender','id' => 'gender', 'placeholder' => '男女構成'])}}
        </div>
        <div class="search_icon mr2"><i class="fa fa-search fa-2x icon_color mr1"></i>{{ Form::button('探す', ['class' => 'btn search-icon', 'type' => 'button']) }}</div>
    </div>
    @if (session('flash_message'))
        <div class="flash_message">
            {{ session('flash_message') }}
        </div>
        @php session()->forget('flash_message') @endphp
    @endif

    <!-- プロジェクトカード差し込み -->
    <div id="project_card"></div>
    <script src="{{ mix('/js/components/Organisms/ProjectCard.js') }}"></script>

   <div class="project_list">
        @foreach($projects as $key => $project)
        <!--<div class="project">-->
        <div class="card p2 mb2">
            <!-- Button trigger modal -->

            <p>{{$project['project_name']}}</p>
            <table class="project_detail_table">
                <tr>
                    <td>募集人数</td>
                    <td>{{$project['number_of_application']}}人</td>
                </tr>
                <tr>
                    <td>男女</td>
                    <td>{{$project['men_and_women']}}</td>
                </tr>
                <tr>
                    <td>経験年数</td>
                    <td>@if($project['minimum_experience'] != 0){{$project['minimum_experience']}}年以上@else未経験歓迎@endif</td>
                </tr>
                <tr>
                    <td>目的</td>
                    <td>{{$project['purpose']}}</td>
                </tr>
                <tr>
                    <td>ソース管理</td>
                    <td>{{$project['tools']}}</td>
                </tr>
                <tr>
                    <td>主要言語</td>
                    <td>{{$project['language']}}</td>
                </tr>
                <tr>
                    <td>年齢</td>
                    <td>{{$project['year']}}</td>
                </tr>

            </table>
            <div class="actions">
                <button type="button" class="detail btn btn-outline-primary">詳細を見る</button>
                <button type="submit" class="btn btn-outline-secondary">質問したい</button>
                <button type="submit" class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModalCenter{{$key}}">参加申請</button>
            </div>{{--actinos--}}
            <div class="att_name">
                <div class="create_user">作成者 : <a href="/user_info/{{$project['user']['user_name']}}">{{$project['user']['user_name']}}</a></div>
            </div>{{--att_name--}}

            <div class="popup">
              <div class="content">
                <p>{{$project['project_detail']}}</p>
                <button id="close" class="close">閉じる</button>
              </div>
            </div>{{--popup(詳細を見るボタン)--}}

            <div class="modal fade" id="exampleModalCenter{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    {{Form::open(['route' => 'application', 'method' => 'post', 'enctype' => 'multipart/form-data'])}}
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">プロジェクト名 : {{$project['project_name']}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    このプロジェクトへの参加を申請しますか？
                  </div>
                  <div class="modal-footer">
                  <input type="hidden" name="project_info" value="{{$project}}">
                    <button type="submit" class="btn btn-primary">申請する</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                  </div>
                  {{Form::close()}}
                </div>
              </div>
            </div>{{--modal (参加申請ボタン)--}}
        </div>
        @endforeach
    </div>
</div>
@section('reed_scripts')
<script src="/js/project_seek.js"></script>
@endsection
@endsection
@section('scripts')
$(function(){
var f = @json($projects);
console.log(f);
    $(document).on('click', '.detail', function(){
        $(this).parent().next().next('.popup')
        .addClass("show")
        .fadeIn();
    });
    $(document).on('click', '.close', function(){
        $(".popup").fadeOut();
    });
});
$('.acodion_seek').click(function() {
    $('.search-header').slideToggle();
    if ($(this).text() === '閉じる') {
        $(this).text('検索メニュー表示');
    } else {
        $(this).text('閉じる');
    }
})
@endsection