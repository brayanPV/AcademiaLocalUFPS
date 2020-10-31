@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="alert alert-primary" role="alert">
            <h2>Cursos de la certificacion {{ $certificacion->nombre }}</h2>
        </div>

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

                    </tr>
                @empty
                    <h2>No hay nada por mostrar </h2>

                @endforelse
            </tbody>
        </table>
        {{ $cursos->links('pagination::bootstrap-4') }}
        <a href="../card" class="btn btn-primary">Volver</a>
    </div>


@endsection
