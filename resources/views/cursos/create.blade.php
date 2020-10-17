@extends('layouts.app')

@section('content')

    <div class="container">
        <form action="{{ url('/cursos') }}" method="post" enctype="multipart/form-data">
            @csrf
            @include('cursos.formcursos', ['Modo'=>'Crear'])
        </form>
    </div>

@endsection
