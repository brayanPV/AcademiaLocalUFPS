@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-6">
                <div class="card-header">
                    <h2>Crear Linea de Investigacion</h2>
                </div>
                <div class="card-body">
                    <form action="{{ url('/lineas') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @include('lineas.formlinea', ['Modo'=>'Crear'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection