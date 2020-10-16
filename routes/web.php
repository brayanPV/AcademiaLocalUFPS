<?php

use App\Http\Controllers\AnuncioController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 
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


Route::view('/', 'welcome')->name('welcome');
/*Route::view('/about', 'about')->name('about');
Route::view('/contac', 'contac')->name('contac');
Route::view('/cursos', 'cursos')->name('cursos');
Route::view('/preinscripcion', 'preinscripcion')->name('preinscripcion');
Route::view('/soporte', 'soporte')->name('soporte');*/
Route::get('/anuncios/carouselanuncios', [App\Http\Controllers\AnuncioController::class, 'index']);
Route::get('/anuncios/listanuncio', [App\Http\Controllers\AnuncioController::class, 'anunciosprincipales']); //->middleware('auth');
Route::resource('anuncios', AnuncioController::class); //->middleware('auth'); activar esto cuando tenga login
//Route::get('anuncios/listanuncio', [AnuncioController::class, 'anunciosprincipales'])->name('listanuncios');
//Route::get('anuncios/listanuncio', 'AnuncioController@anunciosprincipales');

Auth::routes();
Route::match(['get', 'post'], 'register', function(){
    return redirect('/');
});
Auth::routes(['reset' => false, 'register' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
