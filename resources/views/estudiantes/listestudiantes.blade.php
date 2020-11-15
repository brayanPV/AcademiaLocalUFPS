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
                <h2>Gestion de estudiantes</h2>
            </div>
            <a class="btn btn-success" href="{{ url('/estudiantes/create') }}"><i class="fas fa-user-plus"></i> Agregar estudiante</a>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Cedula</th>
                        <th>Nombre</th>
                        <th>Certificacion</th>
                        <th>Correo</th>
                        <th>Celular</th>
                        <th>Recibos de pago</th>
                        <th></th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($estudiantes as $estudiante)
                        <tr>
                            <td class="col-md-auto">{{ $estudiante->cedula }}</td>
                            <td class="col-md-auto">{{ $estudiante->nombre }}</td>
                            <td class="col-md-auto">{{ $estudiante->nombre_certificacion }}</td>
                            <td class="col-md-auto">{{ $estudiante->correo }}</td>
                            <td class="col-md-auto">{{ $estudiante->telcel }}</td>
                            <td class="col-md-auto">{{ $estudiante->recibo_pago_inscripcion }} <br>    
                                {{ $estudiante->recibo_pago_matricula }} </td>
                            <td><span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Telefono: {{$estudiante->telfijo . PHP_EOL}}Id Cisco:  {{$estudiante->id_cisco . PHP_EOL}}Codigo estudiante:  {{$estudiante->cod_estudiante . PHP_EOL}} ">
                                <button class="btn btn-primary" style="pointer-events: none;" type="button" disabled>Mas</button>
                              </span> </td>    
                            <td class="d-flex justify-content-center"> <a class="btn btn-primary" role="button"
                                    href="{{ url('/estudiantes/' . $estudiante->cedula . '/edit') }}"><i class="fas fa-user-edit"></i>  </a> <p>⠀</p> 
                                <form method="post" action="{{ url('/estudiantes/' . $estudiante->cedula) }}"
                                    style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('¿Esta seguro que desea eliminar este estudiante?');"><i class="fas fa-user-times"></i>
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
                <h5>Total de estudiantes: {{ $estudiantes->total() }} </h5>
                <div class="col-11">
                    {{ $estudiantes->links('pagination::bootstrap-4') }}
                </div>
                <div class="col-1">
                    <a class="btn btn-primary"
                        href="{{ Auth::check() ? url('/inicio/' . Auth::user()->id) : url('/') }}">inicio</a>
                </div>
            </div>
        </div>

    </div>
@endsection
