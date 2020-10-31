@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="container">
            @if (Session::has('Mensaje'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('Mensaje') }}
                </div>
            @endif
            @if (Auth::check() && Auth::user()->hasrole('administrador'))
                <div class="alert alert-primary" role="alert">
                    <h2>Gestion de certificaciones</h2>
                </div>
                <a class="btn btn-success" href="{{ url('/certificaciones/create') }}"> Agregar certificacion</a>
            @else
                <div class="alert alert-primary" role="alert">
                    <h2>Certificaciones</h2>
                </div>

            @endif
        </div>
        <div class="container">
            <table class="table table-hover">
                <thead>
                    <tr>

                        <th>Nombre</th>
                        <th>Imagen</th>
                        @if (Auth::check() && Auth::user()->hasrole('administrador'))
                            <th>Accion</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($certificaciones as $certificacion)
                        <tr>
                            <td class="col">{{ $certificacion->nombre }}</td>
                            <td class="col"> <img src="{{ asset('storage') . '/' . $certificacion->imagen }}" alt=""
                                    width="250"></td>
                            @if (Auth::check() && Auth::user()->hasrole('administrador'))
                                <td class="d-flex justify-content-center"> <a class="btn btn-primary" role="button"
                                        href="{{ url('/certificaciones/' . $certificacion->id . '/edit') }}"> Editar </a>
                                    <form method="post" action="{{ url('/certificaciones/' . $certificacion->id) }}"
                                        style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('¿Esta seguro que desea eliminar la certificacion?    ');">Borrar
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
            {{ $certificaciones->links('pagination::bootstrap-4') }}

        </div>
    </div>
@endsection
