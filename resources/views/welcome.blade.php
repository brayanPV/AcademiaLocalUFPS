@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                @include('certificaciones.carouselcertificacion')
                </br>
                @include('anuncios.carouselanuncios')
            </div>
        </div>



    </div>
@endsection
