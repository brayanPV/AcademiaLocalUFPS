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
                <h2><a href="{{ url('/estudiantes/listestudiantes') }}">Gestion de estudiantes </a></h2>
            </div>
            <div class="row">
                <div class="col">
                    <a class="btn btn-success" href="{{ url('/estudiantes/create') }}"><i class="fas fa-user-plus"></i>
                        Agregar estudiante</a>
                </div>
                <br>
                <div class="col">
                    <input type="text" class="form-control" id="buscar" name="buscar"
                        placeholder="Buscar por nombre, cedula o correo" aria-label="Recipient's username"
                        aria-describedby="basic-addon2">
                </div>
            </div>


            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Cedula</th>
                        <th>Nombre</th>
                        <th>Certificacion</th>
                        <th>Correo</th>
                        <th>Celular</th>
                        <th>Recibos de pago</th>
                        <th>Estado</th>
                        <th></th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody id="dynamic-row">
                    @forelse ($estudiantes as $estudiante)
                        <tr>
                            <td class="col-sd-auto">{{ $estudiante->cedula }}</td>
                            <td class="col-sd-auto">{{ $estudiante->nombre }}</td>
                            <td class="col-sd-auto">{{ $estudiante->nombre_certificacion }}</td>
                            <td class="col-sd-auto">{{ $estudiante->correo }}</td>
                            <td class="col-sd-auto">{{ $estudiante->telcel }}</td>
                            <td class="col-3">
                                <div class="row border-0">
                                    <div class="border-0">
                                        <a href="{{ url('/estudiantes/' . $estudiante->cedula . '/uploadreciboinscripcion') }}">
                                            Inscripcion <button class="btn">
                                                @if ($estudiante->recibo_pago_inscripcion != '')<i
                                                    class="fas fa-check-square"></i> @else <i class="far fa-square"></i>
                                            </button>
                                            @endif</a>
                                    </div>
                                    <div class="border-0">
                                        <a href="{{ url('/estudiantes/' . $estudiante->cedula . '/uploadrecibomatricula') }}">
                                            Matricula⠀ <button class="btn">
                                                @if ($estudiante->recibo_pago_matricula != '')
                                                <i class="fas fa-check-square"></i> @else <i class="far fa-square"></i>
                                            </button>
                                            @endif</a>
                                    </div>
                                </div>
                            </td>
                            <td class="col-sd-auto">
                                @if ($estudiante->estado == 0)
                                    Inactivo
                                @else
                                    Activo
                                @endif
                            </td>
                            <td><span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                    title="Telefono: {{ $estudiante->telfijo . PHP_EOL }}Id Cisco:  {{ $estudiante->id_cisco . PHP_EOL }}Codigo estudiante:  {{ $estudiante->cod_estudiante . PHP_EOL }} ">
                                    <button class="btn btn-primary" style="pointer-events: none;" type="button"
                                        disabled>Mas</button>
                                </span> </td>
                            <td class="d-flex justify-content-center"> <a class="btn btn-primary" role="button" data-toggle="tooltip"
                                title="Editar" href="{{ url('/estudiantes/' . $estudiante->cedula . '/edit') }}"><i
                                        class="fas fa-user-edit"></i> </a>
                                <p>⠀</p>
                                <form method="post" action="{{ url('/estudiantes/' . $estudiante->cedula) }}"
                                    style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    @if ($estudiante->estado == 0)
                                        <input type="hidden" value="1" id="estado" name="estado">
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('¿Esta seguro que desea activar este estudiante?');"
                                            data-toggle="tooltip" title="Activar"><i class="fas fa-toggle-off"></i>
                                        </button>
                                    @else
                                        <input type="hidden" value="0" id="estado" name="estado">
                                        <button type="submit" class="btn btn-success"
                                            onclick="return confirm('¿Esta seguro que desea Desactivar este estudiante?');"
                                            data-toggle="tooltip" title="Desactivar"> <i class="fas fa-toggle-on"></i>
                                        </button>
                                    @endif
                                </form>  <p>⠀</p>
                                <a class="btn btn-primary" role="button" data-toggle="tooltip"
                                title="Notas de certificacion" href="{{ url('/estudiantes/' . $estudiante->est_cer_id . '/vernotascertificacion') }}"><i class="fas fa-user-graduate"></i> </a>

                            </td>
                        </tr>
                    @empty
                        <h2>No hay nada por mostrar </h2>

                    @endforelse
                </tbody>
            </table>
            <div class="row">
                <h5 id="total">Total de estudiantes: {{ $estudiantes->total() }} </h5>
                <div class="col-11" id="pagination">
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

@section('scripts')

<script>
    $('body').on('keyup', '#buscar', function() {
        var buscarEstudiante = $(this).val();
        console.log(buscarEstudiante);
        $.ajax({
            method: "POST",
            url: "{{ url('estudiantes/buscarEstudiante') }}",
            dateType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                buscarEstudiante: buscarEstudiante,
            },
            success: function(res) {
                $('#dynamic-row').html("");
                var con = 0;
                $("#pagination").remove();
                $.each(JSON.parse(res), function(index, value) {
                    con++;
                    var link = value.cedula;
                    var inscripcion = value.recibo_pago_inscripcion;
                    var matricula = value.recibo_pago_matricula;
                    //console.log(inscripcion);
                    //console.log(matricula);
                    var tableRow = "<tr> <td class='col-md-auto'> " + value.cedula +
                        " </td>"
                    tableRow += "<td class='col-md-auto'>" + value.nombre + " </td>";
                    tableRow += "<td class='col-md-auto'>" + value.nombre_certificacion +
                        " </td>";
                    tableRow += "<td class='col-md-auto'>" + value.correo + " </td>";
                    tableRow += "<td class='col-md-auto'>" + value.telcel + " </td>";
                    tableRow +=  `<td class="col-3">
                        <div class="row border-0">
                            <div class="border-0">
                                <a href="/estudiantes/${link}/uploadreciboinscripcion">
                                    Inscripcion <button class="btn"> ${inscripcion != null ?  '<i class="fas fa-check-square"></i>' : '<i class="far fa-square"></i>'} 
                                    </button></a>
                            </div>
                            <div class="border-0">
                                <a href="{{ url('/estudiantes/' . $estudiante->cedula . '/uploadrecibomatricula') }}">
                                    Matricula⠀ <button class="btn"> ${matricula != null ? ' <i class="fas fa-check-square"></i>' : '<i class="far fa-square"></i>'}</button>
                                </a>
                            </div>
                        </div>
                    </td>`;
                    var certificacion = value.tipo_certificacion_id;
                    var estudiante_id = value.id;
                    var est_cer_id = value.est_cer_id;
                    var estado = value.estado;

                    if (estado == 0) {
                        tableRow += "<td class='col-md-auto'>" + "Inactivo" + " `</td>";
                    } else {
                        tableRow += "<td class='col-md-auto'>" + "Activo" + "</td>";
                    }

                    tableRow += `<td><span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Telefono: ${value.telfijo} \nId Cisco:  ${value.id_cisco} \nCodigo estudiante:  ${value.cod_estudiante}'>
                        <button class='btn btn-primary' style='pointer-events: none;' type='button' disabled>Mas</button>
                      </span> </td>`;
                    tableRow += `<td class="d-flex"> <a class="btn btn-primary" role="button"
                        href="/estudiantes/${link}/edit" data-toggle="tooltip"
                        title="Editar"> <i class="fas fa-user-edit"></i> </a>
                        <p>⠀</p> `
                    tableRow += `<form method="post" action="/estudiantes/${link}"
                        style="display: inline">
                        @csrf
                        @method('DELETE') ${estado == 0 ? 
                            '<input type="hidden" value="1" id="estado" name="estado"><button type="submit" class="btn btn-danger" onclick="return confirm(\'¿Esta seguro que desea activar este estudiante?\');"'+
                            'data-toggle="tooltip" title="Activar"><i class="fas fa-toggle-off"></i> </button>' : '<input type="hidden" value="0" id="estado" name="estado"><button type="submit"'+
                            'class="btn btn-success"onclick="return confirm(\'¿Esta seguro que desea Desactivar este estudiante?\');"data-toggle="tooltip" title="Desactivar"> <i class="fas fa-toggle-on">'+
                            '</i></button>'}</form> <p>⠀</p><a class="btn btn-primary" role="button" data-toggle="tooltip"'+
                            'title="Subir notas de certificacion" href="/estudiantes/${est_cer_id}/vernotascertificacion"><i class="fas fa-user-graduate"></i></a>
                        </td> </tr>`;
                    $('#dynamic-row').append(tableRow);
                });
                var t = document.getElementById('total');
                t.innerHTML = "Total de estudiantes: " + con;
            },
        });
    });

</script>

@endsection
