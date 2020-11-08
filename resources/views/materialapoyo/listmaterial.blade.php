@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="alert alert-primary" role="alert">
            <h2>Archivos</h2>
        </div>
        <form method="post" action="{{ url('/materialapoyo') }}" style="display: inline">
            @csrf
            <input type="hidden" id="id" name="id" value="{{ $curso->id }}">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-plus-circle"></i> Agregar
            </button>
        </form>
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
                        <td class="col-md-auto"><a href="{{ asset($mat->url) }}" target="_blank">
                                <button class="btn btn-success"><i class="fa fa-download"></i> Descargar</button>
                            </a></td>
                        @if (Auth::check() && Auth::user()->hasrole('profesor'))
                            <td class="d-flex justify-content-center">

                                <form method="get" action="{{ url('/materialapoyo/' . $mat->id . '/edit') }}" class="form">
                                    <input class="form-control" type="hidden" name="id_curso" id="id_curso" value="{{ $curso->id }}">
                                    <div class="input-group" id="submit-group">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-edit"></i> Editar
                                        </button>
                                    </div>
                                </form>
                                <p>⠀</p>
                                <form method="post" action="{{ url('/materialapoyo/' . $mat->id) }}" style="display: inline">
                                    @csrf
                                    @method('DELETE')
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

        <a class="btn btn-primary" href="{{ url('/profesores/' . Auth::user()->cedula . '/cursosasignados') }}"><i
                class="fas fa-arrow-left"></i> Volver</a>
    </div>


@endsection
