@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Anuncio</h2>
        <form action="{{ url('/anuncios/' . $anuncio->id) }}" class="form-horizontal" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            @include('anuncios.formanuncio', ['Modo'=>'Editar'])

        </form>
@endsection