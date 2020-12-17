@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="alert alert-primary" role="alert">
            <h2>Cursos</h2>
        </div>
    </div>
    <div class="container">
       @if(isset($cursos[0]->cedula)) 
        @if(Auth::user()->cedula == $cursos[0]->cedula)
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Certificacion</th>
                    <th>Contenido</th>
                    <th>Material</th>
                    <th>Notas Modulo</th>
                    <th>Notas Laboratorio</th>
                    <th>Certificado</th>
                    <th>Carta</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cursos as $curso)
                    <tr>
                        <td class="col-md-auto">{{ $curso->nombre }}</td>
                        <td class="col-md-auto">{{ $curso->certificacion }}</td>
                        <td class="d-flex"> <a target="_blank" href="{{ $curso->url1 }}" class="btn btn-primary"> <i
                                    class="fas fa-eye"></i>Ver</a>
                            <p>⠀</p><a class="btn btn-secondary" target="_blank" href="{{ $curso->url2 }}"><i
                                    class="fas fa-eye"></i>Ver</a>
                        </td>
                        <td class="col-md-auto">
                            <form method="post" action="{{ url('/materialapoyo/listmaterial') }}" class="form">
                                @csrf
                                <input class="form-control" type="hidden" name="id" id="id" value="{{ $curso->id }}">
                                <div class="input-group" id="submit-group">
                                    <button data-toggle="tooltip" data-placement="bottom" title="Material del curso"
                                        type="submit" class="btn btn-success">
                                        <i class="fas fa-book"></i> Material
                                    </button>
                                </div>
                            </form>
                        </td>
                        <td class="col-md-auto">{{ $curso->valor }}</td>
                        <td class="col-md-auto">{{ $curso->laboratorio }}</td>
                        <td class="col-md-auto">
                            @if ($curso->certificado) <a data-toggle="tooltip"
                                    data-placement="bottom" title="Ver/Descargar"
                                    href="{{ asset('storage') . '/' . $curso->certificado }}" class="btn btn-primary"
                                target="_blank"> <i class="fas fa-file-download"></i></a> @else @endif
                        </td>
                        <td class="col-md-auto">
                            @if ($curso->carta)<a data-toggle="tooltip" data-placement="bottom"
                                    title="Ver/Descargar" href="{{ asset('storage') . '/' . $curso->carta }}"
                                class="btn btn-primary" target="_blank"> <i class="fas fa-file-download"></i></a> @else
                            @endif
                        </td>
                    </tr>
                @empty
                    <h2>No tiene cursos asignados </h2>

                @endforelse
            </tbody>
        </table>
        @endif
    @endif
        <a class="btn btn-primary" href="{{ url('/inicio/' . Auth::user()->id) }}"> Volver</a>
    </div>


@endsection
