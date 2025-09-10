<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1') -> group(function(){

///mengatur routing untuk posts
    Route::prefix('posts')->group(function () {
        Route::get('/',[PostsController::class, 'index']);// menampilkan semua data
        Route::post('/',[PostsController::class, 'store']);// menyimpan data
        Route::get('/{id}',[PostsController::class, 'show']);// menampilkan data berdasarkan id
        Route::put('/{id}',[PostsController::class, 'update']);//mengupdate data berdasarkan id
        Route::delete('/{id}',[PostsController::class, 'destroy']);//menghapus data berdasarkan id
        });
});
