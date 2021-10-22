@extends('template.base')
@section('individual_stylesheet')
<link rel="stylesheet" href="/css/project_detail.css">
@endsection
@section('contents')

<!-- 詳細コンポーネント差し込み -->
<div id="project_detail"></div>
<script src="{{ mix('/js/components/Pages/ProjectDetailPage.js') }}"></script>
@endsection