$('.search-icon').on('click', function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        }
    });
    var language = $('.language').val();
    var purpose = $('.purpose').val();
    var gender = $('.gender').val();
    $.ajax({
      url: '/api/seek_project',
      type: 'post',
      datatype: 'json',
      data: {
        'language': language,
        'purpose': purpose,
        'gender': gender,
        //left値と該当idを渡す
        
        //ここはサーバーに贈りたい情報
     },
    })
    // Ajaxリクエストが成功した時発動
    .done( (data) => {
        var from_json = JSON.parse(JSON.stringify(data));
         var test = Object.entries(data).map(([key, value]) => ({'key': key, 'value': value}));
        console.log(test);
        if(data.datas.length == 0) {
          $('.project_list').html('検索結果がありません');
        } else {
            $(data.datas).each(function(index, element){
                // var data = JSON.stringify(from_json.datas);
                
                console.log(from_json.datas[0]);
                
                if(index == 0) {
                   $('.project_list').html('');
                }
                $('.project_list').append(`<div class='card wi48 p2 mb2'>
                    <p>${element['project_name']}</p>
                    <table class="project_detail_table">
                        <tr>
                            <td>募集人数</td>
                            <td>${element['number_of_application']}人</td>
                        </tr>
                        <tr>
                            <td>男女</td>
                            <td>${element['men_and_women']}</td>
                        </tr>
                        <tr>
                            <td>経験年数</td>
                            <td>${element['minimum_experience']}年以上</td>
                        </tr>
                        <tr>
                            <td>目的</td>
                            <td>${element['purpose']}</td>
                        </tr>
                        <tr>
                            <td>ソース管理</td>
                            <td>${element['tools']}</td>
                        </tr>
                        <tr>
                            <td>主要言語</td>
                            <td>${element['language']}</td>
                        </tr>
                        <tr>
                            <td>年齢</td>
                            <td>${element['minimum_years_old']}歳 ~ ${element['max_years_old']}歳</td>
                        </tr>
                        
                    </table>
                    <div class='actions'>
                        <button type="button" class="detail btn btn-outline-primary">詳細を見る</button>
                        <input type="hidden" name="project_info" value="">
                        <button type="submit" class="btn btn-outline-secondary">質問したい</button>
                        <button type="submit" class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModalCenter${index}">参加申請</button>
                    </div>
                    
                    <div class="att_name">
                        <div class="create_user">作成者 : <a href="/user_info/${element['user']['user_name']}">${element['user']['user_name']}</a></div>
                    </div>
                    <div class="popup">
                      <div class="content">
                        <p>${element['project_detail']}</p>
                        <button id="close" class="close">閉じる</button>
                      </div>
                    </div>
                    <div class="modal fade" id="exampleModalCenter${index}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form action="/application" method="POST" enctype="multipart/form-data">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">プロジェクト名 : ${element['project_name']}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                このプロジェクトへの参加を申請しますか？
                              </div>
                              <div class="modal-footer">
                              <input type="hidden" name="project_info" value="${test}">
                                <button type="submit" class="btn btn-primary">申請する</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                              </div>
                          </form>
                        </div>
                      </div>
                    </div>
                </div>`);
              });
            }
      
    })
    // Ajaxリクエストが失敗した時発動
    .fail( (data) => {
      alert('読み込み失敗');
    })
    // Ajaxリクエストが成功・失敗どちらでも発動
    .always( (data) => {
  });
});


