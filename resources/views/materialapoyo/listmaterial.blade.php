@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="alert alert-primary" role="alert">
            <h2>Archivos</h2>
        </div>
        @if (Auth::check() && Auth::user()->hasrole('profesor'))
            <a class="btn btn-success" href="{{ url('/materialapoyo/' . $curso->id . '/create') }}"><i
                    class="fas fa-plus-circle"></i> Agregar </a>
        @endif
    </div>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Descargar</th>
                    @if (Auth::check() && Auth::user()->hasrole('profesor'))
                        <th>Accion</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($material as $mat)
                    <tr>
                        <td class="col-md-auto">{{ $mat->nombre }}</td>
                        <td class="col-md-auto">{{ $mat->descripcion }}</td>
                        <td class="col-md-auto">

                            <a href="{{ asset('storage') . '/' . $mat->url }}" target="_blank" class="btn btn-success">
                                <i class="fa fa-download"></i> Descargar
                            </a>
                        </td>
                        @if (Auth::check() && Auth::user()->hasrole('profesor'))
                            <td class="d-flex">
                                <a class="btn btn-primary" href="{{ url('/materialapoyo/' . $mat->id . '/edit') }}"><i
                                        class="fas fa-edit"></i> Editar </a>

                                <p>⠀</p>
                                <form method="post" action="{{ url('/materialapoyo/' . $mat->id) }}" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <input class="form-control" type="hidden" name="id_curso" id="id_curso"
                                        value="{{ $mat->id_curso }}">
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('¿Esta seguro que desea eliminar este archivo?');"><i
                                            class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>

                            </td>

                        @endif
                    </tr>
                @empty
                    <h2>No hay nada por mostrar </h2>

                @endforelse
            </tbody>
        </table>
        <div class="row">
            <h5 id="total">Total de estudiantes: {{ $material->total() }} </h5>
            <div class="col-10" id="pagination">
                {{ $material->links('pagination::bootstrap-4') }}
            </div>
            <div class="col-2">
                <a class="btn btn-primary float-right"
                    href="{{ url('profesores/' . $curso->ced_profesor . '/cursosasignados') }}"> <i
                        class="fas fa-arrow-left"></i>Volver</a>
            </div>
        </div>

    </div>
@endsection
