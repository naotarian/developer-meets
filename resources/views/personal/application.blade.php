@extends('template.base')
@section('individual_stylesheet')
<link rel="stylesheet" href="/css/personal/application_list.css">
@endsection
@section('contents')
<table class="table application_table">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">申請日</th>
      <th scope="col">申請者</th>
      <th scope="col">対象プロジェクト</th>
      <th scope="col">残り募集人数</th>
      <th scope="col" colspan="2">アクション</th>
    </tr>
  </thead>
  <tbody>
    @if (session('rejected_message'))
      <div class="flash_message">
          {{ session('rejected_message') }}
      </div>
      @php session()->forget('rejected_message') @endphp
    @endif
    
    @foreach($application_list as $key => $app)
    <tr>
      <th scope="row">{{$key}}</th>
      <td>{{$app->application_date[0]['created_at']->format('Y/m/d')}}</td>
      <td><a href="/user_info/{{$app->application_user_info[0]['user_name']}}" target="_blank">{{$app->application_user_info[0]['user_name']}}</a></td>
      <td>{{$app->project_name}}</td>
      <td>{{$app->number_of_application}}人</td>
      <!--<td class="btn_td"><a class="btn btn-primary" href="/approval/{{$app->id}}" role="button">承認する</a></td>-->
      <td class="btn_td"><button type="submit" class="btn btn-outline-secondary" data-toggle="modal" data-target="#approvalModalCenter{{$key}}">承認する</button></td>
      <td class="btn_td"><button type="submit" class="btn btn-outline-secondary" data-toggle="modal" data-target="#rejectedModalCenter{{$key}}">見送る</button></td>
      {{--
      <!--<td class="btn_td"><button type="button" class="btn btn-success">承認する</button></td>-->
      <!--<td class="btn_td"><a class="btn btn-secondary" href="/rejected/{{$app->id}}" role="button">見送る</a></td>-->
      <!--<td class="btn_td"><button type="button" class="btn btn-secondary">見送る</button></td>-->
      --}}
      
    </tr>
        
    {{--承認モーダル--}}
    <div class="modal fade" id="approvalModalCenter{{$key}}" tabindex="-1" role="dialog" aria-labelledby="approvalModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">申請者名 : {{$app->application_user_info[0]['user_name']}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            この方の参加申請を承認しますか？
          </div>
          <div class="modal-footer">
          <input type="hidden" name="project_info" value="">
            <a class="btn btn-danger" href="/approval/{{$app->id}}" role="button">承認する</a>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
          </div>
        </div>
      </div>
    </div>
    {{--見送りモーダル--}}
    <div class="modal fade" id="rejectedModalCenter{{$key}}" tabindex="-1" role="dialog" aria-labelledby="rejectedModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">申請者名 : {{$app->application_user_info[0]['user_name']}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            この方の参加申請を見送りますか？
          </div>
          <div class="modal-footer">
          <input type="hidden" name="project_info" value="">
            <a class="btn btn-danger" href="/rejected/{{$app->id}}" role="button">見送る</a>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
          </div>
        </div>
      </div>
    </div>{{--ここまでmodal--}}
    @endforeach
    
  </tbody>
</table>
@endsection