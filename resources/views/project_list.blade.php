@extends('template.base')
@section('individual_stylesheet')
<link rel="stylesheet" href="/css/project_list.css">
@endsection
@section('contents')

<div class="contents">
    <div class="project_list">
        <div class="project">
            <p>プロジェクト名1</p>
            <table class="project_detail_table">
                <tr>
                    <td>募集人数</td>
                    <td>2人</td>
                </tr>
                <tr>
                    <td>男女</td>
                    <td>指定なし</td>
                </tr>
                <tr>
                    <td>経験年数</td>
                    <td>指定なし</td>
                </tr>
                <tr>
                    <td>目的</td>
                    <td>学習</td>
                </tr>
                <tr>
                    <td>ソース管理</td>
                    <td>GitHub</td>
                </tr>
            </table>
            <div class="actions">
                <a class="btn btn-primary">詳細を見る</a>
                <a class="btn btn-secondary">質問したい</a>
                <a class="btn btn-success">参加申請</a>
            </div>
            <div class="create_user">作成者 : <a href="#">user_name</a></div>
        </div>
        <div class="project">
            <p>プロジェクト名2</p>
            <table class="project_detail_table">
                <tr>
                    <td>募集人数</td>
                    <td>2人</td>
                </tr>
                <tr>
                    <td>男女</td>
                    <td>指定なし</td>
                </tr>
                <tr>
                    <td>経験年数</td>
                    <td>指定なし</td>
                </tr>
                <tr>
                    <td>目的</td>
                    <td>学習</td>
                </tr>
                <tr>
                    <td>ソース管理</td>
                    <td>GitHub</td>
                </tr>
            </table>
            <div class="actions">
                <a class="btn btn-primary">詳細を見る</a>
                <a class="btn btn-secondary">質問したい</a>
                <a class="btn btn-success">参加申請</a>
            </div>
            <div class="create_user">作成者 : <a href="#">user_name</a></div>
        </div>
        
    </div>
</div>
@endsection