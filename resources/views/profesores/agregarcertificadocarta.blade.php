@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-6">
                <div class="card-header">
                    {{ $estudiante->modulo }}
                </div>
                <div class="card-body">
                    <h5 class="card-title">AGREGAR CERTIFICADO Y CARTA</h5>
                    <form action="{{ url('profesores',['id_curso'=>$estudiante->id_curso, 'cursoestudiantes']) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" value="{{ $estudiante->id_curso }}" name="id_curso" id="id_curso">
                            <label class="form-control" type="text" name="id_cisco" id="id_cisco">{{ $estudiante->id_cisco }}</label>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="cedula" id="cedula" value="{{ $estudiante->ced_estudiante }}"> 
                            <label class="form-control" type="text" name="nombre" id="nombre"
                                value="{{ isset($estudiante->nombre) ? $estudiante->nombre : old('nombre') }}">{{ $estudiante->nombre }}</label>
                        </div>
                        <div class="form-group">
                            <label for="certificado"> {{ 'Certificado' }}</label>
                            <input class="form-control {{ $errors->has('certificado') ? 'is-invalid' : '' }}" type="file"
                                name="certificado" id="certificado"
                                value="{{ isset($estudiante->certificado) ? $estudiante->certificado : old('certificado') }}">
                            {!! $errors->first('certificado', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="carta"> {{ 'Carta' }}</label>
                            <input class="form-control {{ $errors->has('carta') ? 'is-invalid' : '' }}" type="file"
                                name="carta" id="carta"
                                value="{{ isset($estudiante->carta) ? $estudiante->carta : old('carta') }}">
                            {!! $errors->first('carta', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="row">
                            <div class="col-10">
                                <input class="btn btn-primary" type="submit" value="Actualizar">
                            </div>
                            <div class="col-2">
                                <a class="btn btn-secondary" inl
                                    href="{{ url('profesores/' . $estudiante->id_curso . '/cursoestudiantes') }}">Volver</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
