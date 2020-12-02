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
            <div class="row">
                <div class="col">
                    <a class="btn btn-success" href="{{ url('/profesores/create') }}"><i class="fas fa-user-plus"></i>
                        Agregar
                        profesor</a>
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="buscar" name="buscar"
                        placeholder="Buscar por nombre, cedula o correo" aria-label="Recipient's username"
                        aria-describedby="basic-addon2">
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Cedula</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Telefono</th>
                            <th>Celular</th>
                            <th>Direccion</th>
                            <th>Codigo</th>
                            <th>ID cisco</th>
                            <th>Estado</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody id="dynamic-row">
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
                                        Inactivo
                                    @else
                                        Activo
                                    @endif
                                </td>
                                <td class="d-flex"> <a class="btn btn-primary" role="button"
                                        href="{{ url('/profesores/' . $profesor->cedula . '/edit') }}" data-toggle="tooltip"
                                        title="Editar"> <i class="fas fa-user-edit"></i> </a>
                                    <p>⠀</p>
                                    <form method="post" action="{{ url('/profesores/' . $profesor->cedula) }}"
                                        style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        @if ($profesor->estado == 0)
                                            <input type="hidden" value="1" id="estado" name="estado">
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('¿Esta seguro que desea activar este profesor?');"
                                                data-toggle="tooltip" title="Activar"><i class="fas fa-toggle-off"></i>
                                            </button>
                                        @else
                                             <input type="hidden" value="0" id="estado" name="estado">
                                            <button type="submit" class="btn btn-success"
                                                onclick="return confirm('¿Esta seguro que desea Desactivar este profesor?');"
                                                data-toggle="tooltip" title="Desactivar"> <i class="fas fa-toggle-on"></i>
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
                <div class="row">
                    <h5 id="total">Total de profesores: {{ $profesores->total() }} </h5>
                    <div class="col-11">
                        {{ $profesores->links('pagination::bootstrap-4') }}
                    </div>
                    <div class="col-1">
                        <a class="btn btn-primary"
                            href="{{ Auth::check() ? url('/inicio/' . Auth::user()->id) : url('/') }}">inicio</a>
                    </div>
                </div>
            </div>

        </div>
    @endsection

@section('scripts')

    <script>
        $('body').on('keyup', '#buscar', function() {
            var buscarProfesor = $(this).val();
            console.log(buscarProfesor);
            $.ajax({
                method: "POST",
                url: "{{ url('profesores/buscarProfesor') }}",
                dateType: "json",
                data: {
                    "_token": "{{ csrf_token() }}",
                    buscarProfesor: buscarProfesor,
                },
                success: function(res) {
                    $('#dynamic-row').html("");
                    console.log(res)
                    var con = 0;
                    $.each(JSON.parse(res), function(index, value) {
                        con++;
                        var tableRow = "<tr> <td class='col-md-auto'> " + value.cedula +
                            " </td>"
                        tableRow += "<td class='col-md-auto'>" + value.nombre + " </td>";
                        tableRow += "<td class='col-md-auto'>" + value.correo + " </td>";
                        tableRow += "<td class='col-md-auto'>" + value.telfijo + " </td>";
                        tableRow += "<td class='col-md-auto'>" + value.telcel + " </td>";
                        tableRow += "<td class='col-md-auto'>" + value.direccion + "</td>";
                        tableRow += "<td class='col-md-auto'>" + value.cod_profesor +
                            "</td>";
                        tableRow += "<td class='col-md-auto'>" + value.id_cisco + "</td>";
                        var link = value.cedula;
                        var estado = value.estado;

                        if (estado == 0) {
                            tableRow += "<td class='col-md-auto'>" + "Inactivo" + " `</td>";
                        } else {
                            tableRow += "<td class='col-md-auto'>" + "Activo" + "</td>";
                        }


                        tableRow += `<td class="d-flex"> <a class="btn btn-primary" role="button"
                        href="/profesores/${link}/edit" data-toggle="tooltip"
                        title="Editar"> <i class="fas fa-user-edit"></i> </a>
                        <p>⠀</p> `
                        tableRow += `<form method="post" action="/profesores/${link}"
                        style="display: inline">
                        @csrf
                        @method('DELETE') ${estado == 0 ? 
                            '<input type="hidden" value="1" id="estado" name="estado"><button type="submit" class="btn btn-danger" onclick="return confirm(\'¿Esta seguro que desea activar este profesor?\');"'+
                            'data-toggle="tooltip" title="Activar"><i class="fas fa-toggle-off"></i> </button>' : '<input type="hidden" value="0" id="estado" name="estado"><button type="submit"'+
                            'class="btn btn-success"onclick="return confirm(\'¿Esta seguro que desea Desactivar este profesor?\');"data-toggle="tooltip" title="Desactivar"> <i class="fas fa-toggle-on">'+
                            '</i></button>'}</form></td> </tr>`;
                        $('#dynamic-row').append(tableRow);
                    });
                    var t = document.getElementById('total');
                    t.innerHTML = "Total de profesores: " + con;
                },
            });
        });

    </script>

@endsection
