@extends('layouts.app')

@section('content')
    
    <div class="container">
        <div class="alert alert-primary" role="alert">
            <h2>Cursos Asignados</h2>
        </div>


    </div>
    <div class="container">
       
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Modulo</th>
                    <th>Cohorte</th>
                    <th>Profesor</th>
                    <th>Feha inicio</th>
                    <th>Fecha fin</th>
                    <th>Certificacion</th>
                    @if (Auth::check() && Auth::user()->hasrole('profesor'))
                        <th></th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($cursos as $curso)
                    <tr>
                        
                        <td class="col-md-auto">{{ $curso->id_cisco }}</td>
                        <td class="col-md-auto">{{ $curso->nombre_modulo }}</td>
                        <td class="col-md-auto">{{ $curso->nombre }}</td>
                        <td class="col-md-auto">{{ $curso->nombreper }}</td>
                        <td class="col-md-auto">{{ $curso->fecha_inicio }}</td>
                        <td class="col-md-auto">{{ $curso->fecha_fin }}</td>
                        <td class="col-md-auto">{{ $curso->nombre_certificacion }}</td>
                        @if (Auth::check() && Auth::user()->hasrole('profesor'))
                            <td class="d-flex justify-content-center">
                                <form method="post" action="{{ url('/materialapoyo/listmaterial') }}" class="form">
                                    @csrf
                                    <input class="form-control" type="hidden" name="id" id="id" value="{{ $curso->id }}">
                                    <div class="input-group" id="submit-group" >
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-book"></i> Material
                                        </button>
                                    </div>
                                </form>


                                <p> ⠀ </p>

                                <a class="btn btn-info p-1" href="{{ url('/profesores/' . $curso->id . '/cursoestudiantes') }}"
                                    style="display: inline"><i class="fas fa-users"></i> Estudiantes </a>

                            </td>
                        @endif
                    </tr>
                @empty
                    <h2>No hay nada por mostrar </h2>

                @endforelse
            </tbody>
        </table>

        {{ $cursos->links('pagination::bootstrap-4') }}

        <a class="btn btn-primary" href="{{ url('/inicio/' . Auth::user()->id) }}"> Volver</a>
    </div>


@endsection
