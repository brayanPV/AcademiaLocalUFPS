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
use App\Http\Controllers\PreinscritoController;
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
Route::get('/inicio/{inici}', 'App\Http\Controllers\UserController@show')->middleware('auth');
//carousel
Route::get('/certificaciones/carouselcertificacion', [App\Http\Controllers\TipoCertificacionController::class, 'carouselCertificacion'])->name("carouselcertificacion");
Route::get('/anuncios/carouselanuncios', [App\Http\Controllers\AnuncioController::class, 'index'])->name("carouselanuncios");
//post -> crear = store
//patch -> editar/actualizar = update
//certificaciones
Route::get('/certificaciones/create', 'App\Http\Controllers\TipoCertificacionController@create')->middleware('auth', 'role:administrador');
Route::post('/certificaciones', 'App\Http\Controllers\TipoCertificacionController@store')->middleware('auth', 'role:administrador');
Route::get('/certificaciones/{certificacione}/edit', 'App\Http\Controllers\TipoCertificacionController@edit')->middleware('auth', 'role:administrador');
Route::patch('/certificaciones/{certificacione}', 'App\Http\Controllers\TipoCertificacionController@update')->middleware('auth', 'role:administrador');
Route::get('/certificaciones/{certificacione}/vercurso', 'App\Http\Controllers\TipoCertificacionController@verCursos');
Route::delete('/certificaciones/{certificacione}', 'App\Http\Controllers\TipoCertificacionController@destroy')->middleware('auth', 'role:administrador');
Route::post('/certificaciones/buscarCertificacion','App\Http\Controllers\TipoCertificacionController@buscarCertificacion')->middleware('auth', 'role:administrador');
//cursos
Route::get('/cursos/create', 'App\Http\Controllers\CursoController@create')->middleware('auth', 'role:administrador');
Route::get('/cursos/modulos', 'App\Http\Controllers\CursoController@getModulos')->middleware('auth', 'role:administrador');
Route::get('/cursos/cohortes', 'App\Http\Controllers\CursoController@getCohortes')->middleware('auth', 'role:administrador');
Route::post('/cursos', 'App\Http\Controllers\CursoController@store')->middleware('auth', 'role:administrador');
Route::get('/cursos/{curso}/edit', 'App\Http\Controllers\CursoController@edit')->middleware('auth', 'role:administrador');
Route::patch('/cursos/{curso}', 'App\Http\Controllers\CursoController@update')->middleware('auth', 'role:administrador');
Route::delete('/cursos/{curso}', 'App\Http\Controllers\CursoController@destroy')->middleware('auth', 'role:administrador');
Route::get('/cursos/{curso}/{certificacion}/agregarestudiante', 'App\Http\Controllers\CursoController@createNuevoEstudianteCurso')->middleware('auth', 'role:administrador');
Route::post('/cursos/buscarCurso','App\Http\Controllers\CursoController@buscarCurso');
//Route::put('/profesores/{curso}/cursoestudiantes', 'App\Http\Controllers\ProfesorController@observacionUpdate')->middleware('auth', 'role:profesor');
//Route::post('/nuevoestudiantecurso', 'App\Http\Controllers\CursoController@createNuevoEstudianteCurso')->middleware('auth', 'role:administrador');
Route::post('/cursos/{curso}/cursoestudiantes', 'App\Http\Controllers\CursoController@storeNuevoEstudianteCurso')->middleware('auth', 'role:administrador');
//administradores
Route::get('/administradores/create', 'App\Http\Controllers\AdministradorController@create')->middleware('auth', 'role:administrador');
Route::post('/administradores', 'App\Http\Controllers\AdministradorController@store')->middleware('auth', 'role:administrador');
Route::get('/administradores/{administradore}/edit', 'App\Http\Controllers\AdministradorController@edit')->middleware('auth', 'role:administrador');
Route::put('/administradores/{administradore}', 'App\Http\Controllers\AdministradorController@update')->middleware('auth', 'role:administrador');
Route::delete('/administradores/{administradore}', 'App\Http\Controllers\AdministradorController@destroy')->middleware('auth', 'role:administrador');
Route::get('/administradores', 'App\Http\Controllers\AdministradorController@index')->middleware('auth', 'role:administrador');
Route::post('/administradores/buscarAdmin','App\Http\Controllers\AdministradorController@buscarAdmin')->middleware('auth', 'role:administrador');
//cohortes
Route::get('/cohortes/create', 'App\Http\Controllers\CohorteController@create')->middleware('auth', 'role:administrador');
Route::post('/cohortes', 'App\Http\Controllers\CohorteController@store')->middleware('auth', 'role:administrador');
Route::get('/cohortes/{cohorte}/edit', 'App\Http\Controllers\CohorteController@edit')->middleware('auth', 'role:administrador');
Route::patch('/cohortes/{cohorte}', 'App\Http\Controllers\CohorteController@update')->middleware('auth', 'role:administrador');
Route::delete('/cohortes/{cohorte}', 'App\Http\Controllers\CohorteController@destroy')->middleware('auth', 'role:administrador');
Route::post('/cohortes/buscarCohorte','App\Http\Controllers\CohorteController@buscarCohorte')->middleware('auth', 'role:administrador');
//anuncios
Route::get('/anuncios/create', 'App\Http\Controllers\AnuncioController@create')->middleware('auth', 'role:administrador');
Route::post('/anuncios', 'App\Http\Controllers\AnuncioController@store')->middleware('auth', 'role:administrador');
Route::get('/anuncios/{anuncio}/edit', 'App\Http\Controllers\AnuncioController@edit')->middleware('auth', 'role:administrador');
Route::patch('/anuncios/{anuncio}', 'App\Http\Controllers\AnuncioController@update')->middleware('auth', 'role:administrador');
Route::delete('/anuncios/{anuncio}', 'App\Http\Controllers\AnuncioController@destroy')->middleware('auth', 'role:administrador');
Route::post('/anuncios/buscarAnuncio','App\Http\Controllers\AnuncioController@buscarAnuncio')->middleware('auth', 'role:administrador');
//tiponotas
Route::get('/tiponotas/create', 'App\Http\Controllers\TipoNotaController@create')->middleware('auth', 'role:administrador');
Route::post('/tiponotas', 'App\Http\Controllers\TipoNotaController@store')->middleware('auth', 'role:administrador');
Route::get('/tiponotas/{tiponota}/edit', 'App\Http\Controllers\TipoNotaController@edit')->middleware('auth', 'role:administrador');
Route::patch('/tiponotas/{tiponota}', 'App\Http\Controllers\TipoNotaController@update')->middleware('auth', 'role:administrador');
Route::delete('/tiponotas/{tiponota}', 'App\Http\Controllers\TipoNotaController@destroy')->middleware('auth', 'role:administrador');
//gruposinvestigacion
Route::get('/gruposinvestigacion/create', 'App\Http\Controllers\GrupoInvestigacionController@create')->middleware('auth', 'role:administrador');
Route::post('/gruposinvestigacion', 'App\Http\Controllers\GrupoInvestigacionController@store')->middleware('auth', 'role:administrador');
Route::get('/gruposinvestigacion/{gruposinvestigacio}/edit', 'App\Http\Controllers\GrupoInvestigacionController@edit')->middleware('auth', 'role:administrador');
Route::patch('/gruposinvestigacion/{gruposinvestigacio}', 'App\Http\Controllers\GrupoInvestigacionController@update')->middleware('auth', 'role:administrador');
Route::delete('/gruposinvestigacion/{gruposinvestigacio}', 'App\Http\Controllers\GrupoInvestigacionController@destroy')->middleware('auth', 'role:administrador');
Route::post('/gruposinvestigacion/buscarGrupo','App\Http\Controllers\GrupoInvestigacionController@buscarGrupoInvestigacion')->middleware('auth', 'role:administrador');
//modulos
Route::get('/modulos/create', 'App\Http\Controllers\ModuloController@create')->middleware('auth', 'role:administrador');
Route::post('/modulos', 'App\Http\Controllers\ModuloController@store')->middleware('auth', 'role:administrador');
Route::get('/modulos/{modulo}/edit', 'App\Http\Controllers\ModuloController@edit')->middleware('auth', 'role:administrador');
Route::patch('/modulos/{modulo}', 'App\Http\Controllers\ModuloController@update')->middleware('auth', 'role:administrador');
Route::delete('/modulos/{modulo}', 'App\Http\Controllers\ModuloController@destroy')->middleware('auth', 'role:administrador');
Route::post('/modulos/buscarModulo','App\Http\Controllers\ModuloController@buscarModulo')->middleware('auth', 'role:administrador');
//profesores  verMaterialApoyo materialapoyo/listmaterial
Route::get('/profesores/create', 'App\Http\Controllers\ProfesorController@create')->middleware('auth', 'role:administrador');
Route::post('/profesores', 'App\Http\Controllers\ProfesorController@store')->middleware('auth', 'role:administrador');
Route::get('/profesores/{profesore}/edit', 'App\Http\Controllers\ProfesorController@edit')->middleware('auth', 'role:administrador');
Route::patch('/profesores/{profesore}', 'App\Http\Controllers\ProfesorController@update')->middleware('auth', 'role:administrador');
Route::get('/profesores/{profesore}/cursosasignados', 'App\Http\Controllers\ProfesorController@verCursosAsignados')->middleware('auth', 'role:profesor');
Route::get('/profesores/{curso}/cursoestudiantes', 'App\Http\Controllers\ProfesorController@verEstudiantesCursos')->middleware('auth', 'role:profesor');
Route::get('/profesores/{curso}/{estudiante}/agregarobservacion', 'App\Http\Controllers\ProfesorController@agregarObservacion')->middleware('auth', 'role:profesor');
Route::put('/profesores/{curso}/cursoestudiantes', 'App\Http\Controllers\ProfesorController@observacionUpdate')->middleware('auth', 'role:profesor');
Route::delete('/profesores/{profesore}', 'App\Http\Controllers\ProfesorController@destroy')->middleware('auth', 'role:administrador');
//material de apoyo downloadfile
Route::post('/materialapoyo', 'App\Http\Controllers\ProfesorController@createMaterialApoyo')->middleware('auth', 'role:profesor');
Route::post('/materialapoyoupload', 'App\Http\Controllers\ProfesorController@storeMaterialApoyo')->middleware('auth', 'role:profesor');
Route::post('/materialapoyo/listmaterial', 'App\Http\Controllers\ProfesorController@verMaterialApoyo')->middleware('auth', 'role:estudiante, profesor');
Route::get('/materialapoyo/{material}/edit', 'App\Http\Controllers\ProfesorController@editMaterialApoyo')->middleware('auth', 'role:profesor');
Route::patch('/materialapoyo/{material}', 'App\Http\Controllers\ProfesorController@updateMaterialApoyo')->middleware('auth', 'role:profesor');
Route::get('/materialapoyo/{mat}', 'App\Http\Controllers\ProfesorController@downloadFile')->middleware('auth', 'role:profesor');
//estudiantes
Route::get('/estudiantes/create', 'App\Http\Controllers\EstudianteController@create')->middleware('auth', 'role:administrador');
Route::post('/estudiantes', 'App\Http\Controllers\EstudianteController@store')->middleware('auth', 'role:administrador');
Route::get('/estudiantes/{estudiante}/edit', 'App\Http\Controllers\EstudianteController@edit')->middleware('auth', 'role:administrador');
Route::patch('/estudiantes/{estudiante}', 'App\Http\Controllers\EstudianteController@update')->middleware('auth', 'role:administrador');
Route::get('/estudiantes/{estudiante}/cursosasignados', 'App\Http\Controllers\EstudianteController@verCursosAsignados')->middleware('auth', 'role:estudiante');
Route::delete('/estudiantes/{estudiante}', 'App\Http\Controllers\EstudianteController@destroy')->middleware('auth', 'role:administrador');
Route::post('/estudiantes/buscarEstudiante','App\Http\Controllers\EstudianteController@buscarEstudiante')->middleware('auth', 'role:administrador');
//preinscripcion
Route::get('/preinscripcion/create', 'App\Http\Controllers\PreinscritoController@create')->name('preinscribir');
Route::post('/preinscripcion', 'App\Http\Controllers\PreinscritoController@store')->name('preinscribirstore');
Route::get('/preinscripcion/{preinscripcion}/edit', 'App\Http\Controllers\PreinscritoController@edit')->middleware('auth', 'role:administrador');
Route::patch('/preinscripcion/{preinscripcion}', 'App\Http\Controllers\PreinscritoController@update')->middleware('auth', 'role:administrador');
Route::get('/preinscripcion/listpreinscripcion', 'App\Http\Controllers\PreinscritoController@listPreinscritos')->middleware('auth', 'role:administrador');
Route::post('/preinscripcion/buscarPreinscrito','App\Http\Controllers\PreinscritoController@buscarPreinscrito')->middleware('auth', 'role:administrador');
Route::put('/preinscripcion/{preinscripcion}', 'App\Http\Controllers\PreinscritoController@inscribir')->middleware('auth', 'role:administrador');
Route::delete('/preinscripcion/{preinscripcion}', 'App\Http\Controllers\PreinscritoController@destroy')->middleware('auth', 'role:administrador');
//inscrito 
Route::get('/inscritos/create', 'App\Http\Controllers\InscritoController@create')->middleware('auth', 'role:administrador');
Route::post('/inscritos', 'App\Http\Controllers\InscritoController@store')->middleware('auth', 'role:administrador');
Route::get('/inscritos/listinscritos', 'App\Http\Controllers\InscritoController@listInscritos')->middleware('auth', 'role:administrador');
Route::get('/inscritos/{inscrito}/uploadrecibo', 'App\Http\Controllers\InscritoController@viewUpload')->middleware('auth', 'role:administrador');
Route::put('/inscritos/{inscrito}', 'App\Http\Controllers\InscritoController@upload')->middleware('auth', 'role:administrador');
Route::get('/inscritos/{inscrito}/matricular', 'App\Http\Controllers\InscritoController@viewMatricular')->middleware('auth', 'role:administrador');
Route::get('/inscritos/{inscrito}/edit', 'App\Http\Controllers\InscritoController@edit')->middleware('auth', 'role:administrador');
Route::post('/matricularestudiante', 'App\Http\Controllers\InscritoController@matricular')->middleware('auth', 'role:administrador');

//Route::get('/estudiantes/{estudiante}/edit', 'App\Http\Controllers\InscritoController@edit')->middleware('auth','role:administrador');
//Route::patch('/estudiantes', 'App\Http\Controllers\InscritoController@update')->middleware('auth','role:administrador');
//listados cardCertificacion
Route::get('/certificaciones/listcertificaciones', 'App\Http\Controllers\TipoCertificacionController@listTipoCertificacion');
Route::get('/certificaciones/card', 'App\Http\Controllers\TipoCertificacionController@cardCertificacion');
Route::get('/cursos/listcursos', [App\Http\Controllers\CursoController::class, 'listCursos'])->name("listcursos");
Route::get('/anuncios/listanuncio', [App\Http\Controllers\AnuncioController::class, 'anunciosprincipales'])->middleware('auth', 'role:administrador');
Route::get('/tiponotas/listtiponotas', [App\Http\Controllers\TipoNotaController::class, 'listTipoNotas'])->middleware('auth', 'role:administrador');
Route::get('/gruposinvestigacion/listgruposinvestigacion', [App\Http\Controllers\GrupoInvestigacionController::class, 'listGrupoInvestigacion'])->middleware('auth', 'role:administrador');
Route::get('/cohortes/listcohortes', [App\Http\Controllers\CohorteController::class, 'listCohorte'])->middleware('auth', 'role:administrador');
Route::get('/modulos/listmodulos', [App\Http\Controllers\ModuloController::class, 'listModulo'])->middleware('auth', 'role:administrador');
Route::get('/profesores/listprofesores', [App\Http\Controllers\ProfesorController::class, 'listProfesor'])->middleware('auth', 'role:administrador');
Route::get('/estudiantes/listestudiantes', [App\Http\Controllers\EstudianteController::class, 'listEstudiante'])->name('listestudiantes');



//Route::get('anuncios/listanuncio', [AnuncioController::class, 'anunciosprincipales'])->name('listanuncios');
//Route::get('anuncios/listanuncio', 'AnuncioController@anunciosprincipales');



//Route::get('cursos', CursoController::class);
Auth::routes(['reset' => false, 'register' => false]);
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Auth::routes();
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
