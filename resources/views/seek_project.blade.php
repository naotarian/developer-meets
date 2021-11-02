@extends('template.base')
@section('individual_stylesheet')
<link rel="stylesheet" href="/css/seek_project.css">
<link rel="stylesheet" href="/css/project_list.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('contents')

<div class="contents">
    {{-- <div id="project_card"></div>
    <script src="{{ mix('/js/components/Organisms/ProjectCard.js') }}"></script> --}}
    <!-- プロジェクトカード差し込み -->
    <div id="project_list"></div>
    <script src="{{ mix('/js/components/Pages/ProjectListPage.js') }}"></script>
</div>
