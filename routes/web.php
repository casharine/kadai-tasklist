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

// デフォルトページの表示
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');
/*
// メッセージの個別詳細ページ表示
Route::get('tasks/{id}', 'TasksController@show');
// メッセージの新規登録を処理（新規登録画面を表示するためのものではない）
Route::post('tasks', 'TasksController@store');
// メッセージの更新処理（編集画面を表示するためのものではない）
Route::put('tasks/{id}', 'TasksController@update');
// メッセージの削除 
Route::delete('tasks', 'TasksController@destroy');

// index: showの補助ページ
Route::get('tasks', 'TasksController@index')->name('tasks.index');
// create: storeの補助ページ、新規作成用のフォームページ
Route::get('tasks/create', 'TasksController@create')->name('taskes.create');
// update: putの補助ページ、更新用フォームページ
Route::get('tasks/{id}/edit', 'TasksController@edit')->name('tasks.edit');
*/
