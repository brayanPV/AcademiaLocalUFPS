@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Crear Grupo de investigacion</h2>

        <form action="{{ url('/gruposinvestigacion/' .$grupoInvestigacion->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            @include('gruposinvestigacion.formgrupoinvestigacion', ['Modo'=>'Editar'])
        </form>
    </div>
@endsection