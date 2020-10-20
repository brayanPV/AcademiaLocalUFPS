@extends('layouts.app')
@section('content')
    <div class="container">
        @if (Session::has('Mensaje'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('Mensaje') }}
        </div>
        @endif
        <div class="alert alert-primary" role="alert">
            <h2>Gestion de cohortes</h2>
        </div>
        <a class="btn btn-success" href="{{ url('/cohortes/create') }}"> Agregar Cohorte</a>

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
                    <th>Accion</th>
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
                        <td class="d-flex justify-content-center"> <a class="btn btn-primary" role="button"
                                href="{{ url('/cohortes/' .$cohorte->id . '/edit') }}"> Editar </a>
                            <form method="post" action="{{ url('/cohortes/' . $cohorte->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('¿Esta seguro que desea eliminar el cohorte?    ');">Borrar
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <h2>No hay nada por mostrar </h2>

                @endforelse
            </tbody>
        </table>
        {{ $cohortes->links('pagination::bootstrap-4') }}

    </div>

@endsection
