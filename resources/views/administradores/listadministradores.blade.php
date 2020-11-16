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
            <div class="row">
                <div class="col">
                    <a class="btn btn-success" href="{{ url('/administradores/create') }}"> <i class="fas fa-user-plus"></i>
                        Agregar
                        Administrador</a>
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
                        <th>Correo</th>
                        <th>Fijo</th>
                        <th>Celular</th>
                        <th>Direccion</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody id="dynamic-row">
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
                <h5 id="total">Total de administradores: {{ $administradores->total() }} </h5>
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

@section('scripts')

<script>
    $('body').on('keyup', '#buscar', function() {
        var buscarAdmin = $(this).val();
        console.log(buscarAdmin);
        $.ajax({
            method: "POST",
            url: "{{ url('administradores/buscarAdmin') }}",
            dateType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                buscarAdmin: buscarAdmin,
            },
            success: function(res) {
                $('#dynamic-row').html("");
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
                    var link = value.id;
                    tableRow += `<td class="d-flex"><a href="/administradores/${link}/edit " class="btn btn-primary" id="editar" role="button">
                            <i class="fas fa-user-edit"></i></a>`
                    tableRow += `<p> ⠀ </p>
                            <form action="/administradores/${link}" method = "post">
                            @csrf
                            @method('DELETE') <button type = "submit" class = "btn btn-danger" onclick =
                            'return confirm("¿Esta seguro que desea eliminar este administrador?");' >
                            <i class = "fas fa-user-times"> </i> </button > </form> </td > </tr>`;
                    $('#dynamic-row').append(tableRow);
                });
                var t = document.getElementById('total');
                t.innerHTML = "Total de administradores: " + con;
            },
        });
    });

</script>

@endsection
