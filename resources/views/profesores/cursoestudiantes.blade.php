@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="alert alert-primary" role="alert">
            <h2>Estudiantes del curso {{ $curso[0]->nombre }}</h2>
        </div>
        @if (Auth::user()->hasrole('administrador'))
            <a role="button" class="btn btn-success p-1"
                href="{{ url('cursos', ['curso' => $curso[0]->id, 'certificacion' => $curso[0]->tipo_certificacion, 'agregarestudiante']) }}">
                <i class="fas fa-user-plus"></i> Agregar Estudiante </a>
        @endif
    </div>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Cedula</th>
                    <th>Nombre</th>
                    <th>Observacion</th>
                    <th>Estado</th>
                    @if (Auth::check() && Auth::user()->hasrole('profesor'))
                        <th>Accion</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($estudiantes as $estudiante)
                    <tr>
                        <td class="col-md-auto">{{ $estudiante->cedula }}</td>
                        <td class="col-md-auto">{{ $estudiante->nombre }}</td>
                        <td class="col-md-auto">{{ $estudiante->observaciones }}</td>
                        <td class="col-md-auto">{{ $estudiante->estado }}</td>
                        @if (Auth::check() && Auth::user()->hasrole('profesor') && Auth::user()->cedula == $curso[0]->ced_profesor)

                            <td class="d-flex p-1">

                                <a class="btn btn-warning p-3" role="button"
                                    href="{{ url('profesores', ['curso' => $estudiante->id, 'estudiante' => $estudiante->cedula, 'agregarobservacion']) }}"
                                    style="display: inline"> Agregar observacion </a>
                                </br>
                                <p>⠀ </p>
                                <a class="btn btn-success p-3" role="button"
                                    href="{{ url('/profesores/' . $estudiante->id . '/agregarnota') }}">Agregar notas</a>
                            </td>
                        @endif
                    </tr>
                @empty
                    <h2>No hay nada por mostrar </h2>

                @endforelse
            </tbody>
        </table>
        {{ $estudiantes->links('pagination::bootstrap-4') }}
        <a class="btn btn-primary" href="{{ url('/profesores/' . Auth::user()->cedula . '/cursosasignados') }}"> Volver</a>
    </div>


@endsection
