@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-6">
                <div class="card-header">
                    <h2>Editar Tesis</h2>
                </div>
                <div class="card-body">
                    <form action="{{ url('/tesis/' . $tesis->id) }}" class="form-horizontal" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        @include('tesis.formtesis', ['Modo'=>'Editar'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection