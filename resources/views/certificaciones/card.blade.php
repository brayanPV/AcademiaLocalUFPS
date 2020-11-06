@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card-group">
            @foreach ($certificaciones as $certificacion)
                <div class="col-xs-12 col-sm-6 col-md-4 py-2">
                    <div class="card-columns-fluid">
                        <div class="card bg-light">
                            <img class="card-img-top" src="{{ asset('storage') . '/' . $certificacion->imagen }}" alt=""
                                height="250">
                            <div class="card-body">
                                <h5 class="card-title text-center">{{ $certificacion->nombre }}</h5>
                                <p class="card-text text-justify">{{ $certificacion->descripcion }}</p>
                                <a href="{{ url('/certificaciones/' . $certificacion->id . '/vercurso') }}"
                                    class="btn btn-primary align-self-end">Ver cursos</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
