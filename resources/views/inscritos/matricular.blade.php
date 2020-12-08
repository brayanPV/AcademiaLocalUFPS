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
                    <h2>Matricular</h2>
                </div>
                <div class="card-body">
                    <form action="{{ url('/matricularestudiante') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="cedula"> {{ 'Cedula' }}</label>
                            <input class="form-control {{ $errors->has('cedula') ? 'is-invalid' : '' }}" type="number"
                                name="cedula" id="cedula"
                                value="{{ isset($inscritos->cedula) ? $inscritos->cedula : old('cedula') }}" readonly>

                            {!! $errors->first('cedula', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="nombre"> {{ 'Nombre' }}</label>
                            <input class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}" type="text"
                                name="nombre" id="nombre"
                                value="{{ isset($inscritos->nombre) ? $inscritos->nombre : old('nombre') }}">
                            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
                        </div>

                        <div class="form-group">
                            <label for="correo"> {{ 'Recibo pago' }}</label></br>
                            @if ($inscritos->recibo_pago_inscripcion != '')
                            <input type="hidden" name="recibo_pago_inscripcion" id="recibo_pago_inscripcion" value="{{$inscritos->recibo_pago_inscripcion}}">
                                <a class="btn btn-success" aria-disabled=""> <i class="fas fa-check-square"></i> </a>
                            @else <input
                                    class="form-control {{ $errors->has('recibo_pago_inscripcion') ? 'is-invalid' : '' }}"
                                    type="file" name="recibo_pago_inscripcion" id="recibo_pago_inscripcion"
                                    value="{{ isset($inscritos->recibo_pago_inscripcion) ? $inscritos->recibo_pago_inscripcion : old('recibo_pago_inscripcion') }}">
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="cod_estudiante"> {{ 'Codigo Estudiante' }}</label>
                            <input class="form-control {{ $errors->has('cod_estudiante') ? 'is-invalid' : '' }}" type="text"
                                name="cod_estudiante" id="cod_estudiante">
                            {!! $errors->first('cod_estudiante', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="id_cisco"> {{ 'Id cisco' }}</label>
                            <input class="form-control {{ $errors->has('id_cisco') ? 'is-invalid' : '' }}" type="text"
                                name="id_cisco" id="id_cisco">
                            {!! $errors->first('id_cisco', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="Certificacion" class="control-label"> {{ 'Certificacion ' }}</label>

                            <select name="id_tipo_certificacion" id="id_tipo_certificacion"
                                class="form-control {{ $errors->has('id_tipo_certificacion') ? 'is-invalid' : '' }}">
                                <option value="{{ $inscritos->id }}">{{ $inscritos->nombre_certificacion }}</option>
                                @foreach ($certificaciones as $tipo)
                                    @if ($tipo->id != $inscritos->id)
                                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }} </>
                                    @endif
                                @endforeach
                                {!! $errors->first('id_tipo_certificacion', '<div class="invalid-feedback">:message</div>')
                                !!}
                            </select>

                        </div>

                        <div class="row">
                            <div class="col-10">
                                <input class="btn btn-primary" type="submit" value="Matricular">
                            </div>
                            <div class="col-2">
                                <a class="btn btn-secondary" inl href="{{ url('inscritos/listinscritos') }}">Volver</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
