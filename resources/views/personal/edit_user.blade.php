@extends('template.base')
@section('individual_stylesheet')
<link rel="stylesheet" href="/css/personal/edit_user.css">
<link href="/css/cropper.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
@endsection
@section('contents')
@if($errors->any())
    <div class="error">
        <strong>【内容にエラー】</strong><br>
            
            <p>下記項目をご確認ください。</p>
            <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
            </ul>
    </div>
@endif
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
        <dd>
          <a href="/get_request_image?id={{$login_user_infomation['url_code']}}&name={{$login_user_infomation['icon_image']}}&dir=icon" data-lightbox="user_icon" data-title="アイコン画像拡大">
            <img src="/get_request_image?id={{$login_user_infomation['url_code']}}&name={{$login_user_infomation['icon_image']}}&dir=icon" style="width:200px;">
          </a><br>
        
        <input type="file" name="icon_image" files="true" id="input-user_image" accept='image/' style="max-width: 100%;">
        
        <!--<input type="file" id="input-user_image" name="image">-->
        <img id="select-image" style="max-width:100%; max-height: 50vh;">
        <input type="hidden" id="upload-image-x" name="image_x" value="0">
        <input type="hidden" id="upload-image-y" name="image_y" value="0">
        <input type="hidden" id="upload-image-w" name="image_w" value="0">
        <input type="hidden" id="upload-image-h" name="image_h" value="0">
        </dd>
        <dt>性別</dt>
        <dd>{{Form::select('edit_gender', ['1' => '男', '2' => '女', '3' => 'その他'], $login_user_infomation->sex, ['class' => 'form-control','id' => 'edit_gender', 'style' => 'width: auto;'])}}</dd>
        <dt>メールアドレス</dt>
        <dd>{{Form::email('email', $login_user_infomation->email, ['class' => 'form-control','id' => 'edit_email', 'style' => 'width: auto;'])}}</dd>
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


<script>
      
</script>
@endsection
<!--<script-->
<!--  src="https://code.jquery.com/jquery-3.3.1.min.js"-->
<!--  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="-->
<!--  crossorigin="anonymous"></script>-->
  @section('scripts')
  $(function(){
    var options = {
        aspectRatio: 1 / 1,
        <!--viewMode: 1,-->
        crop: function(e) {
            cropData = $('#select-image').cropper("getData");
            $("#upload-image-x").val(Math.floor(cropData.x));
            $("#upload-image-y").val(Math.floor(cropData.y));
            $("#upload-image-w").val(Math.floor(cropData.width));
            $("#upload-image-h").val(Math.floor(cropData.height));
        },
        zoomable: true,
        minCropBoxWidth: 200,
        minCropBoxHeight: 200
    }
    $('#select-image').cropper(options);
    $("#input-user_image").change(function(){
        $('#select-image').cropper('replace', URL.createObjectURL(this.files[0]));
    });
});
  @endsection
