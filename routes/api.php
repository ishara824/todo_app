<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(\App\Http\Controllers\AuthController::class)->group(function (){
   Route::post('login','login');
   Route::post('register','register');
});

Route::controller(\App\Http\Controllers\TodoController::class)->group(function (){

   Route::get('get/all/lists','getAllTodoLists')->middleware('auth:sanctum');
   Route::get('get/item/details/{id}','loadTodoItemDetails')->middleware('auth:sanctum');

   Route::post('create/list','saveList')->middleware('auth:sanctum');
   Route::post('create/item','saveTodoItem')->middleware('auth:sanctum');
   Route::post('get/all/items','loadTodoItems')->middleware('auth:sanctum');
   Route::post('complete/todo','completeTask')->middleware('auth:sanctum');
   Route::post('delete/todo','deleteTask')->middleware('auth:sanctum');
   Route::post('update/task','updateTask')->middleware('auth:sanctum');

});
