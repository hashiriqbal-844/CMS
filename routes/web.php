<?php

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

Route::get('/','App\Http\Controllers\WelcomeController@index')->name('welcome');
Route::get('blog/posts/{post}', [App\Http\Controllers\Blog\PostsController::class, 'show'])->name('blog.show');
Route::get('blog/categories/{category}', [App\Http\Controllers\Blog\PostsController::class, 'category'])->name('blog.category');
Route::get('blog/tags/{tag}', [App\Http\Controllers\Blog\PostsController::class, 'tag'])->name('blog.tag');



Auth::routes();

Route::middleware(['auth'])->group(function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('categories','App\Http\Controllers\categoriesController');
    Route::resource('posts','App\Http\Controllers\postController');
    Route::resource('tags','App\Http\Controllers\TagsController');
    Route::get('trashed-posts','App\Http\Controllers\postController@trashed')->name('trashed-posts.index');
    Route::put('restore-post/{post}','App\Http\Controllers\postController@restore')->name('restore-posts');
});
Route::middleware(['auth','admin'])->group(function() {
Route::get('users','App\Http\Controllers\UsersController@index')->name('users.index');
Route::get('users/profile','App\Http\Controllers\UsersController@edit')->name('users.edit-profile');
Route::put('users/profile','App\Http\Controllers\UsersController@update')->name('users.update-profile');
Route::post('users/{user}/make-admin','App\Http\Controllers\UsersController@makeAdmin')->name('users.make-admin');
});



