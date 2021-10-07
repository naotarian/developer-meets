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
Route::get('/', 'DynamicController@index')->name('top');
Route::get('/seek', 'DynamicController@seek_project')->name('seek_project');
Route::get('/make', 'DynamicController@make_project')->name('make_project');
Route::get('/project_list', 'DynamicController@project_list')->name('project_list');
