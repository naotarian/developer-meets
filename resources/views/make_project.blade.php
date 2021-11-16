@extends('template.base')
@section('individual_stylesheet')
<link rel="stylesheet" href="/css/make_project.css">
<link href="/css/cropper.min.css" rel="stylesheet">
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
                            <div class="tal sponly"><span class="hissu">必須</span></div><span class="hissu pconly">必須</span>
                            {{Form::text('project_name', null, ['class' => 'form', 'id' => 'project_name', 'placeholder' => 'プロジェクト名'])}}
                            <div class="tal sponly"><span class="hissu_right">必須</span></div><span class="hissu_right pconly">必須</span>
                            {{Form::select('number_of_application', ['1' => '1名', '2' => '2名', '3' => '3名'], null, ['class' => 'form','id' => 'number_of_application', 'placeholder' => '募集人数'])}}
                        </div>
                        <div class="col-xs-6 wow animated slideInRight flex-form mt2" data-wow-delay=".5s">
                            <!-- Name -->
                            {{Form::select('minimum_years_old', $datas['age'], null, ['class' => 'form','id' => 'minimum_years_old', 'placeholder' => '年齢下限'])}}
                            {{Form::select('max_years_old', $datas['age'], null, ['class' => 'form','id' => 'max_years_old', 'placeholder' => '年齢上限'])}}
                        </div>
                        <div class="col-xs-6 wow animated slideInLeft flex-form mt2" data-wow-delay=".5s">
                            <div class="tal sponly"><span class="hissu">必須</span></div><span class="hissu pconly">必須</span>
                            {{Form::select('purpose', $datas['purposes'], null, ['class' => 'form','id' => 'purpose', 'placeholder' => 'プロジェクト目的'])}}
                            {{Form::select('men_and_women', ['0' => '男女制限なし', '1' => '男性のみ', '2' => '女性のみ'], null, ['class' => 'form','id' => 'sex'])}}
                        </div>
                        <div class="col-xs-6 wow animated slideInRight flex-form mt2" data-wow-delay=".5s">
                            {{--
                            {{Form::select('skil', ['0' => 'Java', '1' => 'C', '2' => 'C#', '3' => 'Dart'], null, ['class' => 'form','id' => 'skil', 'placeholder' => '主要言語'])}}
                            {{Form::select('sub_skil', ['0' => 'Java', '1' => 'C', '2' => 'C#', '3' => 'Dart'], null, ['class' => 'form','id' => 'sub_skil', 'placeholder' => 'サブ言語'])}}
                            --}}
                            <div class="tal sponly"><span class="hissu">必須</span></div><span class="hissu pconly">必須</span>
                            {{Form::select('language', $datas['languages'], null, ['class' => 'form','id' => 'skil', 'placeholder' => '主要言語'])}}
                            <div class="tal sponly"><span class="hissu_right">必須</span></div><span class="hissu_right pconly">必須</span>
                            {{Form::select('sub_language', $datas['languages'], null, ['class' => 'form','id' => 'sub_skil', 'placeholder' => 'サブ言語'])}}
                        </div>
                        <div class="col-xs-6 wow animated slideInLeft flex-form mt2" data-wow-delay=".5s">
                            <div class="tal sponly"><span class="hissu">必須</span></div><span class="hissu pconly">必須</span>
                            {{Form::select('minimum_experience', ['0' => '未経験可', '1' => '~1年', '2' => '~2年', '3' => '~3年', '4' => '4年以上'], null, ['class' => 'form','id' => 'minimum_work_experience', 'placeholder' => '最低実務経験'])}}
                            <div class="tal sponly"><span class="hissu_right">必須</span></div><span class="hissu_right pconly">必須</span>
                            {{Form::select('tools', ['0' => 'GitHub', '1' => 'GitLab', '2' => 'SVN', '3' => 'BitBucket', '4' => 'SouceTree', '5' => 'その他', '6' => 'なし'], null, ['class' => 'form','id' => 'tool', 'placeholder' => 'ソース管理'])}}
                        </div>
                        <div class="col-xs-6 wow animated slideInLeft flex-form mt2" data-wow-delay=".5s">
                            {{Form::select('work_frequency', ['0' => '週1~2時間', '1' => '週3~4時間', '2' => '週1日', '3' => '週2~3日', '4' => '週4~5日'], null, ['class' => 'form','id' => 'work_frequency', 'placeholder' => '作業頻度'])}}
                            <input type="file" name="project_image" files="true" id="input-user_image" accept='image/' style="max-width: 100%;" class="form">
                        </div>
                        <div class="col-xs-6 wow animated slideInLeft flex-form mt2" data-wow-delay=".5s">
                            
                            <!--<input type="file" id="input-user_image" name="image">-->
                            <img id="select-image" style="max-width:100%; max-height: 50vh;">
                            <input type="hidden" id="upload-image-x" name="image_x" value="0">
                            <input type="hidden" id="upload-image-y" name="image_y" value="0">
                            <input type="hidden" id="upload-image-w" name="image_w" value="0">
                            <input type="hidden" id="upload-image-h" name="image_h" value="0">
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
@section('scripts')
  $(function(){
    var options = {
        aspectRatio: 2 / 1,
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