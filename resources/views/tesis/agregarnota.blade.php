@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-6">
                <div class="card-header">
                    {{ isset($tesis->nombre) ? $tesis->nombre : '' }}
                </div>
                <div class="card-body">
                    <h5 class="card-title">AGREGAR NOTE TESIS</h5>
                    <form action="{{ url('/tesis/'. $tesis->id .'/agregarnota') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                           <label class="form-control" type="text" name="titulo" id="titulo">{{ $tesis->titulo }}</label>
                           <input type="hidden" name="est_cer" id="est_cer" value="{{$tesis->est_cer}}"> 
                        </div>
                        <div class="form-group">
                           <label class="form-group" type="text">Ingrese la nota de la prueba</label>
                           <input class="form-control {{ $errors->has('nota_sustentacion') ? 'is-invalid' : '' }}" type="number"
                                name="nota_sustentacion" id="nota_sustentacion" max="100"
                                value="{{ isset($tesis->nota_sustentacion) ? $tesis->nota_sustentacion : old('nota_sustentacion') }}">
                            {!! $errors->first('nota_sustentacion', '<div class="invalid-feedback">:message</div>') !!}

                        </div>
                        <div class="row">
                            <div class="col-10">
                                <input class="btn btn-primary" type="submit" value="Actualizar">
                            </div>
                            <div class="col-2">
                                <a class="btn btn-secondary" inl
                                    href="{{ url('tesis/') }}">Volver</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
