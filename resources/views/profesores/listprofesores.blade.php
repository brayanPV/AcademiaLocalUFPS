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
                <h2>Gestion de profesores</h2>
            </div>
            <a class="btn btn-success" href="{{ url('/profesores/create') }}"><i class="fas fa-user-plus"></i> Agregar profesor</a>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Cedula</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Telefono fijo</th>
                        <th>Celular</th>
                        <th>Direccion</th>
                        <th>Codigo Profesor</th>
                        <th>ID cisco</th>
                        <th>Estado</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($profesores as $profesor)
                        <tr>
                            <td class="col-md-auto">{{ $profesor->cedula }}</td>
                            <td class="col-md-auto">{{ $profesor->nombre }}</td>
                            <td class="col-md-auto">{{ $profesor->correo }}</td>
                            <td class="col-md-auto">{{ $profesor->telfijo }}</td>
                            <td class="col-md-auto">{{ $profesor->telcel }}</td>
                            <td class="col-md-auto">{{ $profesor->direccion }}</td>
                            <td class="col-md-auto">{{ $profesor->cod_profesor }}</td>
                            <td class="col-md-auto">{{ $profesor->id_cisco }}</td>
                            <td class="col-md-auto">
                                @if ($profesor->estado == 0)
                                    Activo
                                @else
                                    Inactivo
                                @endif
                            </td>
                            <td class="d-flex"> <a class="btn btn-primary" role="button"
                                    href="{{ url('/profesores/' . $profesor->cedula . '/edit') }}"data-toggle="tooltip" title="Editar"> <i class="fas fa-user-edit" ></i>  </a> <p>⠀</p> 
                                <form method="post" action="{{ url('/profesores/' . $profesor->cedula) }}"
                                    style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    @if ($profesor->estado == 0)
                                        <input type="hidden" value="1" id="estado" name="estado">
                                        <button type="submit" class="btn btn-success"
                                            onclick="return confirm('¿Esta seguro que desea desactivar este profesor?');" data-toggle="tooltip" title="Desactivar"><i class="fas fa-toggle-on"></i>   
                                        </button>
                                    @else
                                        <input type="hidden" value="0" id="estado" name="estado">
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('¿Esta seguro que desea activar este profesor?');" data-toggle="tooltip" title="Activar"><i class="fas fa-toggle-off"></i> 
                                        </button>
                                    @endif


                                </form>

                            </td>
                        </tr>
                    @empty
                        <h2>No hay nada por mostrar </h2>

                    @endforelse
                </tbody>
            </table>
            {{ $profesores->links('pagination::bootstrap-4') }}
        </div>

    </div>
@endsection
