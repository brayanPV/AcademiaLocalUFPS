@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="alert alert-primary" role="alert">
            <h2>Certificaciones</h2>
        </div>


    </div>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Recibo Inscripcion</th>
                    <th>Recibo Matricula</th>
                    <th>Nota Final Modulos</th>
                    <th>Nota Final Laboratorios</th>
                    <th>Nota Certificacion</th>
                    <th>Nota Trabajo Final</th>
                    <th>Definitiva</th>
                    <th>Certificado</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($estudiantes as $est)
                    <tr>
                        <td class="col-md-auto"><a data-toggle="tooltip" data-placement="bottom" title="Cursos" href="{{ url('/estudiantes/' . Auth::user()->cedula . '/cursosasignados') }}">  {{ $est->nombre_cer }} </a></td>
                        <td class="col-md-auto">@if($est->recibo_pago_inscripcion)<a data-toggle="tooltip" data-placement="bottom" title="Ver/Descargar" href="{{ asset('storage') . '/' . $est->recibo_pago_inscripcion }}" class="btn btn-success" target="_blank"> <i class="fas fa-file-download"></i></a> @else  @endif </td>
                        <td class="col-md-auto">@if($est->recibo_pago_matricula)<a data-toggle="tooltip" data-placement="bottom" title="Ver/Descargar" href="{{ asset('storage') . '/' . $est->recibo_pago_matricula }}" class="btn btn-success" target="_blank"> <i class="fas fa-file-download"></i></a> @else  @endif </td>
                        <td class="col-md-auto">{{ $est->nota_final_modulo }}</td>
                        <td class="col-md-auto">{{ $est->nota_final_laboratorio }}</td>
                        <td class="col-md-auto">{{ $est->nota_prueba }}</td>
                        <td class="col-md-auto">{{ $est->nota_sustentacion }}</td>
                        <td class="col-md-auto"> {{($est->definitiva > 0) ?  $est->definitiva  : ''}}</td>
                        <td class="col-md-auto">@if($est->certificado_final_notas)<a data-toggle="tooltip" data-placement="bottom" title="Ver/Descargar" href="{{ asset('storage') . '/' . $est->certificado_final_notas }}" class="btn btn-success" target="_blank"> <i class="fas fa-file-download"></i></a> @else  @endif </td>
                    </tr>
                @empty
                    <h2>No tiene certificaciones asignadas </h2>

                @endforelse
            </tbody>
        </table>

        <a class="btn btn-primary" href="{{ url('/inicio/' . Auth::user()->id) }}"> Volver</a>
    </div>


@endsection
