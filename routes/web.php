<?php

use App\Http\Controllers\AnuncioController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\TipoNotaController;

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


Route::get('/', [App\Http\Controllers\CursoController::class, 'index'])->name('welcome');
Route::get('/cursos/carouselcursos', [App\Http\Controllers\CursoController::class, 'index'])->name("carouselcursos");
Route::get('/cursos/listcursos', [App\Http\Controllers\CursoController::class, 'listCursos'])->name("listcursos");
Route::get('/anuncios/carouselanuncios', [App\Http\Controllers\AnuncioController::class, 'index'])->name("carouselanuncios");
Route::get('/anuncios/listanuncio', [App\Http\Controllers\AnuncioController::class, 'anunciosprincipales']); //->middleware('auth');
Route::get('/tiponotas/listtiponotas', [App\Http\Controllers\TipoNotaController::class, 'listTipoNotas'])->name('listtiponotas');
Route::resource('anuncios', AnuncioController::class);
Route::resource('cursos', CursoController::class); //->middleware('auth'); activar esto cuando tenga login
Route::resource('tiponotas', TipoNotaController::class);

//Route::get('anuncios/listanuncio', [AnuncioController::class, 'anunciosprincipales'])->name('listanuncios');
//Route::get('anuncios/listanuncio', 'AnuncioController@anunciosprincipales');



//Route::get('cursos', CursoController::class);
Auth::routes();
Route::match(['get', 'post'], 'register', function () {
    return redirect('/');
});
Auth::routes(['reset' => false, 'register' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
