@extends('layouts.app')

@section('content')
    <a href="{{ url('anuncios/listanuncio') }}"> LISTA DE ANUNCIIOS </a>
    <div class="container">
        @if (Session::has('Mensaje'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('Mensaje') }}
            </div>

        @endif
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="{{ asset('storage') . '/' . $anuncios[0]->img1 }}" alt="First slide">
                </div>
                @foreach ($anuncios as $anuncio)

                    @if (count($anuncios) > 0 && $anuncio->tipo == 0)
                        <div class="carousel-item">
                            <img class="d-block w-100" src="{{ asset('storage') . '/' . $anuncio->img1 }}"
                                alt="Second slide">
                        </div>
                    @endif
                @endforeach



            </div>
        </div>
    </div>
@endsection
