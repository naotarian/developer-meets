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
    {{Form::open(['route' => 'slide_text_edit_post', 'method' => 'post', 'enctype' => 'multipart/form-data'])}}
    <div class="main_contents">
        {{Form::textarea('slide_text_edit', $edit_data['slide_text'], ['class' => 'form-control', 'id' => 'textareaRemarks', 'placeholder' => 'スライドテキスト設定', 'rows' => '3'])}}
        {{Form::number('sort', $edit_data['sort'], ['class' => 'form-control', 'placeholder' => '表示順番号', 'rows' => '3'])}}
        <input type="hidden" name="slide_text_id" value="{{$edit_data['id']}}">
        <button type="submit" class="btn btn-success">変更</button>
    </div>
    
  
    {{Form::close()}}
</div>
@endsection