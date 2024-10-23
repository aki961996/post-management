<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('posts',PostController::class);
Route::get('post/add',[PostController::class,'add'])->name('posts.add');

Route::post('posts/{post}/comments',[CommentController::class,'store'])->name('comments.store');
Route::patch('comments/{comment}',[CommentController::class,'update'])->name('comments.update');
Route::delete('comments/{comment}',[CommentController::class,'destroy'])->name('comments.destroy');
