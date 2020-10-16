@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Crear Anuncio</h2>

        <form action="{{ url('/anuncios') }}" method="post" enctype="multipart/form-data">
            @csrf
            @include('anuncios.formanuncio', ['Modo'=>'Crear'])
        </form>
    </div>
@endsection
