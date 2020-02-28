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

use App\Video;

Route::get('/', function () {
    //$video = Video::all();
    //dd($video);
    return view('welcome');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');//En homecontroller quitar middleware auth por web que no tiene restricciones

//Route::resource('video', 'VideoController');

Route::get('/create-video', array('as' => 'createVideo', 'middleware' => 'auth', 'uses' => 'VideoController@createVideo'));

Route::post('/save-video', array('as' => 'saveVideo', 'middleware' => 'auth', 'uses' => 'VideoController@saveVideo'));

Route::get('/thumb/{filename}', array('as' => 'imageVideo', 'uses' => 'VideoController@getImage'));

Route::get('/video/{video_id}', array('as' => 'detailVideo', 'uses' => 'VideoController@getVideoDetail'));

Route::get('/video-file/{filename}', array('as' => 'fileVideo', 'uses' => 'VideoController@getVideo'));

Route::post('/comment', array('as' => 'comment', 'middleware' => 'auth', 'uses' => 'CommentController@store'));

Route::get('/delete-comment/{comment_id}', array('as' => 'delete', 'middleware' => 'auth', 'uses' => 'CommentController@delete'));

Route::get('/delete-video/{video_id}', array('as' => 'videoDelete', 'middleware' => 'auth', 'uses' => 'VideoController@delete'));

Route::get('/editar-video/{video_id}', array('as' => 'videoEdit', 'middleware' => 'auth', 'uses' => 'VideoController@edit'));

Route::post('/update-video/{video_id}', array('as' => 'updateVideo', 'middleware' => 'auth', 'uses' => 'VideoController@update'));

Route::get('/buscar/{search?}/{filter?}', ['as' => 'videoSearch', 'uses' => 'VideoController@search']);

Route::get('/clear-cache', function() {
	$code = Artisan::call('cache:clear');
});

Route::get('/canal/{user_id}', array('as' => 'channel', 'uses' => 'UserController@channel'));

