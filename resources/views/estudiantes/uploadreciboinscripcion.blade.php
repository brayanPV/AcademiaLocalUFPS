@extends('layouts.app')

@section('content')

    <div class="container">
        @if (Session::has('Mensaje'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('Mensaje') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="card col-6">
                <div class="card-header">
                    <h2>Agregar Recibo Inscripcion</h2>
                </div>
                <div class="card-body">
                    <form action="{{ url('/estudiantes/' . $estudiantes->cedula . '/inscripcion') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        @include('estudiantes.formupload', ['Modo'=>'inscripcion'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

