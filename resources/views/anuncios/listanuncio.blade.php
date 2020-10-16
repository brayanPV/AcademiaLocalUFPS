@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="alert alert-primary" role="alert">
            <h2>Gestion de anuncios</h2>
          </div>
    <a class="btn btn-success" href="{{ url('/anuncios/create') }}"> Agregar Anuncio</a>

    </div>
        <div class="container">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 20%">Tipo</th>
                        <th style="width: 20%">Nombre</th>
                        <th style="width: 20%">Url</th>
                        <th style="width: 20%">Img</th>
                        <th style="width: 20%">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($anuncios as $anuncio)
                        <tr>
                            <td class="col-md-2"> {{ $anuncio->tipo==0 ? 'Principal' : 'Secundario' }}</td>
                            <td class="col-md-3">{{ $anuncio->nombre }}</td>
                            <td class="col-md-3"><a href="{{ $anuncio->url }}">{{ $anuncio->url }} </a></td>
                            <td class="col-md-2"> <img src="{{ asset('storage') . '/' . $anuncio->img1 }}" alt="" width="250"></td>
                            <td class="col-md-2"> <a class="btn btn-primary" role="button" href="{{ url('/anuncios/' . $anuncio->id . '/edit') }}"> Editar </a>
                                <form method="post" action="{{ url('/anuncios/' . $anuncio->id) }}" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"class="btn btn-danger" onclick="return confirm('¿Esta seguro que desea eliminar el anuncio?    ');">Borrar </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <h2>No hay nada por mostrar </h2>

                    @endforelse
                </tbody>
            </table>
            {{ $anuncios->links("pagination::bootstrap-4") }}
            
         </div>
         
@endsection
