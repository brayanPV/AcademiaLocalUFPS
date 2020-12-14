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
                <h2><a href="{{ url('inscritos/listinscritos') }}">Gestion de personas inscritas</a></h2>
            </div>

            <div class="row">

                <div class="col">
                    <a class="btn btn-success" href="{{ url('/inscritos/create') }}"><i class="fas fa-user-plus"></i>
                        Agregar estudiante</a>

                </div>
                <br>
                <div class="col">
                    <input type="text" class="form-control" id="buscar" name="buscar"
                        placeholder="Buscar por nombre, cedula, certificacion o correo" aria-label="Recipient's username"
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
                        <th>Recibo de pago</th>
                        <th></th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody id="dynamic-row">
                    @forelse ($inscritos as $inscrito)
                        <tr>
                            <td class="col-md-auto">{{ $inscrito->cedula }}</td>
                            <td class="col-md-auto">{{ $inscrito->nombre }}</td>
                            <td class="col-md-auto">{{ $inscrito->nombre_certificacion }}</td>
                            <td class="col-md-auto">{{ $inscrito->correo }}</td>
                            <td class="col-2"> <a
                                    href="{{ url('/inscritos/' . $inscrito->cedula . '/uploadrecibo') }}">Inscripcion <button
                                        class="btn">
                                        @if ($inscrito->recibo_pago_inscripcion != '')<i
                                            class="fas fa-check-square"></i> @else <i class="far fa-square"></i>
                                    </button> @endif</a> </td>
                            <td><span tabindex="0" data-toggle="tooltip"
                                    title="Telefono: {{ $inscrito->telfijo . PHP_EOL }}Celular: {{ $inscrito->telcel . PHP_EOL }}Direccion:  {{ $inscrito->direccion . PHP_EOL }}Semestre:  {{ $inscrito->semestre . PHP_EOL }} ">
                                    <button class="btn btn-primary" style="pointer-events: none;" type="button"
                                        disabled>Mas</button>
                                </span></td>
                            <td class="d-flex justify-content-center"> <a class="btn btn-primary" data-toggle="tooltip"
                                    title="Editar" role="button"
                                    href="{{ url('/inscritos/' . $inscrito->cedula . '/edit') }}"><i
                                        class="fas fa-user-edit"></i></a>
                                <p>⠀</p>
                                <form method="post" action="{{ url('/inscritos/' . $inscrito->cedula) }}"
                                    style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <button data-toggle="tooltip" title="Eliminar" type="submit" class="btn btn-danger"
                                        onclick="return confirm('¿Esta seguro que desea eliminar esta persona?');"><i
                                            class="fas fa-user-times"></i>
                                    </button>
                                </form>
                                <p>⠀</p>
                                <a data-toggle="tooltip" href="{{ url('/inscritos/' . $inscrito->cedula . '/matricular') }}"
                                    title="Matricular" role="button" class="btn btn-success"><i
                                        class="fas fa-check-square"></i></a>
                            </td>
                        </tr>
                    @empty
                        <h2>No hay nada por mostrar </h2>

                    @endforelse
                </tbody>
            </table>
            <div class="row">
                <h5 id="total">Total de personas inscritas: {{ $inscritos->total() }} </h5>
                <div class="col-11" id="pagination">
                    {{ $inscritos->links('pagination::bootstrap-4') }}
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
        var buscarInscrito = $(this).val();
        console.log(buscarInscrito);
        $.ajax({
            method: "POST",
            url: "{{ url('inscritos/buscarInscrito') }}",
            dateType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                buscarInscrito: buscarInscrito,
            },
            success: function(res) {
                $("#pagination").remove();
                $('#dynamic-row').html("");
                var con = 0;
                $.each(JSON.parse(res), function(index, value) {
                    con++;
                    var tableRow = "<tr> <td class='col-md-auto'> " + value.cedula +
                        " </td>"
                    tableRow += "<td class='col-md-auto'>" + value.nombre + " </td>";
                    tableRow += "<td class='col-md-auto'>" + value.nombre_certificacion +
                        " </td>";
                    tableRow += "<td class='col-md-auto'>" + value.correo + " </td>";
                    tableRow += "<td class='col-md-auto'>" + value.recibo_pago_inscripcion +
                        " </td>";
                    var link = value.cedula;
                    tableRow += `<td><span tabindex="0" data-toggle="tooltip"
                        title="Telefono: ${value.telfijo} \Celular: ${value.telcel} \nDireccion:  ${value.direccion} \nSemestre:  ${value.semestre} ">
                        <button class="btn btn-primary" style="pointer-events: none;" type="button"
                            disabled>Mas</button>
                    </span></td>`;
                    tableRow += `<td class="d-flex"><a href="/inscritos/${link}/edit " class="btn btn-primary" id="editar" role="button">
                            <i class="fas fa-user-edit"></i></a>`
                    tableRow += `<p> ⠀ </p>
                            <form action="/inscritos/${link}" method = "post">
                            @csrf
                            @method('DELETE') <button type = "submit" class = "btn btn-danger" onclick =
                            'return confirm("¿Esta seguro que desea eliminar esta persona?");' >
                            <i class = "fas fa-user-times"> </i> </button > </form>
                            <p>⠀</p>
                            <a data-toggle="tooltip" href="/inscritos/${link}/matricular"
                                title="Matricular" role="button" class="btn btn-success"><i
                                    class="fas fa-check-square"></i></a>`;
                    $('#dynamic-row').append(tableRow);
                });
                var t = document.getElementById('total');
                t.innerHTML = "Total de inscritos: " + con;
            },
        });
    });

</script>
@endsection
