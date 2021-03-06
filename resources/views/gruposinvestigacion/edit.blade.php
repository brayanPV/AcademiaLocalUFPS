@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-6">
                <div class="card-header">
                    <h2>Crear Grupo de investigacion</h2>
                </div>
                <div class="card-body">
                    <form action="{{ url('/gruposinvestigacion/' . $grupoInvestigacion->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        @include('gruposinvestigacion.formgrupoinvestigacion', ['Modo'=>'Editar'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
