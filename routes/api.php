<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/create-new-post',[PostController::class, 'createnewpost']);
Route::get('/get-all-post', [PostController::class, 'getallpost']);
Route::post('/delete-post',[PostController::class, 'deletepost']);
Route::get('/post-by-id/{id}',[PostController::class, 'postbyid']);
Route::post('/edit-post', [PostController::class, 'editpost']);