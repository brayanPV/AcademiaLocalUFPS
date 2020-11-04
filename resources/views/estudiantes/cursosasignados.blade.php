@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="alert alert-primary" role="alert">
            <h2>Cursos</h2>
        </div>


    </div>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Certificacion</th>
                    <th>Enlaces</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cursos as $curso)
                    <tr>
                        <td class="col-md-auto">{{ $curso->nombre }}</td>
                        <td class="col-md-auto">{{ $curso->nombrec }}</td>
                        <td class="col-md-auto"> <a target="_blank" href="{{ $curso->url1 }}"> 1 </a>  <br> <a target="_blank" href="{{ $curso->url2 }}"> 2 </a></td>
                        
                    </tr>
                @empty
                    <h2>No hay nada por mostrar </h2>

                @endforelse
            </tbody>
        </table>

        <a class="btn btn-primary" href="{{ url('/inicio/' . Auth::user()->id) }}"> Volver</a>
    </div>


@endsection
