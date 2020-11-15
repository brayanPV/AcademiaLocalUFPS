@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Session::has('Mensaje'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('Mensaje') }}
            </div>
        @endif
        <div class="alert alert-primary" role="alert">
            <h2>Gestion de Modulos</h2>
        </div>
        <a class="btn btn-success" href="{{ url('/modulos/create') }}"><i class="fas fa-plus-circle"></i> Agregar Modulo</a>

    </div>
    <div class="container">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Numero</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Certificacion</th>
                        <th scope="col">Url</th>
                        <th scope="col">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($modulos as $modulo)
                        <tr>
                            <td class="col-md-auto">{{ $modulo->numero }}</td>
                            <td class="col-md-auto">{{ $modulo->nombre }}</td>
                            <td class="col-md-auto">{{ $modulo->nombre_certificacion }}</td>
                            <td class="col-md-auto justify-content-center"> <a href="{{ $modulo->url1 }}" target="_blank"> <i
                                        class="fas fa-external-link-square-alt"></i>{{ $modulo->url1 }} </a> <br> <a
                                    href="{{ $modulo->url2 }}" target="_blank"><i class="fas fa-external-link-square-alt"></i>
                                    {{ $modulo->url2 }} </a></td>
                            <td class="d-flex justify-content-center"> <a class="btn btn-primary" role="button"
                                    href="{{ url('/modulos/' . $modulo->id . '/edit') }}"> <i class="fas fa-edit"></i> Editar
                                </a>
                                <p>⠀</p>
                                <form method="post" action="{{ url('/modulos/' . $modulo->id) }}" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('¿Esta seguro que desea eliminar el modulo?    ');"><i
                                            class="fas fa-trash"></i> Borrar </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <h2>No hay nada por mostrar </h2>

                    @endforelse
                </tbody>
            </table>
            <div class="row">
                <h5>Total de modulos {{ $modulos->total() }} </h5>
                <div class="col-11">

                    {{ $modulos->links('pagination::bootstrap-4') }}
                </div>
                <div class="col-1">
                    <a class="btn btn-primary"
                        href="{{ Auth::check() ? url('/inicio/' . Auth::user()->id) : url('/') }}">inicio</a>
                </div>
            </div>

        </div>



@endsection
