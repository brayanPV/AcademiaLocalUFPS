@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            @foreach ($certificaciones as $certificacion)
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="card-columns-fluid">
                        <div class="card bg-light" style="width: 22rem; ">
                            <img class="card-img-top" src="{{ asset('storage') . '/' . $certificacion->imagen }}" alt=""
                                width="250">
                            <div class="card-body">
                                <h5 class="card-title">{{ $certificacion->nombre }}</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                    of the cards content.</p>
                                <a href="{{ url('/certificaciones/' . $certificacion->id . '/vercurso') }}" class="btn btn-primary">Ver cursos</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection