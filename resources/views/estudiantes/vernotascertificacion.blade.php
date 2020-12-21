@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="container">
            @if (Session::has('Mensaje'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('Mensaje') }}
                </div>
            @endif
            <div class="alert alert-primary" role="alert">
                <h2>{{ $est[0]->nombre_cer }}</a></h2>
            </div>
            <h5>{{ $estudiante[0]->nombre }}</h5>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Modulo</th>
                        <th>Profesor</th>
                        <th>Nota modulo</th>
                        <th>Nota laboratorio</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse ($est as $e)
                        <tr>
                            <td class="col-md-auto">{{ $e->modulo }}</td>
                            <td class="col-md-auto">{{ $e->profesor }}</td>
                            <td class="col-md-auto">{{ $e->valor }}</td>
                            <td class="col-md-auto">{{ $e->laboratorio }}</td>
                        </tr>
                    @empty
                        <h2>No hay nada por mostrar </h2>

                    @endforelse
                </tbody>
            </table>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Modulos</th>
                        <th>Laboratorios</th>
                        <th>Certificacion</th>
                        <th>Trabajo Final</th>
                        <th>Definitiva</th>
                        <th>Certificado</th>
                        <th>Terminacion de materias </th>
                        <th class="text-center">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($est_cer as $item)
                        <td class="col-md-auto">{{ $item->nota_final_modulo }}</td>
                        <td class="col-md-auto">{{ $item->nota_final_laboratorio }}</td>
                        <td class="col-md-auto">{{ $item->nota_prueba }}</td>
                        <td class="col-md-auto">{{ $item->nota_sustentacion }}</td>
                        <td class="col-md-auto">{{ $item->definitiva }}</td>
                        <td class="col-md-auto"> <a href="{{ asset('storage') . '/' . $item->certificado_final_notas }}"
                                target="_blank">Certificado <button class="btn">
                                    @if ($item->certificado_final_notas != '')<i
                                        class="fas fa-check-square"></i> @else <i class="far fa-square"></i>
                                </button>
                    @endif</a> </td>
                    <td class="col-md-auto"> <a href="{{ asset('storage') . '/' . $item->terminacion_materias }}"
                        target="_blank">Terminacion de Materias <button class="btn">
                            @if ($item->terminacion_materias != '')<i
                                class="fas fa-check-square"></i> @else <i class="far fa-square"></i>
                        </button>
            @endif</a> </td>
                    <td class="d-flex"><a class="btn btn-primary" data-toggle="tooltip" title="Subir nota prueba"
                            href="{{ url('/estudiantes/' . $est_cer[0]->id . '/subirnotaprueba') }}">
                            <i class="fas fa-plus-square"></i></a>
                        <p>⠀ </p> <a class="btn btn-success" data-toggle="tooltip" title="Subir Certificado Final"
                            href="{{ url('/estudiantes/' . $est_cer[0]->id . '/subircertificadofinal') }}">
                            <i class="fas fa-file-upload"></i></a>
                    <p>⠀ </p> <a class="btn btn-danger" data-toggle="tooltip" title="Ver Informe"
                        href="{{ url('/estudiantes/' . $est_cer[0]->id . '/informe_nota_final') }}">
                        <i class="fas fa-file-pdf"></i></a>
                        <p>⠀ </p> <a class="btn btn-danger" data-toggle="tooltip" title="Enviar Informe"
                        href="{{ url('/estudiantes/' . $est_cer[0]->id . '/pdf') }}">
                        <i class="fas fa-paper-plane"></i></a> </td>
                    @endforeach
                </tbody>
            </table>
            <div class="row">

                <div class="col-1">
                    <a class="btn btn-primary" href="{{ url('/estudiantes/listestudiantes') }}">Volver</a>
                </div>
            </div>
        </div>

    </div>
@endsection
