<?php

use App\Http\Controllers\DemoLoginController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Photo;

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

Route::get('/', [App\Http\Controllers\GuestController::class, 'redirect']);

Route::get('/allposts', App\Http\Controllers\GuestController::class)->name('allposts');
Route::get('user/{uid}/posts', [App\Http\Controllers\GuestController::class, 'userPosts'])->name('userposts');
Route::get('ai/{aiService}/posts', [App\Http\Controllers\GuestController::class, 'aiService'])->name('aiservice');
Route::post('demo/login', DemoLoginController::class)->name('demologin');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->prefix('user')->name('user.')->group(function () {
    Route::get('/manageposts', [App\Http\Controllers\UserPageController::class, 'displayAllEditable'])->name('manageposts');
    Route::get('/photos/create', [App\Http\Controllers\UserPageController::class, 'create'])->name('photos.create');
    Route::post('/photos', [App\Http\Controllers\UserController::class, 'post'])->name('photos.store');
    Route::get('/photos/{photo}/edit', [App\Http\Controllers\UserPageController::class, 'edit'])->name('photos.edit');
    Route::put('/photos/{photo}', [App\Http\Controllers\UserController::class, 'update'])->name('photos.update');
    Route::delete('/photos/{photo}', [App\Http\Controllers\UserController::class, 'delete'])->name('photos.delete');

});
