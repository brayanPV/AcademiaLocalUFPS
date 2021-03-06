@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-6">
                <div class="card-header">
                    <h2>Editar Certificacion</h2>
                </div>
                <div class="card-body">
                    <form action="{{ url('/certificaciones/' .$certificaciones->id ) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        @include('certificaciones.formcertificacion', ['Modo'=>'Editar'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection