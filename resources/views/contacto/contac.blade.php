@extends('layouts.app')

@section('content')

    <div class="container">
        @if (Session::has('Mensaje'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('Mensaje') }}
                </div>
            @endif
        <div class="row justify-content-center">
            <div class="card col-6">
                <div class="card-header">
                    <h2>Envia tus comentarios</h2>
                </div>
                <div class="card-body">
                    <form action="{{ url('/contacto') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nombre"> {{ 'Nombres' }}</label>
                            <input class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}" type="text"
                                name="nombre" id="nombre" value="">
                            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="apellido"> {{ 'Apellidos' }}</label>
                            <input class="form-control {{ $errors->has('apellido') ? 'is-invalid' : '' }}" type="text"
                                name="apellido" id="apellido" value="">
                            {!! $errors->first('apellido', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="email"> {{ 'Email' }}</label>
                            <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                                name="email" id="email" value="">
                            {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="comentario"> {{ 'Comentarios' }}</label>
                            <textarea class="form-control" name ="comentario" id="comentario" rows="3"></textarea>
                            {!! $errors->first('comentario', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="row">

                            <div class="col-10" id="fontuser">
                                <input class="btn btn-primary " type="submit" value="Enviar">
                            </div>
                            <div class="col-2">
                                <a class="btn btn-secondary"
                                    href="{{ Auth::check() ? url('/inicio/' . Auth::user()->id) : url('/') }}"> Volver</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
