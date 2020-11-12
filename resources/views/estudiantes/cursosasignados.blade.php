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
                    <th>Material</th>
                    <th>Notas</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cursos as $curso)
                    <tr>
                        <td class="col-md-auto">{{ $curso->nombre }}</td>
                        <td class="col-md-auto">{{ $curso->nombrec }}</td>
                        <td class="col-md-auto"> <a target="_blank" href="{{ $curso->url1 }}" class="btn btn-primary"> <i class="fas fa-eye"></i>Ver</a> <a  class="btn btn-secondary" target="_blank" href="{{ $curso->url2 }}"><i class="fas fa-eye"></i>Ver</a></td>
                        <td class="col-md-auto">
                            <form method="post" action="{{ url('/materialapoyo/listmaterial') }}" class="form">
                                @csrf
                                <input class="form-control" type="hidden" name="id" id="id" value="{{ $curso->id }}">
                                <div class="input-group" id="submit-group" >
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-book"></i> Material
                                    </button>
                                </div>
                            </form>
                        </td>
                        <td> </td>
                    </tr>
                @empty
                    <h2>No hay nada por mostrar </h2>

                @endforelse
            </tbody>
        </table>

        <a class="btn btn-primary" href="{{ url('/inicio/' . Auth::user()->id) }}"> Volver</a>
    </div>


@endsection
