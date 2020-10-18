@extends('layouts.app')

@section('content')

    <div class="container">
        <form action="{{ url('/tiponotas/'.  $tipoNota->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            @include('tiponotas.formtiponotas', ['Modo'=>'Editar'])
        </form>
    </div>

@endsection
