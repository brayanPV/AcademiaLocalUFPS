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
                <h2><a href="{{ url('preinscripcion/listpreinscripcion')}}">Gestion de personas preinscritos</a></h2>
            </div>

            <div class="row">
                <div class="col">

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
                        <th>Celular</th>
                        <th></th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody id="dynamic-row">
                    @forelse ($preinscritos as $preinscrito)
                        <tr>
                            <td class="col-md-auto">{{ $preinscrito->cedula }}</td>
                            <td class="col-md-auto">{{ $preinscrito->nombre }}</td>
                            <td class="col-md-auto">{{ $preinscrito->nombre_certificacion }}</td>
                            <td class="col-md-auto">{{ $preinscrito->correo }}</td>
                            <td class="col-md-auto">{{ $preinscrito->telcel }}</td>
                            <td><span tabindex="0" data-toggle="tooltip"
                                    title="Telefono: {{ $preinscrito->telfijo . PHP_EOL }}Direccion:  {{ $preinscrito->direccion . PHP_EOL }}Semestre:  {{ $preinscrito->semestre . PHP_EOL }} ">
                                    <button class="btn btn-primary" style="pointer-events: none;" type="button"
                                        disabled>Mas</button>
                                </span></td>
                            <td class="d-flex justify-content-center"> <a class="btn btn-primary" data-toggle="tooltip" title="Editar" role="button"
                                    href="{{ url('/preinscripcion/' . $preinscrito->cedula . '/edit') }}"><i
                                        class="fas fa-user-edit"></i></a>
                                <p>⠀</p>
                                <form method="post" action="{{ url('/preinscripcion/' . $preinscrito->cedula) }}"
                                    style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <button data-toggle="tooltip" title="Eliminar" type="submit" class="btn btn-danger"
                                        onclick="return confirm('¿Esta seguro que desea eliminar esta persona?');"><i
                                            class="fas fa-user-times"></i>
                                    </button>
                                </form>
                                <p>⠀</p>
                                <form method="post" action="{{ url('/preinscripcion/' . $preinscrito->cedula) }}"
                                    style="display: inline">
                                    @csrf
                                    @method('PUT')
                                    <button data-toggle="tooltip" title="Inscribir" type="submit" class="btn btn-success"
                                        onclick="return confirm('¿Esta seguro que desea inscribir esta persona?');"><i class="fas fa-check-square"></i>
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
                <h5 id="total">Total de personas pre inscritas: {{ $preinscritos->total() }} </h5>
                <div class="col-11" id="pagination">
                    {{ $preinscritos->links('pagination::bootstrap-4') }}
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
        var buscarPreinscrito = $(this).val();
        console.log(buscarPreinscrito);
        $.ajax({
            method: "POST",
            url: "{{ url('preinscripcion/buscarPreinscrito') }}",
            dateType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                buscarPreinscrito: buscarPreinscrito,
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
                    tableRow += "<td class='col-md-auto'>" + value.telcel + " </td>";
                    var link = value.cedula;
                    tableRow += `<td><span tabindex="0" data-toggle="tooltip"
                        title="Telefono: ${value.telfijo} \nDireccion:  ${value.direccion} \nSemestre:  ${value.semestre} ">
                        <button class="btn btn-primary" style="pointer-events: none;" type="button"
                            disabled>Mas</button>
                    </span></td>`;
                    tableRow += `<td class="d-flex justify-content-center"><a href="/preinscripcion/${link}/edit " class="btn btn-primary" id="editar" role="button">
                            <i class="fas fa-user-edit"></i></a>`
                    tableRow += `<p> ⠀ </p>
                            <form action="/preinscripcion/${link}" method = "post">
                            @csrf
                            @method('DELETE') <button type = "submit" class = "btn btn-danger" onclick =
                            'return confirm("¿Esta seguro que desea eliminar esta persona?");' >
                            <i class = "fas fa-user-times"> </i> </button > </form>
                            <p>⠀</p>
                            <form method="post" action="/preinscripcion/${link}"
                                style="display: inline">
                                @csrf
                                @method('PUT')
                                <button data-toggle="tooltip" title="Inscribir" type="submit" class="btn btn-success"
                                    onclick="return confirm('¿Esta seguro que desea inscribir esta persona?');"><i class="fas fa-check-square"></i>
                                </button>
                            </form> </td > </tr>`;
                    $('#dynamic-row').append(tableRow);
                });
                var t = document.getElementById('total');
                t.innerHTML = "Total de preinscritos: " + con;
            },
        });
    });

</script>
@endsection
