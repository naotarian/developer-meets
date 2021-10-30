@extends('template.base')
@section('individual_stylesheet')
<link rel="stylesheet" href="/css/personal/edit_user.css">
@endsection
@section('contents')
@if (session('edit_message'))
  <div class="flash_message">
      {{ session('edit_message') }}
  </div>
  @php session()->forget('edit_message') @endphp
@endif
  <dl class="my_infomations">
    {{Form::open(['route' => 'edit_proifile_post', 'method' => 'post','files'=> true, 'enctype' => 'multipart/form-data', 'style' => 'width:100%;'])}}
        <dt>ユーザー名</dt>
        <dd>{{Form::text('edit_user_name', $login_user_infomation->user_name, ['class' => 'form-control', 'id' => 'edit_user_name', 'style' => 'width: auto;', 'disabled' => 'disabled'])}}<br>
        変更できません。</dd>
        <dt>アイコン画像</dt>
        <dd><input type="file" name="icon_image" files="true" id="imageUpload" accept='image/'></dd>
        <dt>性別</dt>
        <dd>{{Form::select('edit_gender', ['1' => '男', '2' => '女', '3' => 'その他'], $login_user_infomation->sex, ['class' => 'form-control','id' => 'edit_gender', 'style' => 'width: auto;'])}}</dd>
        <dt>性別</dt>
        <dd>{{Form::email('edit_email', $login_user_infomation->email, ['class' => 'form-control','id' => 'edit_email', 'style' => 'width: auto;'])}}</dd>
        <dt>年齢</dt>
        <dd>{{ Form::selectRange('age', 16, 60, $login_user_infomation->age, ['class' => 'form-control', 'style' => 'width: auto;display: inline-block;']) }}歳</dd>
        <dt>一言コメント</dt>
        <dd>{{Form::text('edit_comment', $login_user_infomation->comment, ['class' => 'form-control', 'id' => 'edit_comment', 'style' => 'width: auto;'])}}</dd>
        <dt>エンジニア歴</dt>
        <dd>{{$login_user_infomation->engineer_history}}年</dd>
        <dt>URL</dt>
        <dd>{{Form::text('edit_url', $login_user_infomation->free_url, ['class' => 'form-control', 'id' => 'edit_url', 'style' => 'width: auto;'])}}</dd>
        <dt>プロフィール</dt>
        <dd>{{Form::textarea('edit_self_introduction', $login_user_infomation->self_introduction, ['class' => 'form-control', 'id' => 'edit_self_introduction', 'rows' => '3'])}}</dd>
        <input type="hidden" value="{{$login_user_infomation->user_name}}" name="user_name">
        <button type="submit" class="btn btn-outline-success">変更する</button>
    {{Form::close()}}
  </dl>
@endsection

@section('read_script')
$('#imageUpload').on('change', function (e) {
    let reader = new FileReader();
    reader.onload = function (e) {
        $("#preview").attr('src', e.target.result)
    }
    reader.readAsDataURL(e.target.files[0]);
});
@endsection