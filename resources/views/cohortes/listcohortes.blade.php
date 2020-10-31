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
                <h2>Gestion de cohortes</h2>
            </div>
            <a class="btn btn-success" href="{{ url('/cohortes/create') }}"> Agregar Cohorte</a>
        @else
            <div class="alert alert-primary" role="alert">
                <h2>Cohortes</h2>
            </div>
        @endif
    </div>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id cisco</th>
                    <th>Nombre</th>
                    <th>Fecha inicio</th>
                    <th>Fecha fin</th>
                    <th>Certificacion</th>
                    @if (Auth::check() && Auth::user()->hasrole('administrador'))<th>Accion</th>@endif
                </tr>
            </thead>
            <tbody>
                @forelse ($cohortes as $cohorte)
                    <tr>
                        <td class="col"> {{ $cohorte->id_cisco }}</td>
                        <td class="col">{{ $cohorte->nombre }}</td>
                        <td class="col">{{ $cohorte->fecha_inicio }}</td>
                        <td class="col">{{ $cohorte->fecha_fin }}</td>
                        <td class="col">{{ $cohorte->tc_nombre }}</td>
                        @if (Auth::check() && Auth::user()->hasrole('administrador')) <td class="d-flex justify-content-center"> <a class="btn btn-primary" role="button"
                                href="{{ url('/cohortes/' . $cohorte->id . '/edit') }}"> Editar </a>
                            <form method="post" action="{{ url('/cohortes/' . $cohorte->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('¿Esta seguro que desea eliminar el cohorte?    ');">Borrar
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
        {{ $cohortes->links('pagination::bootstrap-4') }}

    </div>

@endsection
