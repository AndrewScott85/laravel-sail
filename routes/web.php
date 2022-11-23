<?php

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('photos', function() {
    return Inertia::render('Guest/Photos', [
        'photos' => Photo::all(),
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register')
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/photos', function () {
        return inertia('Admin/Photos', [
            'photos' => Photo::orderByDesc('id')->get()
        ]);
    })->name('photos'); // This will respond to requests for admin/photos and have a name of admin.photos

    Route::get('/photos/create', function ()
    {
        return inertia('Admin/PhotoCreate');
    })->name('photos.create');

    Route::post('/photos', function() {
       $validated_data = Request::validate([
            'path' => ['required', 'image', 'max:500'],
            'description' => ['required']
       ]);
        $path = Storage::disk('public')->put('photos', Request::file('path'));
        $validated_data['path'] = $path;
        Photo::create($validated_data);
        return to_route('admin.photos');
        
    })->name('photos.store');

    Route::get('/photos/{photo}/edit', function (Photo $photo) {
        return inertia('Admin/PhotoEdit', [
            'photo' => $photo
        ]);
    })->name('photos.edit');

    Route::put('/photos/{photo}', function (Photo $photo) {

        $validated_data = Request::validate([
            'description' => ['required']
       ]);

        if(Request::hasFile('path')) {
            $validated_data['path'] = Request::validate([
                'path' => ['required', 'image', 'max:500'],
            ]);

//Grab old image and delete it
            $oldImage = $photo->path;
            Storage::delete($oldImage);

        $path = Storage::disk('public')->put('photos', Request::file('path'));
        $validated_data['path'] = $path;
    }
   
    $photo->update($validated_data);
        return to_route('admin.photos');
        
    })->name('photos.update');

    Route::delete('/photos/{photo}', function (Photo $photo) {
        Storage::delete($photo->path);
        $photo->delete();
        return to_route('admin.photos');
    })->name('photos.delete');

});