@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-6">
                <div class="card-header">
                    {{ $est_cer->certificacion }}
                </div>
                <div class="card-body">
                    <h5 class="card-title">AGREGAR CERTIFICADO Y CARTA</h5>
                    <form action="{{ url('/estudiantes/'. $est_cer->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                           <label class="form-control" type="text" name="estudiante" id="estudiante">{{ $est_cer->estudiante }}</label>
                        </div>
                        <div class="form-group">
                           <label class="form-group" type="text">Ingrese la nota de la prueba</label>
                           <input class="form-control {{ $errors->has('nota_prueba') ? 'is-invalid' : '' }}" type="number"
                                name="nota_prueba" id="nota_prueba" max="100"
                                value="{{ isset($est_cer->nota_prueba) ? $est_cer->nota_prueba : old('nota_prueba') }}">
                            {!! $errors->first('certificado', '<div class="invalid-feedback">:message</div>') !!}

                        </div>
                        <div class="row">
                            <div class="col-10">
                                <input class="btn btn-primary" type="submit" value="Actualizar">
                            </div>
                            <div class="col-2">
                                <a class="btn btn-secondary" inl
                                    href="{{ url('estudiantes/' . $est_cer->id . '/vernotascertificacion') }}">Volver</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
