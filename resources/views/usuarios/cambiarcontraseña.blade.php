@extends('layouts.app')

@section('content')

    <div class="container">
        @if (Session::has('Error'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('Error') }}
            </div>
        @elseif(Session::has('Success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('Success') }}
        </div>
        @endif
        <div class="row justify-content-center">
            <div class="card col-6">
                <div class="card-header">
                    <h2>Cambiar Contraseña</h2>
                </div>
                <div class="card-body">
                    <form action="{{ url('/usuarios') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="password">{{ __('Contraseña Antigua') }}</label>
                            <input class="form-control" id="password" type="password" name="old_password" id="old_password">
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __('Contraseña') }}</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">{{ __('Confirmar Contraseña') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                required autocomplete="new-password">
                        </div>


                        <div class="row">

                            <div class="col-10" id="fontuser">
                                <input class="btn btn-primary " type="submit" value="Cambiar contraseña">
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
