<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('welcome');
});

Auth::routes();

Route::get('/posts', [PostController::class, 'index'])->name('home');



Route::post('/like/{user}/{post}', [LikeController::class, 'create'])->name('like');
Route::get('/{post}/comments', [CommentController::class, 'index'])->name('postComments');

Route::get('/addPostForm', function () {
    return view('addPost');
});

Route::get('editPost/{post}', [PostController::class, 'edit'])->name('editPost');
Route::get('addComment/{post}', [CommentController::class, 'create'])->name('addCommentForm');

Route::post('postStore', [PostController::class, 'store'])->name('postStore');
Route::post('commentStore/{post}', [CommentController::class, 'store'])->name('commentStore');

Route::post('postUpdate/{post}', [PostController::class, 'update'])->name('postUpdate');
Route::post('deletePost/{id}', [PostController::class, 'destroy'])->name('deletePost');

Route::get('/posts/search', [PostController::class, 'search'])->name('search');

// Route::get('/my-posts', [PostController::class, 'showUserPosts'])->name('my-posts');
// Route::get('/{post}/comments', [CommentController::class, 'index'])->name('comments');
// Route::post('/{post}/comment/store', [CommentController::class, 'store'])->name('comment.store');
// Route::get('/posts/search', [PostController::class, 'search'])->name('posts.search');

// Route::resource('posts', PostController::class);