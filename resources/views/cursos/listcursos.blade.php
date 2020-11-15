@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Session::has('Mensaje'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('Mensaje') }}
            </div>
        @endif
        @if (Auth::check() && Auth::user()->hasrole('administrador'))
            <div class="alert alert-primary" role="alert">
                <h2>Gestion de cursos</h2>
            </div>
            <a class="btn btn-success" href="{{ url('/cursos/create') }}"><i class="fas fa-plus-circle"></i> Agregar
                Curso</a>
        @else
            <div class="alert alert-primary" role="alert">
                <h2>Cursos</h2>
            </div>

        @endif
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
                                    href="{{ url('/cursos/' . $curso->id . '/edit') }}"><i class="fas fa-edit"></i> Editar </a>
                                <p>⠀</p>
                                <form method="post" action="{{ url('/cursos/' . $curso->id) }}" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('¿Esta seguro que desea eliminar el curso?    ');"><i
                                            class="fas fa-trash"></i> Borrar </button>
                                </form>
                                <p>⠀</p>
                                <a class="btn btn-info p-1" href="{{ url('/profesores/' . $curso->id . '/cursoestudiantes') }}"
                                    style="display: inline"><i class="fas fa-users"></i> Estudiantes </a>
                            </td>
                        @endif
                    </tr>
                @empty
                    <h2>No hay nada por mostrar </h2>

                @endforelse
            </tbody>
        </table>
        <div class="row">
            <h5>Total de cursos {{ $cursos->total() }} </h5>
            <div class="col-11">
                
                {{ $cursos->links('pagination::bootstrap-4') }}
            </div>
            <div class="col-1">
                <a class="btn btn-primary" href="{{ Auth::check() ? url('/inicio/' . Auth::user()->id) : url('/') }}">inicio</a>
            </div>
        </div>
    </div>


@endsection
