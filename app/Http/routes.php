<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Input;
use App\Post;

Route::auth();

Route::get('/', 'UserController@index');

Route::get('/postList', array(
	'uses'=>'PostsController@index',
	'as'=>'postList'
	));

Route::get('/users', array(
	'uses'=>'UserController@userList',
	'as'=>'users'
	));

Route::get('/messages', array(
	'uses'=>'MessagesController@showMessages',
	'as'=>'messages'
	));

Route::get('/postView/{id}', 'PostsController@postView');

Route::get('/newPost', function() {
	return view('newPost');
})->middleware('auth');

Route::post('/newPostService', array(
	'uses'=>'PostsController@serviceNewPost',
	'as'=>'newPostService'
	));

Route::post('/updatePostService', array(
	'uses'=>'PostsController@serviceUpdatePost',
	'as'=>'updatePostService'
	));

Route::get('/profil/{id}', 'UserController@showProfil');

Route::get('/editProfil', array(
	'uses'=>'UserController@editProfil',
	'as'=>'editProfil'
	))->middleware('auth');

Route::get('/editPost', array(
	'uses'=>'PostsController@editPost',
	'as'=>'editPost'
	))->middleware('auth');

Route::post('/profilService', array(
	 'uses'=>'UserController@profilService',
	 'as'=>'profilService'
	 ));

Route::post('/newCommentService', array(
	'uses'=>'PostsController@newCommentService',
	'as'=>'newCommentService'
	));

Route::post('/messageService', array(
	'uses'=>'MessagesController@serviceMessage',
	'as'=>'messageService'
	));

Route::post('/messageNewService', array(
	'uses'=>'MessagesController@serviceNewMessage',
	'as'=>'messageNewService'
	));

Route::post('/uploadMessages', 'MessagesController@uploadTypeMessages');

Route::get('/pagesUpload', 'UserController@files');

Route::post('apply/upload','UserController@upload');

Route::get('upload', 'UserController@backUpload');





/*Route::post('/messageService', array(
	'uses'=>'MessagesController@serviceNewMessage',
	'as'=>'messageService'
	));*/



//Route::post('/send', 'EmailController@send');