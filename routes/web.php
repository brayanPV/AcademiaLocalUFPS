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
use App\Http\Controllers\LineaInvestigacionController;
use App\Http\Controllers\PreinscritoController;
use App\Http\Controllers\TesisController;
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
Route::post('/certificaciones/buscarCertificacion', 'App\Http\Controllers\TipoCertificacionController@buscarCertificacion')->middleware('auth', 'role:administrador');
//cursos
Route::get('/cursos/create', 'App\Http\Controllers\CursoController@create')->middleware('auth', 'role:administrador');
Route::get('/cursos/modulos', 'App\Http\Controllers\CursoController@getModulos')->middleware('auth', 'role:administrador');
Route::get('/cursos/cohortes', 'App\Http\Controllers\CursoController@getCohortes')->middleware('auth', 'role:administrador');
Route::post('/cursos', 'App\Http\Controllers\CursoController@store')->middleware('auth', 'role:administrador');
Route::get('/cursos/{curso}/edit', 'App\Http\Controllers\CursoController@edit')->middleware('auth', 'role:administrador');
Route::patch('/cursos/{curso}', 'App\Http\Controllers\CursoController@update')->middleware('auth', 'role:administrador');
Route::delete('/cursos/{curso}', 'App\Http\Controllers\CursoController@destroy')->middleware('auth', 'role:administrador');
Route::get('/cursos/{curso}/{certificacion}/agregarestudiante', 'App\Http\Controllers\CursoController@createNuevoEstudianteCurso')->middleware('auth', 'role:administrador');
Route::post('/cursos/buscarCurso', 'App\Http\Controllers\CursoController@buscarCurso');
//Route::put('/profesores/{curso}/cursoestudiantes', 'App\Http\Controllers\ProfesorController@observacionUpdate')->middleware('auth', 'role:profesor');
//Route::post('/nuevoestudiantecurso', 'App\Http\Controllers\CursoController@createNuevoEstudianteCurso')->middleware('auth', 'role:administrador');
Route::post('/cursos/{curso}/cursoestudiantes', 'App\Http\Controllers\CursoController@storeNuevoEstudianteCurso')->middleware('auth', 'role:administrador');
//administradores
Route::post('/administradores/buscarAdmin','App\Http\Controllers\AdministradorController@buscarAdmin')->middleware('auth', 'role:administrador');
Route::resource('administradores', AdministradorController::class)->middleware(['auth', 'role:administrador']);
/*Route::get('/administradores/create', 'App\Http\Controllers\AdministradorController@create')->middleware('auth', 'role:administrador');
Route::post('/administradores', 'App\Http\Controllers\AdministradorController@store')->middleware('auth', 'role:administrador');
Route::get('/administradores/{administradore}/edit', 'App\Http\Controllers\AdministradorController@edit')->middleware('auth', 'role:administrador');
Route::put('/administradores/{administradore}', 'App\Http\Controllers\AdministradorController@update')->middleware('auth', 'role:administrador');
Route::delete('/administradores/{administradore}', 'App\Http\Controllers\AdministradorController@destroy')->middleware('auth', 'role:administrador');
Route::get('/administradores', 'App\Http\Controllers\AdministradorController@index')->middleware('auth', 'role:administrador');
*/
//cohortes
Route::get('/cohortes/create', 'App\Http\Controllers\CohorteController@create')->middleware('auth', 'role:administrador');
Route::post('/cohortes', 'App\Http\Controllers\CohorteController@store')->middleware('auth', 'role:administrador');
Route::get('/cohortes/{cohorte}/edit', 'App\Http\Controllers\CohorteController@edit')->middleware('auth', 'role:administrador');
Route::patch('/cohortes/{cohorte}', 'App\Http\Controllers\CohorteController@update')->middleware('auth', 'role:administrador');
Route::delete('/cohortes/{cohorte}', 'App\Http\Controllers\CohorteController@destroy')->middleware('auth', 'role:administrador');
Route::post('/cohortes/buscarCohorte', 'App\Http\Controllers\CohorteController@buscarCohorte')->middleware('auth', 'role:administrador');
//anuncios
Route::get('/anuncios/create', 'App\Http\Controllers\AnuncioController@create')->middleware('auth', 'role:administrador');
Route::post('/anuncios', 'App\Http\Controllers\AnuncioController@store')->middleware('auth', 'role:administrador');
Route::get('/anuncios/{anuncio}/edit', 'App\Http\Controllers\AnuncioController@edit')->middleware('auth', 'role:administrador');
Route::patch('/anuncios/{anuncio}', 'App\Http\Controllers\AnuncioController@update')->middleware('auth', 'role:administrador');
Route::delete('/anuncios/{anuncio}', 'App\Http\Controllers\AnuncioController@destroy')->middleware('auth', 'role:administrador');
Route::post('/anuncios/buscarAnuncio', 'App\Http\Controllers\AnuncioController@buscarAnuncio')->middleware('auth', 'role:administrador');

//grupos de investigacion
Route::get('/gruposinvestigacion/create', 'App\Http\Controllers\GrupoInvestigacionController@create')->middleware('auth', 'role:administrador');
Route::post('/gruposinvestigacion', 'App\Http\Controllers\GrupoInvestigacionController@store')->middleware('auth', 'role:administrador');
Route::get('/gruposinvestigacion/{gruposinvestigacio}/edit', 'App\Http\Controllers\GrupoInvestigacionController@edit')->middleware('auth', 'role:administrador');
Route::patch('/gruposinvestigacion/{gruposinvestigacio}', 'App\Http\Controllers\GrupoInvestigacionController@update')->middleware('auth', 'role:administrador');
Route::delete('/gruposinvestigacion/{gruposinvestigacio}', 'App\Http\Controllers\GrupoInvestigacionController@destroy')->middleware('auth', 'role:administrador');
Route::post('/gruposinvestigacion/buscarGrupo', 'App\Http\Controllers\GrupoInvestigacionController@buscarGrupoInvestigacion')->middleware('auth', 'role:administrador');
//modulos
Route::get('/modulos/listmodulos', [App\Http\Controllers\ModuloController::class, 'listModulo'])->middleware(['auth', 'role:administrador']);
Route::post('/modulos/buscarModulo', 'App\Http\Controllers\ModuloController@buscarModulo')->middleware(['auth', 'role:administrador']);
Route::resource('modulos', ModuloController::class)->middleware(['auth', 'role:administrador']);
/*Route::get('/modulos/create', 'App\Http\Controllers\ModuloController@create')->middleware('auth', 'role:administrador');
Route::post('/modulos', 'App\Http\Controllers\ModuloController@store')->middleware('auth', 'role:administrador');
Route::get('/modulos/{modulo}/edit', 'App\Http\Controllers\ModuloController@edit')->middleware('auth', 'role:administrador');
Route::patch('/modulos/{modulo}', 'App\Http\Controllers\ModuloController@update')->middleware('auth', 'role:administrador');
Route::delete('/modulos/{modulo}', 'App\Http\Controllers\ModuloController@destroy')->middleware('auth', 'role:administrador');
*/

//profesores  verMaterialApoyo materialapoyo/listmaterial
Route::get('/profesores/create', 'App\Http\Controllers\ProfesorController@create')->middleware('auth', 'role:administrador');
Route::post('/profesores', 'App\Http\Controllers\ProfesorController@store')->middleware('auth', 'role:administrador');
Route::get('/profesores/{profesore}/edit', 'App\Http\Controllers\ProfesorController@edit')->middleware('auth', 'role:administrador');
Route::patch('/profesores/{profesore}', 'App\Http\Controllers\ProfesorController@update')->middleware('auth', 'role:administrador');
Route::get('/profesores/{profesore}/cursosasignados', 'App\Http\Controllers\ProfesorController@verCursosAsignados')->middleware('auth', 'role:profesor');
Route::get('/profesores/{curso}/cursoestudiantes', 'App\Http\Controllers\ProfesorController@verEstudiantesCursos')->middleware('auth', 'role:profesor');
Route::get('/profesores/{curso}/{estudiante}/agregarobservacion', 'App\Http\Controllers\ProfesorController@agregarObservacion')->middleware('auth', 'role:profesor');
Route::get('/profesores/{curso}/{estudiante}/agregarnota', 'App\Http\Controllers\ProfesorController@agregarNota')->middleware('auth', 'role:profesor');
Route::put('/profesores/{curso}/cursoestudiantes', 'App\Http\Controllers\ProfesorController@observacionUpdate')->middleware('auth', 'role:profesor');
Route::patch('/profesores/{curso}/cursoestudiantes', 'App\Http\Controllers\ProfesorController@notaUpdate')->middleware('auth', 'role:profesor');
Route::delete('/profesores/{curso}/cursoestudiantes', 'App\Http\Controllers\ProfesorController@eliminarEstudianteCurso')->middleware('auth', 'role:administrador');
Route::delete('/profesores/{profesore}', 'App\Http\Controllers\ProfesorController@destroy')->middleware('auth', 'role:administrador');
Route::post('/profesores/buscarProfesor', 'App\Http\Controllers\ProfesorController@buscarProfesor')->middleware('auth', 'role:administrador');
Route::post('/profesores/buscarEstudianteCurso', 'App\Http\Controllers\ProfesorController@buscarEstudianteCurso')->middleware('auth', 'role:profesor');
Route::post('/profesores/buscarCursoAsignado', 'App\Http\Controllers\ProfesorController@buscarCursoAsignado')->middleware('auth', 'role:profesor');
Route::get('/profesores/{curso}/{estudiante}/agregarcertificadocarta', 'App\Http\Controllers\ProfesorController@agregarCertificadoCarta')->middleware('auth', 'role:profesor');
Route::post('/profesores/{curso}/cursoestudiantes', 'App\Http\Controllers\ProfesorController@certificadoCartaUpdate')->middleware('auth', 'role:profesor');
Route::post('/profesores/{curso}', 'App\Http\Controllers\ProfesorController@updateNotaPrueba')->middleware('auth', 'role:profesor');

//material de apoyo 
Route::get('/materialapoyo/{id_curso}/create', 'App\Http\Controllers\ProfesorController@createMaterialApoyo')->middleware('auth', 'role:profesor');
Route::post('/materialapoyo', 'App\Http\Controllers\ProfesorController@storeMaterialApoyo')->middleware('auth', 'role:profesor');
Route::get('/materialapoyo/{id}/listmaterial', 'App\Http\Controllers\ProfesorController@verMaterialApoyo')->middleware('auth', 'role:estudiante, profesor');
Route::get('/materialapoyo/{material}/edit', 'App\Http\Controllers\ProfesorController@editMaterialApoyo')->middleware('auth', 'role:profesor');
Route::patch('/materialapoyo/{material}', 'App\Http\Controllers\ProfesorController@updateMaterialApoyo')->middleware('auth', 'role:profesor');
Route::get('/materialapoyo/{mat}', 'App\Http\Controllers\ProfesorController@downloadFile')->middleware('auth', 'role:profesor');
Route::delete('/materialapoyo/{mat}', 'App\Http\Controllers\ProfesorController@destroyArchivoCurso')->middleware('auth', 'role:profesor');
//estudiantes
Route::get('/estudiantes/create', 'App\Http\Controllers\EstudianteController@create')->middleware(['auth', 'role:administrador']);
Route::post('/estudiantes', 'App\Http\Controllers\EstudianteController@store')->middleware(['auth', 'role:administrador']);
Route::get('/estudiantes/{estudiante}/edit', 'App\Http\Controllers\EstudianteController@edit')->middleware(['auth', 'role:administrador']);
Route::patch('/estudiantes/{estudiante}', 'App\Http\Controllers\EstudianteController@update')->middleware(['auth', 'role:administrador']);
Route::get('/estudiantes/{estudiante}/miscertificaciones', 'App\Http\Controllers\EstudianteController@verCertificaciones')->middleware(['auth', 'role:estudiante']);
Route::get('/estudiantes/{estudiante}/cursosasignados', 'App\Http\Controllers\EstudianteController@verCursosAsignados')->middleware(['auth', 'role:estudiante']);
Route::delete('/estudiantes/{estudiante}', 'App\Http\Controllers\EstudianteController@destroy')->middleware('auth', 'role:administrador');
Route::post('/estudiantes/buscarEstudiante', 'App\Http\Controllers\EstudianteController@buscarEstudiante')->middleware('auth', 'role:administrador');
Route::get('/estudiantes/{est_cert}/vernotascertificacion', 'App\Http\Controllers\EstudianteController@verNotasCertificacion')->middleware('auth', 'role:administrador');
Route::get('/estudiantes/{est_cert}/subirnotaprueba', 'App\Http\Controllers\EstudianteController@createNotaPrueba')->middleware('auth', 'role:administrador');
Route::post('/estudiantes/{est_cert}', 'App\Http\Controllers\EstudianteController@updateNotaPrueba')->middleware('auth', 'role:administrador');
Route::get('/estudiantes/{estudiante}/uploadreciboinscripcion', 'App\Http\Controllers\EstudianteController@viewUploadInscripcion')->middleware('auth', 'role:administrador');
Route::patch('/estudiantes/{estudiante}/inscripcion', 'App\Http\Controllers\EstudianteController@updateInscripcion')->middleware(['auth', 'role:administrador']);
Route::get('/estudiantes/{estudiante}/uploadrecibomatricula', 'App\Http\Controllers\EstudianteController@viewUploadMatricula')->middleware('auth', 'role:administrador');
Route::put('/estudiantes/{estudiante}/matricula', 'App\Http\Controllers\EstudianteController@updateMatricula')->middleware(['auth', 'role:administrador']);
Route::get('/estudiantes/{estudiante}/subircertificadofinal', 'App\Http\Controllers\EstudianteController@viewCertificadoFinal')->middleware(['auth', 'role:administrador']);
Route::post('/estudiantes/{estudiante}/certificado', 'App\Http\Controllers\EstudianteController@updateCertificado')->middleware(['auth', 'role:administrador']);
Route::get('estudiantes/{id}/informe_nota_final', 'App\Http\Controllers\EstudianteController@verInformeFinal')->middleware(['auth', 'role:administrador']);
Route::get('estudiantes/{id}/pdf', 'App\Http\Controllers\EstudianteController@crearPDF')->middleware(['auth', 'role:administrador']);

//preinscripcion
Route::get('/preinscripcion/create', 'App\Http\Controllers\PreinscritoController@create')->name('preinscribir');
Route::post('/preinscripcion', 'App\Http\Controllers\PreinscritoController@store')->name('preinscribirstore');
Route::get('/preinscripcion/{preinscripcion}/edit', 'App\Http\Controllers\PreinscritoController@edit')->middleware('auth', 'role:administrador');
Route::patch('/preinscripcion/{preinscripcion}', 'App\Http\Controllers\PreinscritoController@update')->middleware('auth', 'role:administrador');
Route::get('/preinscripcion/listpreinscripcion', 'App\Http\Controllers\PreinscritoController@listPreinscritos')->middleware('auth', 'role:administrador');
Route::post('/preinscripcion/buscarPreinscrito', 'App\Http\Controllers\PreinscritoController@buscarPreinscrito')->middleware('auth', 'role:administrador');
Route::put('/preinscripcion/{preinscripcion}', 'App\Http\Controllers\PreinscritoController@inscribir')->middleware('auth', 'role:administrador');
Route::delete('/preinscripcion/{preinscripcion}', 'App\Http\Controllers\PreinscritoController@destroy')->middleware('auth', 'role:administrador');
//inscrito 
Route::get('/inscritos/create', 'App\Http\Controllers\InscritoController@create')->middleware(['auth', 'role:administrador']);
Route::post('/inscritos', 'App\Http\Controllers\InscritoController@store')->middleware(['auth', 'role:administrador']);
Route::get('/inscritos/listinscritos', 'App\Http\Controllers\InscritoController@listInscritos')->middleware(['auth', 'role:administrador']);
Route::get('/inscritos/{inscrito}/uploadrecibo', 'App\Http\Controllers\InscritoController@viewUpload')->middleware(['auth', 'role:administrador']);
Route::put('/inscritos/{inscrito}', 'App\Http\Controllers\InscritoController@upload')->middleware(['auth', 'role:administrador']);
Route::get('/inscritos/{inscrito}/matricular', 'App\Http\Controllers\InscritoController@viewMatricular')->middleware(['auth', 'role:administrador']);
Route::get('/inscritos/{inscrito}/edit', 'App\Http\Controllers\InscritoController@edit')->middleware(['auth', 'role:administrador']);
Route::patch('/inscritos/{inscrito}', 'App\Http\Controllers\InscritoController@update')->middleware(['auth', 'role:administrador']);
Route::delete('/inscritos/{inscrito}', 'App\Http\Controllers\InscritoController@destroy')->middleware(['auth', 'role:administrador']);
Route::post('/matricularestudiante', 'App\Http\Controllers\InscritoController@matricular')->middleware(['auth', 'role:administrador']);
Route::post('/inscritos/buscarInscrito', 'App\Http\Controllers\InscritoController@buscarInscrito')->middleware(['auth', 'role:administrador']);

//Lineas investigacion
Route::post('/lineas/buscarLinea', 'App\Http\Controllers\LineaInvestigacionController@buscarLinea')->middleware('auth', 'role:administrador');
Route::resource('lineas', LineaInvestigacionController::class)->middleware(['auth', 'role:administrador']);
//Tesis 
Route::get('/tesis/{id}/asignarestudiante', 'App\Http\Controllers\TesisController@viewAsignarEstudiante')->middleware(['auth', 'role:administrador']);
Route::put('/tesis/{id}/', 'App\Http\Controllers\TesisController@asignarEstudianteUpdate')->middleware(['auth', 'role:administrador']);
Route::post('/tesis/buscarTesis', 'App\Http\Controllers\TesisController@buscarTesis')->middleware(['auth', 'role:administrador']);
Route::get('/tesis/{id}/agregarnota', 'App\Http\Controllers\TesisController@viewAgregarNota')->middleware(['auth', 'role:administrador']);
Route::post('/tesis/{id}/agregarnota', 'App\Http\Controllers\TesisController@notaUpdate')->middleware(['auth', 'role:administrador']);
Route::resource('tesis', TesisController::class)->middleware(['auth', 'role:administrador']);

//usuarios
Route::get('/usuarios/changepassword', 'App\Http\Controllers\UserController@viewChangePassword')->middleware('auth');
Route::post('/usuarios', 'App\Http\Controllers\UserController@updatePassword')->middleware('auth');

//estaticos
Route::get('/contacto/contac', 'App\Http\Controllers\ContactoController@viewContacto');
Route::post('/contacto', 'App\Http\Controllers\ContactoController@store');
Route::view('/soporte', 'soporte');
Route::view('/eventos', 'eventos');
Route::view('/nosotros', 'nosotros');


//listados
Route::get('/certificaciones/listcertificaciones', 'App\Http\Controllers\TipoCertificacionController@listTipoCertificacion');
Route::get('/certificaciones/card', 'App\Http\Controllers\TipoCertificacionController@cardCertificacion');
Route::get('/cursos/listcursos', [App\Http\Controllers\CursoController::class, 'listCursos'])->name("listcursos");
Route::get('/anuncios/listanuncio', [App\Http\Controllers\AnuncioController::class, 'anunciosprincipales'])->middleware('auth', 'role:administrador');
Route::get('/gruposinvestigacion/listgruposinvestigacion', [App\Http\Controllers\GrupoInvestigacionController::class, 'listGrupoInvestigacion'])->middleware('auth', 'role:administrador');
Route::get('/cohortes/listcohortes', [App\Http\Controllers\CohorteController::class, 'listCohorte'])->middleware('auth', 'role:administrador');
Route::get('/profesores/listprofesores', [App\Http\Controllers\ProfesorController::class, 'listProfesor'])->middleware('auth', 'role:administrador');
Route::get('/estudiantes/listestudiantes', [App\Http\Controllers\EstudianteController::class, 'listEstudiante'])->name('listestudiantes')->middleware('auth', 'role:administrador');



Auth::routes(['reset' => false, 'register' => false]);


