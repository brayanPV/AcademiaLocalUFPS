@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Auth::user()->hasRole('administrador'))
        <div class="card">
          <div class="p-3 mb-2 bg-info text-white">Gestiona </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><a href="{{ url('/administradores/') }}">Administradores </a></li>
            <li class="list-group-item"><a href="{{ url('/anuncios/listanuncio') }}">Anuncios </a></li>
            <li class="list-group-item"><a href="{{ url('/certificaciones/listcertificaciones') }}">Certificaciones </a>
            </li>
            <li class="list-group-item"><a href="{{ url('/cohortes/listcohortes') }}">Cohortes </a></li>
            <li class="list-group-item"><a href="{{ url('/cursos/listcursos') }}">Cursos </a></li>
            <li class="list-group-item"><a href="{{ url('/estudiantes/listestudiantes') }}">Estudiantes </a></li>
            <li class="list-group-item"><a href="{{ url('/gruposinvestigacion/listgruposinvestigacion') }}">Grupos de
                    investigacion </a></li>
            <li class="list-group-item"><a href="{{ url('/modulos/listmodulos') }}">Modulos </a></li>
            <li class="list-group-item"><a href="{{ url('/profesores/listprofesores') }}">Profesores </a></li>
            <li class="list-group-item"><a href="{{ url('/tiponotas/listtiponotas') }}">Tipo de notas </a></li>
        </ul>
        </div>
        @endif
        @if (Auth::user()->hasRole('profesor'))
        <div class="card pg-4">
          <div class="p-3 mb-2 bg-white text-primary"> 
            <a href="{{ url('/profesores/' .Auth::user()->cedula .'/cursosasignados') }}">Cursos asignados </a>
          </div>
          
        </div>
        @endif
        @if (Auth::user()->hasRole('estudiante'))
            <ul class="list-group">
                <h2>Estudiante </h2>
                <li class="list-group-item">estudiante</li>
                <li class="list-group-item">Dapibus ac facilisis in</li>
                <li class="list-group-item">Morbi leo risus</li>
                <li class="list-group-item">Porta ac consectetur ac</li>
                <li class="list-group-item">Vestibulum at eros</li>
            </ul>
        @endif
    </div>
@endsection
