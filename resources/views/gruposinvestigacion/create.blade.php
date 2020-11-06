@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-6">
                <div class="card-header">
                    <h2>Crear Grupo de investigacion</h2>
                </div>
                <div class="card-body">
                    <form action="{{ url('/gruposinvestigacion') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @include('gruposinvestigacion.formgrupoinvestigacion', ['Modo'=>'Crear'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
