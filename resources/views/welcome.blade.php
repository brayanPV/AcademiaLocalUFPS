@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="cursos/listcursos">
            <h3> Nuestros cursos </h3>
        </a><br>
        @include('cursos.carouselcursos')
        </br>
        <h3> Anuncios </h3> <br>
        @include('anuncios.carouselanuncios')
    </div>
@endsection

