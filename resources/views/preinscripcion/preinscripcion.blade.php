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
                    <h2>Preinscripcion</h2>
                </div>
                <div class="card-body">
                    <form action="{{ url('/inscritos') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="cedula"> {{ 'Cedula' }}</label>
                            <input class="form-control {{ $errors->has('cedula') ? 'is-invalid' : '' }}" type="number"
                                name="cedula" id="cedula">
                            {!! $errors->first('cedula', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="nombre"> {{ 'Nombre' }}</label>
                            <input class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}" type="text"
                                name="nombre" id="nombre">
                            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="direccion"> {{ 'Direccion' }}</label>
                            <input class="form-control {{ $errors->has('direccion') ? 'is-invalid' : '' }}" type="text"
                                name="direccion" id="direccion">
                            {!! $errors->first('direccion', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="telfijo"> {{ 'Telefono' }}</label>
                            <input class="form-control {{ $errors->has('telfijo') ? 'is-invalid' : '' }}" type="number"
                                name="telfijo" id="telfijo">
                            {!! $errors->first('telfijo', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="telcel"> {{ 'Celular' }}</label>
                            <input class="form-control {{ $errors->has('telcel') ? 'is-invalid' : '' }}" type="number"
                                name="telcel" id="telcel">
                            {!! $errors->first('telcel', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="correo"> {{ 'Correo electronico' }}</label>
                            <input class="form-control {{ $errors->has('correo') ? 'is-invalid' : '' }}" type="email"
                                name="correo" id="correo">
                            {!! $errors->first('correo', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="semestre"> {{ 'Semestre' }}</label>
                            <select name="semestre" id="semestre"
                                class="form-control {{ $errors->has('semestre') ? 'is-invalid' : '' }}">
                                <option value="0">No pertenezco a la UFPS</option>
                                @for ($i = 1; $i < 11; $i++)
                                <option value="{{ $i }}"> {{ $i }}</option>
                                @endfor
                                <option value="11">Ya termine materias</option>
                            </select>
                            <div class="form-group">
                                <label class="control-label" for="certificacion"> {{ 'Certificacion' }}</label>
                                <select name="certificacion" id="certificacion"
                                    class="form-control {{ $errors->has('certificacion') ? 'is-invalid' : '' }}">
                                    <option value="">Seleccione</option>
                                    @foreach ($certificaciones as $certificacion)
                                        <option value="{{ $certificacion->id }}">{{ $certificacion->nombre }} </>
                                    @endforeach
                                    {!! $errors->first('certificacion', '<div class="invalid-feedback">:message</div>') !!}
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-10">
                                    <input class="btn btn-primary" type="submit" value="Preinscribir">
                                </div>
                                <div class="col-2">
                                    <a class="btn btn-secondary" inl href="{{ url('/') }}">Inicio</a>
                                </div>
                            </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
