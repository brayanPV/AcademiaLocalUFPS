@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-6">
                <div class="card-header">
                    {{ $estudiante->modulo }}
                </div>
                <div class="card-body">
                    <h5 class="card-title">AGREGAR NOTA</h5>
                    <form action="{{ url('profesores', ['id_curso' => $estudiante->id_curso, 'cursoestudiantes']) }}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <input type="hidden" value="{{ $estudiante->id_curso }}" name="id_curso" id="id_curso">
                            <label class="form-control" type="text" name="id_cisco"
                                id="id_cisco">{{ $estudiante->id_cisco }}</label>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="cedula" id="cedula" value="{{ $estudiante->ced_estudiante }}">
                            <label class="form-control" type="text" name="nombre" id="nombre"
                                value="{{ isset($estudiante->nombre) ? $estudiante->nombre : old('nombre') }}">{{ $estudiante->nombre }}</label>
                        </div>
                        <div class="form-group">
                            <label for="valor"> {{ 'Nota Modulo' }}</label>
                            <input class="form-control {{ $errors->has('valor') ? 'is-invalid' : '' }}" type="number"
                                name="valor" id="valor" min="0" max="100" step="1"
                                value="{{ isset($estudiante->valor) ? $estudiante->valor : old('valor') }}">
                                {!! $errors->first('valor', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="laboratorio"> {{ 'Nota Laboratorio' }}</label>
                            <input class="form-control {{ $errors->has('laboratorio') ? 'is-invalid' : '' }}"
                                onchange="changeHandler(this)" min="0" max="100" step="1" type="number" name="laboratorio"
                                id="laboratorio"
                                value="{{ isset($estudiante->laboratorio) ? $estudiante->laboratorio : old('laboratorio') }}"> 
                                {!! $errors->first('laboratorio', '<div class="invalid-feedback">:message</div>') !!}
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
