<?php
use App\Http\Controllers\TwitterLoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {

// });
Route::get('/welcome', function() {
    return view('welcome');
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/make', 'DynamicController@make_project')->name('make_project');
    Route::post('/make', 'DynamicController@make_project_post')->name('make_project_post');
    Route::get('/my_page', 'DynamicController@my_page')->name('my_page');
    Route::get('/user_info/{user_name?}', 'DynamicController@my_page')->name('user_info');
    Route::post('/application', 'DynamicController@application')->name('application');
    Route::get('/application_list/{id}', 'DynamicController@application_list')->name('application_list');
    Route::post('/cancel', 'DynamicController@cancel')->name('cancel');
    Route::get('/rejected/{id}', 'DynamicController@rejected')->name('rejected');
    Route::get('/withdrawal/{id}', 'DynamicController@withdrawal')->name('withdrawal');
    Route::get('/edit_proifile/{id}', 'DynamicController@edit_proifile')->middleware('auth');
    Route::post('/edit_proifile', 'DynamicController@edit_proifile_post')->name('edit_proifile_post');
    Route::get('/approval/{id}', 'DynamicController@approval')->name('approval');
    Route::get('/project/edit/{id}', 'DynamicController@project_edit')->name('project_edit');
    Route::post('/edit_project_post', 'DynamicController@edit_project_post')->name('edit_project_post');
});
Route::get('/sample', 'SampleController@react');
Route::get('/', 'DynamicController@index')->name('top');
Route::get('/seek', 'DynamicController@seek_project')->name('seek_project');
Route::post('/question', 'DynamicController@question')->name('question');
Auth::routes();
Route::post('/api/seek_project', 'ApiController@seek_project')->name('seek_project');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/twitter', 'Api\ApiController@twitterApi');
Route::get('/seek/detail/{id}', function() {
    return view('project_detail');
})->name('detail_get');

// GitHubの認証ページに遷移するためのルーティング
Route::get('/login/github', 'Auth\LoginController@redirectToProvider');
Route::get('auth/login/twitter', [TwitterLoginController::class, 'redirectToProvider']);
Route::get('auth/twitter/callback',[TwitterLoginController::class, 'handleProviderCallback']);

// GitHubの認証後に戻るためのルーティング
Route::get('/auth/github/callback', 'Auth\LoginController@handleProviderCallback');
// jsからのリクエスト
Route::get('/api/test', 'Api\ApiController@test');
Route::get('/api/detail/{id}', 'Api\ApiController@project_detail');
Route::get('/api/all_projejct', 'Api\ApiController@all_projejct');
Route::post('/api/application', 'Api\ApiController@application');

// admin権限ユーザーのみアクセス可能
Route::get('/admin', 'AdminController@index')->name('admin');
Route::get('/admin/slide_text', 'AdminController@slide_text')->name('slide_text');
Route::post('/admin/slide_text', 'AdminController@slide_text_post')->name('slide_text_post');
Route::get('/admin/slide_text_edit/{id}', 'AdminController@slide_text_edit')->name('slide_text_edit');
Route::post('/admin/slide_text_edit_post', 'AdminController@slide_text_edit_post')->name('slide_text_edit_post');


Route::get('/get_request_image', 'DynamicController@get_request_image');
Route::get('/hash', 'DynamicController@hash_code');