@extends('template.base')
@section('individual_stylesheet')
<link rel="stylesheet" href="/css/seek_project.css">
@endsection
@section('contents')

<div class="contents">
    @if($errors->any())
        <div class="error">
            <strong>【登録内容に不備】</strong><br>
                <dl>
                    <dt>下記項目をご確認ください。</dt>
                @foreach ($errors->all() as $error)
                    <dd>{{ $error }}</dd>
                @endforeach
                </dl>
        </div>
    @php Request::session()->forget('errors') @endphp
    @endif
   <div class="seek_list">
       {{Form::open(['route' => 'project_list_post', 'method' => 'post', 'enctype' => 'multipart/form-data'])}}



        <div class="language">
            <p class="g1">言語</p>
            <ul>
                    @foreach($languages as $key => $language)
                <li>
                        {{ Form::checkbox('language[' . $key .']', $key, false, ['id' => $language, 'class' => 'form-check-input scale2']) }}
                        {{ Form::label($language, $language, ['class' => 'form-check-label mr2']) }}
                </li>
                    @endforeach
               
            </ul>
           
        </div>
        <div class="purposes">
           <p class="g2">目的</p>
           <ul>
                    @foreach($purposes as $key => $purpose)
                <li>
                    {{ Form::checkbox('purpose[' . $key .']', $key, false, ['id' => $purpose, 'class' => 'form-check-input scale2']) }}
                    {{ Form::label($purpose, $purpose, ['class' => 'form-check-label mr2']) }}
                </li>
                    @endforeach
            </ul>
        </div>
        <button type="submit" class="btn btn-outline-success">検索</button>
       {{ Form::close() }}
   </div>
</div>
@endsection
@section('scripts')
$('input[name="language[99]"]').click(function() {
    if($(this).prop("checked")) {
        $('input[name^=language]').not($(this)).prop('checked', false);
        $('input[name^=language]').not($(this)).prop('disabled', true);
    } else {
        $('input[name^=language]').not($(this)).prop('disabled', false);
    }
});
$('input[name="purpose[99]"]').click(function() {
    if($(this).prop("checked")) {
        $('input[name^=purpose]').not($(this)).prop('checked', false);
        $('input[name^=purpose]').not($(this)).prop('disabled', true);
    } else {
        $('input[name^=purpose]').not($(this)).prop('disabled', false);
    }
});
@endsection