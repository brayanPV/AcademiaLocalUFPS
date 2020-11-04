@extends('layouts.app')

@section('content')
   <div class="row">
    <div class="container">
        @if (Session::has('Mensaje'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('Mensaje') }}
            </div>
        @endif
        <div class="alert alert-primary" role="alert">
            <h2>Gestion de Administradores</h2>
        </div>
        <a class="btn btn-success" href="{{ url('/administradores/create') }}"> Agregar Administrador</a>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Cedula</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Fijo</th>
                    <th>Celular</th>
                    <th>Direccion</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($administradores as $admin)
                    <tr>
                        <td class="col">{{ $admin->cedula }}</td>
                        <td class="col">{{ $admin->nombre }}</td>
                        <td class="col">{{ $admin->correo }}</td>
                        <td class="col">{{ $admin->telfijo }}</td>
                        <td class="col">{{ $admin->telcel }}</td>
                        <td class="col">{{ $admin->direccion }}</td>
                        <td class="d-flex justify-content-center"> <a class="btn btn-primary" role="button"
                                href="{{ url('/administradores/' .$admin->cedula . '/edit') }}"> Editar </a>
                            <form method="post" action="{{ url('/administradores/' . $admin->id) }}" style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('¿Esta seguro que desea eliminar este administrador?');">Borrar
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <h2>No hay nada por mostrar </h2>

                @endforelse
            </tbody>
        </table>
        
    </div>

   </div>
@endsection
