@extends('layouts.app')

@section('content')

    <div class="container">
        <form action="{{ url('/tiponotas') }}" method="post" enctype="multipart/form-data">
            @csrf
            @include('tiponotas.formtiponotas', ['Modo'=>'Crear'])
        </form>
    </div>

@endsection
