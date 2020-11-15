@extends('layouts.app')

@section('content')
    <div class="container">
        <div id="accordion">
            @if (Auth::user()->hasRole('administrador'))
              <div class="card pg-4">
                    <h5 class="p-3 mb-2">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false"
                            aria-controls="collapseOne">
                            <i class="fas fa-users-cog"></i>  Gestiona
                        </button>
                    </h5>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action"><a href="{{ url('/administradores/') }}"> Administradores </a></li>
                        <li class="list-group-item list-group-item-action"><a href="{{ url('/anuncios/listanuncio') }}">Anuncios </a></li>
                        <li class="list-group-item list-group-item-action"><a
                                href="{{ url('/certificaciones/listcertificaciones') }}">Certificaciones
                            </a>
                        </li>
                        <li class="list-group-item list-group-item-action"><a href="{{ url('/cohortes/listcohortes') }}">Cohortes </a></li>
                        <li class="list-group-item list-group-item-action"><a href="{{ url('/cursos/listcursos') }}">Cursos </a></li>
                        <li class="list-group-item list-group-item-action"><a href="{{ url('/estudiantes/listestudiantes') }}">Estudiantes </a>
                        </li>
                        <li class="list-group-item"><a
                                href="{{ url('/gruposinvestigacion/listgruposinvestigacion') }}">Grupos
                                de
                                investigacion </a></li>
                        <li class="list-group-item list-group-item-action"><a href="{{ url('/modulos/listmodulos') }}">Modulos </a></li>
                        <li class="list-group-item list-group-item-action"><a href="{{ url('/preinscripcion/listpreinscripcion') }}">Preinscripcion </a></li>
                        <li class="list-group-item list-group-item-action"><a href="{{ url('/profesores/listprofesores') }}">Profesores </a></li>
                        <li class="list-group-item list-group-item-action"><a href="{{ url('/tiponotas/listtiponotas') }}">Tipo de notas </a></li>
                    </ul>
                </div>
                </div>
            @endif
            @if (Auth::user()->hasRole('profesor'))
                <div class="card pg-4">
                    <h5 class="p-3 mb-2">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <i class="fas fa-chalkboard-teacher"></i>  Docencia
                      </button>
                    </h5>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action"><a
                                href="{{ url('/profesores/' . Auth::user()->cedula . '/cursosasignados') }}">Cursos asignados
                            </a></li>
                    </ul>
                </div>
                </div>
            @endif
            @if (Auth::user()->hasRole('estudiante'))
                <div class="card pg-4">
                  <h5 class="p-3 mb-2">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <i class="fas fa-book"></i>  Estudiante
                    </button>
                  </h5>
                  <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <li class="list-group-item list-group-item-action"><a
                            href="{{ url('/estudiantes/' . Auth::user()->cedula . '/cursosasignados') }}">Mis cursos </a>
                    </li>
                </div>
                </div>
            @endif
        </div>
    </div>
@endsection
