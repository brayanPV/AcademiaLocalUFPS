@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Session::has('Mensaje'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('Mensaje') }}
        </div>
        @endif
        <div class="alert alert-primary" role="alert">
            <h2>Gestion de cursos</h2>
        </div>
        <a class="btn btn-success" href="{{ url('/cursos/create') }}"> Agregar Curso</a>

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
                    <th>Imagen</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cursos as $curso)
                    <tr>
                        <td class="col"> {{ $curso->id_cisco }}</td>
                        <td class="col">{{ $curso->nombre_modulo }}</td>
                        <td class="col">{{ $curso->cedula }}</td>
                        <td class="col">{{ $curso->fecha_inicio }}</td>
                        <td class="col">{{ $curso->fecha_fin }}</td>
                        <td class="col">{{ $curso->nombre }}</td>
                        <td class="col"> <img src="{{ asset('storage') . '/' . $curso->imagen }}"
                                alt="" width="250"></td>
                        <td class="d-flex justify-content-center"> <a class="btn btn-primary" role="button"
                                href="{{ url('/cursos/' . $curso->id . '/edit') }}"> Editar </a>
                            <form method="post" action="{{ url('/cursos/' . $curso->id) }}" style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('¿Esta seguro que desea eliminar el curso?    ');">Borrar </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <h2>No hay nada por mostrar </h2>

                @endforelse
            </tbody>
        </table>
        {{ $cursos->links('pagination::bootstrap-4') }}
    </div>


@endsection
