@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Crear Grupo de investigacion</h2>

        <form action="{{ url('/gruposinvestigacion') }}" method="post" enctype="multipart/form-data">
            @csrf
            @include('gruposinvestigacion.formgrupoinvestigacion', ['Modo'=>'Crear'])
        </form>
    </div>
@endsection