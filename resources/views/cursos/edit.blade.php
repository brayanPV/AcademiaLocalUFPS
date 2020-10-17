@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Curso</h2>
        <form action="{{ url('/cursos/' . $curso->id) }}" class="form-horizontal" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            @include('cursos.formcursos', ['Modo'=>'Editar'])
 </form>
@endsection