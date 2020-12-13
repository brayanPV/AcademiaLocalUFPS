@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Session::has('Mensaje'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('Mensaje') }}
            </div>
        @endif

        <div class="alert alert-primary" role="alert">
            <h2><a href="{{ url('/lineas/index') }}"> Gestion de Lineas de Investigacion</a> </h2>
        </div>

        <div class="row">
            <div class="col">
                <a class="btn btn-success" href="{{ url('/lineas/create') }}"><i class="fas fa-plus-circle"></i> Agregar
                    Linea de Investigacion</a>

            </div>
            <br>
            <div class="col">
                <input type="text" class="form-control" id="buscar" name="buscar"
                    placeholder="Buscar por nombre, descripcion o grupo" aria-label="Recipient's username"
                    aria-describedby="basic-addon2">
            </div>
        </div>
    </div>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Grupo Investigacion</th>
                    <th>Profesor</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody id="dynamic-row">
                @forelse ($lineas as $linea)
                    <tr>
                        <td class="col-md-auto">{{ $linea->id }}</td>
                        <td class="col-md-auto">{{ $linea->nombre }}</td>
                        <td class="col-md-auto">{{ $linea->descripcion }}</td>
                        <td class="col-md-auto">{{ $linea->grupo }}</td>
                        <td class="col-md-auto">{{ $linea->profesor }}</td>
                        <td class="d-flex justify-content-center"> <a class="btn btn-primary" role="button"
                                href="{{ url('/lineas/' . $linea->id . '/edit') }}"><i class="fas fa-edit"></i> Editar </a>
                            <p>⠀</p>
                            <form method="post" action="{{ url('/lineas/' . $linea->id) }}" style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('¿Esta seguro que desea eliminar la linea de investigacion?');"><i
                                        class="fas fa-trash"></i> Borrar </button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <h2>No hay nada por mostrar </h2>

                @endforelse
            </tbody>
        </table>
        <div class="row">
            <h5 id="total">Total de lineas de investigacion {{ $lineas->total() }} </h5>
            <div class="col-11" id="pagination">

                {{ $lineas->links('pagination::bootstrap-4') }}
            </div>
            <div class="col-1">
                <a class="btn btn-primary"
                    href="{{ Auth::check() ? url('/inicio/' . Auth::user()->id) : url('/') }}">inicio</a>
            </div>
        </div>
    </div>


@endsection

@section('scripts')

<script>
    $('body').on('keyup', '#buscar', function() {
        var buscarLinea = $(this).val();
        $.ajax({
            method: "POST",
            url: "{{ url('lineas/buscarLinea') }}",
            dateType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                buscarLinea: buscarLinea,
            },
            success: function(res) {
                $("#pagination").remove();
                $('#dynamic-row').html("");
                var con = 0;
                $.each(JSON.parse(res), function(index, value) {
                    con++;
                    var tableRow = "<tr><td class='col-md-auto'>" + value.id +
                        " </td>";
                    tableRow += "<td class='col-md-auto'>" + value.nombre + " </td>";
                    tableRow += "<td class='col-md-auto'>" + value.descripcion + " </td>";
                    tableRow += "<td class='col-md-auto'>" + value.grupo + " </td>";
                    tableRow += "<td class='col-md-auto'>" + value.profesor + "</td>";
                    var link = value.id;

                    tableRow += `<td class="d-flex justify-content-center"><a href="/lineas/${link}/edit " class="btn btn-primary" id="editar" role="button">
                            <i class="fas fa-edit"></i> Editar </a>`
                    tableRow += `<p> ⠀ </p>
                            <form action="/lineas/${link}" method = "post">
                            @csrf
                            @method('DELETE') <button type = "submit" class = "btn btn-danger" onclick =
                            'return confirm("¿Esta seguro que desea eliminar esta linea de investigacion?");' >
                            <i class="fas fa-trash"></i> Borrar </button > </form> </td ></tr>`;

                    $('#dynamic-row').append(tableRow);
                });
                var t = document.getElementById('total');
                t.innerHTML = "Total de lineas de investigacion: " + con;
            },
        });
    });

</script>
@endsection
