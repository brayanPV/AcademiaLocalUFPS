@extends('layouts.app')

@section('content')

    <div class="container">
        @if (Session::has('Mensaje'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('Mensaje') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="card col-6">
                <div class="card-header">
                    <h2>Agregar Certificado Final</h2>
                </div>
                <div class="card-body">
                    <form action="{{ url('/estudiantes/' . $est->id . '/certificado') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" id="id" name="id" value="{{$est->id}}">
                            <label for="tipo_certificacion_id"> {{ 'Certificacion' }}</label>
                            <input class="form-control {{ $errors->has('nombre_cer') ? 'is-invalid' : '' }}" type="text"
                                name="tipo_certificacion_id" id="tipo_certificacion_id"
                                value="{{ isset($est->nombre_cer) ? $est->nombre_cer : old('nombre_cer') }}" readonly>

                        </div>
                        <div class="form-group">
                            <label for="nombre"> {{ 'Nombre' }}</label>
                            <input class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}" type="text"
                                name="nombre" id="nombre"
                                value="{{ isset($est->estudiante) ? $est->estudiante : old('nombre') }}" readonly>

                        </div>
                        <div class="form-group">
                            <label for="recibo_pago_inscripcion"> {{ 'Inscripcion' }}</label>
                            @if ($est->certificado_final_notas != '')
                                <img class="img-thumbnail img-fluid"
                                    src="{{ asset('storage') . '/' . $est->certificado_final_notas }}" width="250">
                            @endif
                            <input class="form-control {{ $errors->has('certificado_final_notas') ? 'is-invalid' : '' }}"
                                type="file" name="certificado_final_notas" id="certificado_final_notas"
                                value="{{ isset($est->certificado_final_notas) ? $est->certificado_final_notas : old('certificado_final_notas') }}">
                            {!! $errors->first('url', '<div class="invalid-feedback">:message</div>') !!} </br>
                            <div class="alert alert-danger">Si no selecciona ningun recibo el actual se va a eliminar, para
                                regresar de
                                click en notas </div>
                        </div>

                        <div class="row">
                            <div class="col-10">
                                <input class="btn btn-primary" type="submit" id="submit" value="Subir">
                            </div>
                            <div class="col-2">
                                @if (!Auth::check()) <a class="btn btn-secondary" inl
                                        href="{{ url('/') }}">Inicio</a>
                                @else <a class="btn btn-secondary" inl
                                        href="{{ url('/estudiantes/' .$est->id. '/vernotascertificacion') }}">Notas</a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
