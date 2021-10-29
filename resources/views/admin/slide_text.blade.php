@extends('template.base')
@section('individual_stylesheet')
<link rel="stylesheet" href="/css/make_project.css">
@endsection
@section('contents')

<div class="contents">
    <div class="page_title">スライドテキスト設定</div>
    	@if($errors->any())
            <div class="error">
                <strong>【内容にエラー】</strong><br>
                    <dl>
                        <dt>下記項目をご確認ください。</dt>
                    @foreach ($errors->all() as $error)
                        <dd>{{ $error }}</dd>
                    @endforeach
                    </dl>
            </div>
        @endif
        @if(session('flash_message'))
            <div class="flash_message bg-success text-center py-3 my-0" style="padding: 1rem;width: 1024px;margin: 6rem auto;">
                {{ session('flash_message') }}
            </div>
        @endif
    {{Form::open(['route' => 'slide_text_post', 'method' => 'post', 'enctype' => 'multipart/form-data'])}}
    <div class="main_contents">
        {{Form::textarea('slide_text', null, ['class' => 'form-control', 'id' => 'textareaRemarks', 'placeholder' => 'スライドテキスト設定', 'rows' => '3'])}}
        {{Form::number('sort', null, ['class' => 'form-control', 'placeholder' => '表示順番号', 'rows' => '3'])}}

        <button type="submit" class="btn btn-success">Success</button>
    </div>
    
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">表示順</th>
          <th scope="col">テキスト</th>
          <th scope="col">アクション</th>
        </tr>
      </thead>
      <tbody>
        @foreach($slide_text_sorted as $key => $data)
        <tr>
          <th scope="row">1</th>
          <td>{{$key + 1}}</td>
          <td>{{$data['slide_text']}}</td>
          <td><a class="btn btn-primary" href="/admin/slide_text_edit/{{$data['id']}}" role="button">編集</a></td>
        </tr>
        @endforeach
        @foreach($slide_text_diasbled as $key => $data)
        <tr>
          <th scope="row">1</th>
          <td>非表示</td>
          <td>{{$data['slide_text']}}</td>
          <td><a class="btn btn-primary" href="/admin/slide_text_edit/{{$data['id']}}" role="button">編集</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{Form::close()}}
</div>
@endsection