<?php

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
Route::get('/', 'DynamicController@index')->name('top');
Route::get('/seek', 'DynamicController@seek_project')->name('seek_project');
Route::get('/make', 'DynamicController@make_project')->name('make_project')->middleware('auth');
Route::post('/make', 'DynamicController@make_project_post')->name('make_project_post')->middleware('auth');
Route::get('/my_page', 'DynamicController@my_page')->name('my_page')->middleware('auth');
Route::get('/user_info/{user_name?}', 'DynamicController@my_page')->name('user_info')->middleware('auth');
Route::post('/question', 'DynamicController@question')->name('question');
Auth::routes();
Route::post('/api/seek_project', 'ApiController@seek_project')->name('seek_project');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/application', 'DynamicController@application')->name('application')->middleware('auth');
Route::get('/application_list', 'DynamicController@application_list')->name('application_list')->middleware('auth');