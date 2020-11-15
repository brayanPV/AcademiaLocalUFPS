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
            <a class="btn btn-success" href="{{ url('/administradores/create') }}"> <i class="fas fa-user-plus"></i> Agregar
                Administrador</a>

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
                            <td class="col-md-auto">{{ $admin->cedula }}</td>
                            <td class="col-md-auto">{{ $admin->nombre }}</td>
                            <td class="col-md-auto">{{ $admin->correo }}</td>
                            <td class="col-md-auto">{{ $admin->telfijo }}</td>
                            <td class="col-md-auto">{{ $admin->telcel }}</td>
                            <td class="col-md-auto">{{ $admin->direccion }}</td>
                            <td class="d-flex"> <a class="btn btn-primary" role="button"
                                    href="{{ url('/administradores/' . $admin->id . '/edit') }}"> <i
                                        class="fas fa-user-edit"></i> </a>
                                <p>⠀</p>
                                <form method="post" action="{{ url('/administradores/' . $admin->id) }}"
                                    style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('¿Esta seguro que desea eliminar este administrador?');"> <i
                                            class="fas fa-user-times"></i>
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
                <h5>Total de administradores: {{ $administradores->total() }} </h5>
                <div class="col-11">
                    {{ $administradores->links('pagination::bootstrap-4') }}
                </div>
                <div class="col-1">
                    <a class="btn btn-primary"
                        href="{{ Auth::check() ? url('/inicio/' . Auth::user()->id) : url('/') }}">inicio</a>
                </div>
            </div>
        </div>

    </div>
@endsection
