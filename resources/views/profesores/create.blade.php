@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-6">
                <div class="card-header">
                    <h2>Crear Profesor</h2>
                </div>
                <div class="card-body">
                    <form action="{{ url('/profesores') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @include('profesores.formprofesor', ['Modo'=>'Crear'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection