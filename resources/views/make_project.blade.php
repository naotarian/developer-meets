@extends('template.base')
@section('individual_stylesheet')
<link rel="stylesheet" href="/css/make_project.css">
@endsection
@section('contents')

<div class="contents">
    <div class="page_title">新規プロジェクト作成</div>
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
        {{Form::open(['route' => 'make_project_post', 'method' => 'post', 'enctype' => 'multipart/form-data'])}}
    <div class="main_contents">

        
        <div class="inner contact">
                <!-- Form Area -->
                <div class="contact-form">
                    <!-- Form -->
                        <!-- Left Inputs -->
                        <div class="col-xs-6 wow animated slideInLeft flex-form mt2" data-wow-delay=".5s">
                            <!-- Name -->
                            {{Form::text('project_name', null, ['class' => 'form', 'id' => 'project_name', 'placeholder' => 'プロジェクト名'])}}
                            {{Form::select('number_of_application', ['1' => '1名', '2' => '2名', '3' => '3名'], 'ordinarily', ['class' => 'form','id' => 'number_of_application', 'placeholder' => '募集人数'])}}
                        </div>
                        <div class="col-xs-6 wow animated slideInRight flex-form mt2" data-wow-delay=".5s">
                            <!-- Name -->
                            {{Form::select('minimum_years_old', $datas['age'], 'ordinarily', ['class' => 'form','id' => 'minimum_years_old', 'placeholder' => '年齢下限'])}}
                            {{Form::select('max_years_old', $datas['age'], 'ordinarily', ['class' => 'form','id' => 'max_years_old', 'placeholder' => '年齢上限'])}}
                        </div>
                        <div class="col-xs-6 wow animated slideInLeft flex-form mt2" data-wow-delay=".5s">
                            {{Form::select('purpose', $datas['purposes'], 'ordinarily', ['class' => 'form','id' => 'purpose', 'placeholder' => 'プロジェクト目的'])}}
                            {{Form::select('sex', ['0' => '男女制限なし', '1' => '男性のみ', '2' => '女性のみ'], 'ordinarily', ['class' => 'form','id' => 'sex'])}}
                        </div>
                        <div class="col-xs-6 wow animated slideInRight flex-form mt2" data-wow-delay=".5s">
                            {{--
                            {{Form::select('skil', ['0' => 'Java', '1' => 'C', '2' => 'C#', '3' => 'Dart'], 'ordinarily', ['class' => 'form','id' => 'skil', 'placeholder' => '主要言語'])}}
                            {{Form::select('sub_skil', ['0' => 'Java', '1' => 'C', '2' => 'C#', '3' => 'Dart'], 'ordinarily', ['class' => 'form','id' => 'sub_skil', 'placeholder' => 'サブ言語'])}}
                            --}}
                            {{Form::select('skil', $datas['languages'], 'ordinarily', ['class' => 'form','id' => 'skil', 'placeholder' => '主要言語'])}}
                            {{Form::select('sub_skil', $datas['languages'], 'ordinarily', ['class' => 'form','id' => 'sub_skil', 'placeholder' => 'サブ言語'])}}
                        </div>
                        <div class="col-xs-6 wow animated slideInLeft flex-form mt2" data-wow-delay=".5s">
                            {{Form::select('minimum_work_experience', ['0' => '未経験可', '1' => '~1年', '2' => '~2年', '3' => '~3年', '4' => '4年以上'], 'ordinarily', ['class' => 'form','id' => 'minimum_work_experience', 'placeholder' => '最低実務経験'])}}
                            {{Form::select('tool', ['0' => 'GitHub', '1' => 'GitLab', '2' => 'SVN', '3' => 'BitBucket', '4' => 'SouceTree', '5' => 'その他', '6' => 'なし'], 'ordinarily', ['class' => 'form','id' => 'tool', 'placeholder' => 'ソース管理'])}}
                        </div>
                       
                        <div class="col-xs-6 wow animated slideInRight tas" data-wow-delay=".5s">
                            <textarea name="project_detail" id="project_detail" class="form textarea"  placeholder="プロジェクト詳細"></textarea>
                        </div>
                        <div class="col-xs-6 wow animated slideInLeft tas" data-wow-delay=".5s">
                            <textarea name="remarks" id="remarks" class="form textarea"  placeholder="備考"></textarea>
                        </div>
                        <div class="relative fullwidth col-xs-12">
                            <button type="submit" id="submit" name="submit" class="form-btn semibold">この内容で作成する</button> 
                        </div>
                        <div class="clear"></div>

                    <div class="mail-message-area">
                        <div class="alert gray-bg mail-message not-visible-message">
                            <strong>Thank You !</strong> Your email has been delivered.
                        </div>
                    </div>

                </div><!-- End Contact Form Area -->
            </div><!-- End Inner -->


<center> Visit Developer's Website <a href="http://shuvohabib.com" target="blank">Shuvo Habib </a> </center>
    </div>
        {{Form::close()}}
</div>
@endsection