@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="alert alert-primary" role="alert">
            <h2>Cursos</h2>
        </div>


    </div>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Cedula</th>
                    <th>Nombre</th>
                    <th>Observacion</th>
                    <th>Estado</th>
                    @if (Auth::check() && Auth::user()->hasrole('administrador'))
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
                        @if (Auth::check() && Auth::user()->hasrole('administrador'))
                            <td class="d-flex justify-content-center"> <a class="btn btn-primary text-left" role="button"
                                    href="{{ url('/cursos/' . $estudiante->id . '/edit') }}"> Agregar obsrvacion </a>
                            </br>
                                <a class="btn btn-info"  role="button"
                                    href="{{ url('/profesores/' . $estudiante->id . '/cursoestudiantes') }}">Agregar notas</a>
                            </td>
                        @endif
                    </tr>
                @empty
                    <h2>No hay nada por mostrar </h2>

                @endforelse
            </tbody>
        </table>

        <a class="btn btn-primary" href="{{ url('/profesores/' . Auth::user()->cedula .'/cursosasignados')}}"> Volver</a>
    </div>


@endsection
