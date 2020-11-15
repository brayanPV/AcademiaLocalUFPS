@extends('layouts.app')
@section('content')
    <div class="container">
        @if (Session::has('Mensaje'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('Mensaje') }}
            </div>
        @endif
        <div class="alert alert-primary" role="alert">
            <h2>Gestion de anuncios</h2>
        </div>
        <a class="btn btn-success" href="{{ url('/anuncios/create') }}"><i class="fas fa-plus-circle"></i> Agregar
            Anuncio</a>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Nombre</th>
                    <th>Url</th>
                    <th>Img</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($anuncios as $anuncio)
                    <tr>
                        <td class="col"> {{ $anuncio->tipo == 0 ? 'Principal' : 'Secundario' }}</td>
                        <td class="col">{{ $anuncio->nombre }}</td>
                        <td class="col"><a href="{{ $anuncio->url }}">{{ $anuncio->url }} </a></td>
                        <td class="col"> <img src="{{ asset('storage') . '/' . $anuncio->img1 }}" alt="" width="250"></td>
                        <td class="d-flex justify-content-center"> <a class="btn btn-primary" role="button"
                                href="{{ url('/anuncios/' . $anuncio->id . '/edit') }}"> <i class="fas fa-edit"></i>Editar
                            </a>
                            <p>⠀</p>
                            <form method="post" action="{{ url('/anuncios/' . $anuncio->id) }}" style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('¿Esta seguro que desea eliminar el anuncio?    ');"> <i
                                        class="fas fa-trash"></i>Borrar
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <h2>No hay nada por mostrar </h2>

                @endforelse
            </tbody>
        </table>
        <div class="row">
            <h5>Total de anuncios: {{ $anuncios->total() }} </h5>
            <div class="col-11">
                {{ $anuncios->links('pagination::bootstrap-4') }}
            </div>
            <div class="col-1">
                <a class="btn btn-primary"
                    href="{{ Auth::check() ? url('/inicio/' . Auth::user()->id) : url('/') }}">inicio</a>
            </div>
        </div>

    </div>

@endsection
