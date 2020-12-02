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
                    <a class="btn btn-success" href="{{ url('/estudiantes/create') }}"><i class="fas fa-user-plus"></i> Agregar estudiante</a>
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
                        <th></th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody id="dynamic-row">
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
                console.log(res);
                $.each(JSON.parse(res), function(index, value) {
                    con++;
                    var tableRow = "<tr> <td class='col-md-auto'> " + value.cedula +
                        " </td>"
                    tableRow += "<td class='col-md-auto'>" + value.nombre + " </td>";
                    tableRow += "<td class='col-md-auto'>" + value.nombre_certificacion + " </td>";
                    tableRow += "<td class='col-md-auto'>" + value.correo + " </td>";
                    tableRow += "<td class='col-md-auto'>" + value.telcel + " </td>";
                    tableRow += "<td class='col-md-auto'>" + value.recibo_pago_inscripcion + " </td>";
                    tableRow += `<td><span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Telefono: ${value.telfijo} \nId Cisco:  ${value.id_cisco} \nCodigo estudiante:  ${value.cod_estudiante}'>
                        <button class='btn btn-primary' style='pointer-events: none;' type='button' disabled>Mas</button>
                      </span> </td>`;
                    var link = value.cedula;
                    tableRow += `<td class="d-flex"><a href="/estudiantes/${link}/edit " class="btn btn-primary" id="editar" role="button">
                            <i class="fas fa-user-edit"></i></a>`
                    tableRow += `<p> ⠀ </p>
                            <form action="/estudiantes/${link}" method = "post">
                            @csrf
                            @method('DELETE') <button type = "submit" class = "btn btn-danger" onclick =
                            'return confirm("¿Esta seguro que desea eliminar este estudiante?");' >
                            <i class = "fas fa-user-times"> </i> </button > </form> </td > </tr>`;
                    $('#dynamic-row').append(tableRow);
                });
                var t = document.getElementById('total');
                t.innerHTML = "Total de estudiantes: " + con;
            },
        });
    });

</script>

@endsection

