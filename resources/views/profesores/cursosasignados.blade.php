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
                    <th>Id Cisco</th>
                    <th>Modulo</th>
                    <th>Profesor</th>
                    <th>Feha inicio</th>
                    <th>Fecha fin</th>
                    <th>Cohorte</th>
                    @if (Auth::check() && Auth::user()->hasrole('administrador'))
                        <th>Accion</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($cursos as $curso)
                    <tr>
                        <td class="col-md-auto">{{ $curso->id_cisco }}</td>
                        <td class="col-md-auto">{{ $curso->nombre_modulo }}</td>
                        <td class="col-md-auto">{{ $curso->nombreper }}</td>
                        <td class="col-md-auto">{{ $curso->fecha_inicio }}</td>
                        <td class="col-md-auto">{{ $curso->fecha_fin }}</td>
                        <td class="col-md-auto">{{ $curso->nombre }}</td>
                        @if (Auth::check() && Auth::user()->hasrole('administrador'))
                            <td class="d-flex justify-content-center"> <a class="btn btn-primary" role="button"
                                    href="{{ url('/cursos/' . $curso->id . '/edit') }}"> Editar </a>

                                <a class="bnt btn-info"  role="button"
                                    href="{{ url('/profesores/' . $curso->id . '/cursoestudiantes') }}">Estudiantes</a>
                            </td>
                        @endif
                    </tr>
                @empty
                    <h2>No hay nada por mostrar </h2>

                @endforelse
            </tbody>
        </table>

        {{ $cursos->links('pagination::bootstrap-4') }}

        <a class="btn btn-primary" href="{{ url('/inicio/' . Auth::user()->id) }}"> Volver</a>
    </div>


@endsection
