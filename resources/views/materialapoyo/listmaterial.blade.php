@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="alert alert-primary" role="alert">
            <h2>Archivos</h2>
        </div>
        <form method="post" action="{{ url('/materialapoyo') }}"
            style="display: inline">
            @csrf
            <input type="hidden" id="id" name="id" value="{{$material[0]->id_curso}}"> 
            <input type="submit" class="btn btn-success" value="Agregar nuevo">
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
                            <td class="d-flex justify-content-center"> <a class="btn btn-primary" role="button"
                                    href="{{ url('/materialapoyo/' . $mat->id . '/edit') }}"> Editar </a>
                                <p>⠀</p>
                                <form method="post" action="{{ url('/materialapoyo/' . $mat->id) }}"
                                    style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('¿Esta seguro que desea eliminar este archivo?');">Eliminar
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

        <a class="btn btn-primary" href="{{ url('/profesores/' . Auth::user()->cedula . '/cursosasignados') }}"> Volver</a>
    </div>


@endsection
