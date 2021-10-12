@extends('template.base')
@section('individual_stylesheet')
<link rel="stylesheet" href="/css/project_list.css">
@endsection
@section('contents')

<div class="contents">
    <div class="project_list">
        @foreach($projects as $project)
        <div class="project">
            <p>{{$project->project_name}}</p>
            <table class="project_detail_table">
                <tr>
                    <td>募集人数</td>
                    <td>{{$project->number_of_application}}人</td>
                </tr>
                <tr>
                    <td>男女</td>
                    <td>{{$project->men_and_women}}</td>
                </tr>
                <tr>
                    <td>経験年数</td>
                    <td>@if($project->minimum_experience != 0){{$project->minimum_experience}}年以上@else未経験歓迎@endif</td>
                </tr>
                <tr>
                    <td>目的</td>
                    <td>{{$project->purpose}}</td>
                </tr>
                <tr>
                    <td>ソース管理</td>
                    <td>{{$project->tools}}</td>
                </tr>
                <tr>
                    <td>主要言語</td>
                    <td>{{$project->language}}</td>
                </tr>
                <tr>
                    <td>年齢</td>
                    <td>{{$project->year}}</td>
                </tr>
                
            </table>
            <div class="actions">
                <a class="detail btn btn-primary">詳細を見る</a>
                <a class="btn btn-secondary">質問したい</a>
                <a class="btn btn-success">参加申請</a>
            </div>
            <div class="att_name">
                <div class="create_user">作成者 : <a href="#">{{$project->user['user_name']}}</a></div>
            </div>
            <div class="popup">
              <div class="content">
                <p>{{$project->project_detail}}</p>
                <button id="close" class="close">閉じる</button>
              </div>
            </div>
            
        </div>
        @endforeach
        
        
    </div>
</div>
@endsection
@section('scripts')
var detail = $("[class^='detail_']");

    $(".detail").on("click", function() {
    console.log();
    
  $(this).parent().next('.popup')
    .addClass("show")
    .fadeIn();
  // return false;
});

$(".close").on("click", function() {
console.log('3');
  $(".popup").fadeOut();
  // return false;
});


@endsection