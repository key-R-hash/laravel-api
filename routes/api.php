<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('myauth')->get("posts","PostController@posts");
Route::middleware('myauth')->get("posts/{id}","PostController@post");

Route::post("Registration","RegistrationController@Registration");
Route::middleware('myauth')->get("logout","SessionController@logout");
Route::post("login","SessionController@login");

Route::middleware('myauth')->post('posts', 'PostController@create');
Route::middleware('myauth')->delete('posts/{id}', 'PostController@delete');
Route::middleware('myauth')->put('posts/{id}', 'PostController@update');

Route::middleware('myauth')->get("posts/{id}/comments","CommentController@comments_post");
Route::middleware('myauth')->post("posts/{id}/comment","CommentController@create");
