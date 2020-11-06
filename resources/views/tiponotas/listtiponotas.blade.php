@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Session::has('Mensaje'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('Mensaje') }}
            </div>
        @endif
        <div class="alert alert-primary" role="alert">
            <h2>Gestion de tipo de notas</h2>
        </div>
        <a class="btn btn-success" href="{{ url('/tiponotas/create') }}"> Agregar Tipo de nota</a>

    </div>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Certificacion</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tipoNotas as $tipo)
                    <tr>
                        <td class="col-md-auto"> {{ $tipo->nombre }}</td>
                        <td class="col-md-auto">{{ $tipo->tc_nombre }}</td>
                        <td class="d-flex justify"> <a class="btn btn-primary" role="button"
                                href="{{ url('/tiponotas/' . $tipo->id . '/edit') }}"> Editar </a>
                            <form method="post" action="{{ url('/tiponotas/' . $tipo->id) }}" style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('¿Esta seguro que desea eliminar este tipo de nota?');">Borrar
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <h2>No hay nada por mostrar </h2>

                @endforelse
            </tbody>
        </table>
        {{ $tipoNotas->links('pagination::bootstrap-4') }}
    </div>


@endsection
