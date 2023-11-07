<?php

use App\Http\Controllers\ProfileController;
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
use App\Models\Chirp;

Route::get('/', function () {
    return view('welcome');
});
/* Esto de arriba es igual a esto:*/
/* Route::view('/', 'welcome')->name('welcome'); */

/* Route::get('/chirps', function () {
    return 'Welcome to tweets page';
})->name('chirps.index'); LA MUEVO AL MIDDLEWARE AGRUPADO AUTH */

/* Todo esto se cambia por lo que está en la primera ruta heredada del middleware auth
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard'); */

Route::middleware('auth')->group(function () { /*esto agrupa todas estas rutas bajo el mismo middleware*/
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/chirps', function () {
        return view('chirps.index');/*Acá chirps es la carpeta, el . entra en la carpeta*/
    })->name('chirps.index');
    Route::post('/chirps', function () {
        Chirp::create([
            'message' => request('message'),
            'user_id' => auth()->id(),

        ]);
        return to_route('chirps.index');
    });
});

require __DIR__ . '/auth.php';
