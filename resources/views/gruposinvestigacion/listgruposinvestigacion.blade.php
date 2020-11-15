@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Session::has('Mensaje'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('Mensaje') }}
            </div>
        @endif
        <div class="alert alert-primary" role="alert">
            <h2>Gestion de grupos de investigacion</h2>
        </div>
        <a class="btn btn-success" href="{{ url('/gruposinvestigacion/create') }}"><i class="fas fa-plus-circle"></i> Agregar grupo de investigacion</a>

    </div>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Profesor</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($grupoInvestigacion as $grupo)
                    <tr>
                        <td class="col-md-auto"> {{ $grupo->nombre }}</td>
                        <td class="col-md-auto">{{ $grupo->descripcion }}</td>
                        <td class="col-md-auto">{{ $grupo->nombre_pro }}</td>
                        <td class="d-flex justify-content-center"> <a class="btn btn-primary" role="button"
                                href="{{ url('/gruposinvestigacion/' . $grupo->id . '/edit') }}"><i class="fas fa-edit"></i> Editar </a> <p>⠀</p>
                            <form method="post" action="{{ url('/gruposinvestigacion/' . $grupo->id) }}" style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('¿Esta seguro que desea eliminar este grupo de investigacion?');"><i class="fas fa-trash"></i> Borrar
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <h2>No hay nada por mostrar </h2>

                @endforelse
            </tbody>
        </table>
        <div class="row">
            <h5>Total de grupos de investigacion: {{ $grupoInvestigacion->total() }} </h5>
            <div class="col-11">
                {{ $grupoInvestigacion->links('pagination::bootstrap-4') }}
            </div>
            <div class="col-1">
                <a class="btn btn-primary"
                    href="{{ Auth::check() ? url('/inicio/' . Auth::user()->id) : url('/') }}">inicio</a>
            </div>
        </div>
    </div>


@endsection
