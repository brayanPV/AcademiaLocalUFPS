<?php

use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\AnuncioController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\GrupoInvestigacionController;
use App\Http\Controllers\TipoNotaController;
use App\Http\Controllers\CohorteController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InscritoController;
use App\Http\Middleware\CheckRole;

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

//index
Route::get('/', [App\Http\Controllers\TipoCertificacionController::class, 'index'])->name('welcome');
Route::get('/inicio/{inici}','App\Http\Controllers\UserController@show')->middleware('auth');
//carousel
Route::get('/certificaciones/carouselcertificacion', [App\Http\Controllers\TipoCertificacionController::class, 'carouselCertificacion'])->name("carouselcertificacion");
Route::get('/anuncios/carouselanuncios', [App\Http\Controllers\AnuncioController::class, 'index'])->name("carouselanuncios");

//post -> crear = store
//patch -> editar/actualizar = update
//certificaciones
Route::get('/certificaciones/create', 'App\Http\Controllers\TipoCertificacionController@create')->middleware('auth','role:administrador');
Route::post('/certificaciones', 'App\Http\Controllers\TipoCertificacionController@store')->middleware('auth','role:administrador');
Route::get('/certificaciones/{certificacione}/create', 'App\Http\Controllers\TipoCertificacionController@edit')->middleware('auth','role:administrador');
Route::patch('/certificaciones/{certificacione}', 'App\Http\Controllers\TipoCertificacionController@update')->middleware('auth','role:administrador');
Route::get('/certificaciones/{certificacione}/vercurso', 'App\Http\Controllers\TipoCertificacionController@verCursos');
//cursos
Route::get('/cursos/create', 'App\Http\Controllers\CursoController@create')->middleware('auth','role:administrador');
Route::post('/cursos', 'App\Http\Controllers\CursoController@store')->middleware('auth','role:administrador');
Route::get('/cursos/{curso}/edit', 'App\Http\Controllers\CursoController@edit')->middleware('auth','role:administrador');
Route::patch('/cursos/{curso}', 'App\Http\Controllers\CursoController@update')->middleware('auth','role:administrador');
//administradores
Route::get('/administradores/create', 'App\Http\Controllers\AdministradorController@create')->middleware('auth','role:administrador');
Route::post('/administradores', 'App\Http\Controllers\AdministradorController@store')->middleware('auth','role:administrador');
Route::get('/administradores/{administradore}/edit', 'App\Http\Controllers\AdministradorController@edit')->middleware('auth','role:administrador');
Route::put('/administradores/{administradore}', 'App\Http\Controllers\AdministradorController@update')->middleware('auth','role:administrador');
Route::delete('/administradores/{administradore}', 'App\Http\Controllers\AdministradorController@destroy')->middleware('auth','role:administrador');
Route::get('/administradores', 'App\Http\Controllers\AdministradorController@index')->middleware('auth','role:administrador');
//cohortes
Route::get('/cohortes/create', 'App\Http\Controllers\CohorteController@create')->middleware('auth','role:administrador');
Route::post('/cohortes', 'App\Http\Controllers\CohorteController@store')->middleware('auth','role:administrador');
Route::get('/cohortes/{cohorte}/edit', 'App\Http\Controllers\CohorteController@edit')->middleware('auth','role:administrador');
Route::patch('/cohortes/{cohorte}', 'App\Http\Controllers\CohorteController@update')->middleware('auth','role:administrador');
//anuncios

Route::get('/anuncios/create', 'App\Http\Controllers\AnuncioController@create')->middleware('auth','role:administrador');
Route::post('/anuncios', 'App\Http\Controllers\AnuncioController@store')->middleware('auth','role:administrador');
Route::get('/anuncios/{anuncio}/edit', 'App\Http\Controllers\AnuncioController@edit')->middleware('auth','role:administrador');
Route::patch('/anuncios/{anuncio}', 'App\Http\Controllers\AnuncioController@update')->middleware('auth','role:administrador');
//tiponotas
Route::get('/tiponotas/create', 'App\Http\Controllers\TipoNotaController@create')->middleware('auth','role:administrador');
Route::post('/tiponotas', 'App\Http\Controllers\TipoNotaController@store')->middleware('auth','role:administrador');
Route::get('/tiponotas/{tiponota}/edit', 'App\Http\Controllers\TipoNotaController@edit')->middleware('auth','role:administrador');
Route::patch('/tiponotas/{tiponota}', 'App\Http\Controllers\TipoNotaController@update')->middleware('auth','role:administrador');
//gruposinvestigacion
Route::get('/gruposinvestigacion/create', 'App\Http\Controllers\GrupoInvestigacionController@create')->middleware('auth','role:administrador');
Route::post('/gruposinvestigacion', 'App\Http\Controllers\GrupoInvestigacionController@store')->middleware('auth','role:administrador');
Route::get('/gruposinvestigacion/{gruposinvestigacio}/edit', 'App\Http\Controllers\GrupoInvestigacionController@edit')->middleware('auth','role:administrador');
Route::patch('/gruposinvestigacion/{gruposinvestigacio}', 'App\Http\Controllers\GrupoInvestigacionController@update')->middleware('auth','role:administrador');
//modulos
Route::get('/modulos/create', 'App\Http\Controllers\ModuloController@create')->middleware('auth','role:administrador');
Route::post('/modulos', 'App\Http\Controllers\ModuloController@store')->middleware('auth','role:administrador');
Route::get('/modulos/{modulo}/edit', 'App\Http\Controllers\ModuloController@edit')->middleware('auth','role:administrador');
Route::patch('/modulos/{modulo}', 'App\Http\Controllers\ModuloController@update')->middleware('auth','role:administrador');
//profesores 
Route::get('/profesores/create', 'App\Http\Controllers\ProfesorController@create')->middleware('auth','role:administrador');
Route::post('/profesores', 'App\Http\Controllers\ProfesorController@store')->middleware('auth','role:administrador');
Route::get('/profesores/{profesore}/edit', 'App\Http\Controllers\ProfesorController@edit')->middleware('auth','role:administrador');
Route::patch('/profesores/{profesore}', 'App\Http\Controllers\ProfesorController@update')->middleware('auth','role:administrador');
Route::get('/profesores/{profesore}/cursosasignados', 'App\Http\Controllers\ProfesorController@verCursosAsignados')->middleware('auth','role:profesor');
Route::get('/profesores/{curso}/cursoestudiantes', 'App\Http\Controllers\ProfesorController@verEstudiantesCursos')->middleware('auth','role:profesor');
Route::get('/profesores/{curso}/{estudiante}/agregarobservacion', 'App\Http\Controllers\ProfesorController@agregarObservacion')->middleware('auth','role:profesor');
Route::put('/profesores/{curso}/cursoestudiantes', 'App\Http\Controllers\ProfesorController@observacionUpdate')->middleware('auth','role:profesor');
//estudiantes
Route::get('/estudiantes/create', 'App\Http\Controllers\EstudianteController@create')->middleware('auth','role:administrador');
Route::post('/estudiantes', 'App\Http\Controllers\EstudianteController@store')->middleware('auth','role:administrador');
Route::get('/estudiantes/{estudiante}/edit', 'App\Http\Controllers\EstudianteController@edit')->middleware('auth','role:administrador');
Route::patch('/estudiantes/{estudiante}', 'App\Http\Controllers\EstudianteController@update')->middleware('auth','role:administrador');
Route::get('/estudiantes/{estudiante}/cursosasignados', 'App\Http\Controllers\EstudianteController@verCursosAsignados')->middleware('auth','role:estudiante');
//inscrito //aun falta esto
Route::get('/estudiantes/{estudiante}/edit', 'App\Http\Controllers\InscritoController@edit')->middleware('auth','role:administrador');
Route::patch('/estudiantes', 'App\Http\Controllers\InscritoController@update')->middleware('auth','role:administrador');
//listados cardCertificacion
Route::get('/certificaciones/listcertificaciones', 'App\Http\Controllers\TipoCertificacionController@listTipoCertificacion');
Route::get('/certificaciones/card', 'App\Http\Controllers\TipoCertificacionController@cardCertificacion');
Route::get('/cursos/listcursos', [App\Http\Controllers\CursoController::class, 'listCursos'])->name("listcursos");
Route::get('/anuncios/listanuncio', [App\Http\Controllers\AnuncioController::class, 'anunciosprincipales'])->middleware('auth','role:administrador');
Route::get('/tiponotas/listtiponotas', [App\Http\Controllers\TipoNotaController::class, 'listTipoNotas'])->middleware('auth','role:administrador');
Route::get('/gruposinvestigacion/listgruposinvestigacion', [App\Http\Controllers\GrupoInvestigacionController::class, 'listGrupoInvestigacion'])->middleware('auth','role:administrador');
Route::get('/cohortes/listcohortes', [App\Http\Controllers\CohorteController::class, 'listCohorte'])->middleware('auth','role:administrador');
Route::get('/modulos/listmodulos', [App\Http\Controllers\ModuloController::class, 'listModulo'])->middleware('auth','role:administrador');
Route::get('/profesores/listprofesores', [App\Http\Controllers\ProfesorController::class, 'listProfesor'])->middleware('auth','role:administrador');
Route::get('/estudiantes/listestudiantes', [App\Http\Controllers\EstudianteController::class, 'listEstudiante'])->name('listestudiantes');

//preinscripcion
Route::get('/preinscripcion/preinscripcion', [App\Http\Controllers\InscritoController::class, 'preInscribirView'])->name('preinscribir');

//Route::get('anuncios/listanuncio', [AnuncioController::class, 'anunciosprincipales'])->name('listanuncios');
//Route::get('anuncios/listanuncio', 'AnuncioController@anunciosprincipales');



//Route::get('cursos', CursoController::class);
Auth::routes(['reset' => false, 'register' => false]);
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Auth::routes();
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
