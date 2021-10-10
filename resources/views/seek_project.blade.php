@extends('template.base')
@section('individual_stylesheet')
<link rel="stylesheet" href="/css/seek_project.css">
@endsection
@section('contents')

<div class="contents">
   <div class="seek_list">
       {{ Form::open() }}



        <div class="language">
            <p class="g1">言語</p>
            <ul>
                    @foreach($languages as $key => $language)
                <li>
                        {{ Form::checkbox('language', $language, false, ['id' => $language, 'class' => 'form-check-input scale2']) }}
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
                    {{ Form::checkbox('purpose', $purpose, false, ['id' => $purpose, 'class' => 'form-check-input scale2']) }}
                    {{ Form::label($purpose, $purpose, ['class' => 'form-check-label mr2']) }}
                </li>
                    @endforeach
               
            </ul>
        </div>
       {{ Form::close() }}
   </div>
</div>
@endsection