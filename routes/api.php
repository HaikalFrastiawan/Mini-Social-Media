<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\JWTAuthController;
use App\Http\Middleware\JWTMiddleware;


Route::prefix('v1') -> group(callback: function(){

//handle authentication
    Route::post('register', [JWTAuthController::class, 'register']);
    Route::post('login', [JWTAuthController::class, 'login']);
    Route::post('logout', [JWTAuthController::class, 'logout'])->middleware('auth:api');

///mengatur routing untuk posts -> (menambahkan middleware JWTMiddleware)
    Route::middleware(JWTMiddleware::class)->prefix('posts')->group(function () {
        Route::get('/',[PostsController::class, 'index']);// menampilkan semua data
        Route::post('/',[PostsController::class, 'store']);// menyimpan data
        Route::get('/{id}',[PostsController::class, 'show']);// menampilkan data berdasarkan id
        Route::put('/{id}',[PostsController::class, 'update']);//mengupdate data berdasarkan id
        Route::delete('/{id}',[PostsController::class, 'destroy']);//menghapus data berdasarkan id
        });

//Menghandlde routing untuk comments
    Route::prefix('comments')->group(function () {
        Route::post('/',[CommentsController::class, 'store']);// menampilkan semua data
        Route::delete('{id}',[CommentsController::class, 'destroy']);//menghapus data berdasarkan id

    });

//menghandle likes
    Route::prefix('likes')->group(function () {
        Route::post('/',[LikesController::class, 'store']);//menyukai post
        Route::delete('{id}',[LikesController::class, 'destroy']);//menghapus like berdasarkan id
    });

//menghandle messages
    Route::prefix('messages')->group(function () {
        Route::post('/',[MessagesController::class, 'store']);//mengirim pesan
        
        Route::get('{id}',[MessagesController::class, 'show']);//menampilkan pesan berdasarkan user_id

        Route::get('getMessage/{user_id}',[MessagesController::class, 'getMessage']);//menampilkan pesan berdasarkan user_id

        Route::delete('{id}',[MessagesController::class, 'destroy']);//menghapus pesan berdasarkan id
    });
});
