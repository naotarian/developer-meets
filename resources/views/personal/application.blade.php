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
      @foreach($application_list as $key => $app)
    <tr>
      <th scope="row">{{$key}}</th>
      <td>{{$app->application_date[0]['created_at']->format('Y/m/d')}}</td>
      <td><a href="/user_info/{{$app->application_user_info[0]['user_name']}}" target="_blank">{{$app->application_user_info[0]['user_name']}}</a></td>
      <td>{{$app->project_name}}</td>
      <td>{{$app->number_of_application}}人</td>
      <td class="btn_td"><button type="button" class="btn btn-success">承認する</button></td>
      <td class="btn_td"><button type="button" class="btn btn-secondary">見送る</button></td>
    </tr>
    @endforeach
    
  </tbody>
</table>
@endsection