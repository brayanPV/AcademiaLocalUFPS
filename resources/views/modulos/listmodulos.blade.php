@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Session::has('Mensaje'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('Mensaje') }}
            </div>
        @endif
        <div class="alert alert-primary" role="alert">
            <h2>Gestion de Modulos</h2>
        </div>

        <div class="row">
            <div class="col">
                <a class="btn btn-success" href="{{ url('/modulos/create') }}"><i class="fas fa-plus-circle"></i> Agregar
                    Modulo</a>
            </div>
            <br>
            <div class="col">
                <input type="text" class="form-control" id="buscar" name="buscar"
                    placeholder="Buscar por nombre o certificacion" aria-label="Recipient's username"
                    aria-describedby="basic-addon2">
            </div>
        </div>


    </div>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Numero</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Certificacion</th>
                    <th scope="col">Url</th>
                    <th scope="col">Accion</th>
                </tr>
            </thead>
            <tbody id="dynamic-row">
                @forelse ($modulos as $modulo)
                    <tr>
                        <td class="col-md-auto">{{ $modulo->numero }}</td>
                        <td class="col-md-auto">{{ $modulo->nombre }}</td>
                        <td class="col-md-auto">{{ $modulo->nombre_certificacion }}</td>
                        <td class="col-md-auto justify-content-center"> <a href="{{ $modulo->url1 }}" target="_blank"> <i
                                    class="fas fa-external-link-square-alt"></i>{{ $modulo->url1 }} </a> <br> <a
                                href="{{ $modulo->url2 }}" target="_blank"><i class="fas fa-external-link-square-alt"></i>
                                {{ $modulo->url2 }} </a></td>
                        <td class="d-flex justify-content-center"> <a class="btn btn-primary" role="button"
                                href="{{ url('/modulos/' . $modulo->id . '/edit') }}"> <i class="fas fa-edit"></i> Editar
                            </a>
                            <p>⠀</p>
                            <form method="post" action="{{ url('/modulos/' . $modulo->id) }}" style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('¿Esta seguro que desea eliminar el modulo?    ');"><i
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
            <h5 id="total">Total de modulos {{ $modulos->total() }} </h5>
            <div class="col-11" id="pagination">
                {{ $modulos->links('pagination::bootstrap-4') }}
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
        var buscarModulo = $(this).val();
        console.log(buscarModulo);
        $.ajax({
            method: "POST",
            url: "{{ url('modulos/buscarModulo') }}",
            dateType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                buscarModulo: buscarModulo,
            },
            success: function(res) {
                console.log(res);
                $("#pagination").remove();
                $('#dynamic-row').html("");
                var con = 0;
                $.each(JSON.parse(res), function(index, value) {
                    con++;
                    var tableRow = "<tr> <td class='col-md-auto'> " + value.numero +
                        " </td>"
                    tableRow += "<td class='col-md-auto'>" + value.nombre + " </td>";
                    tableRow += "<td class='col-md-auto'>" + value.nombre_certificacion + " </td>";
                    tableRow += `<td class="col-md-auto justify-content-center"> <a href="${value.url1}" target="_blank"> <i
                        class="fas fa-external-link-square-alt"></i>${value.url1} </a> <br> <a
                    href="${value.url2}" target="_blank"><i class="fas fa-external-link-square-alt"></i>
                    ${value.url2}} </a></td>`
                    var link = value.id;
                    tableRow += `<td class="d-flex"><a href="/modulos/${link}/edit " class="btn btn-primary" id="editar" role="button">
                            <i class="fas fa-user-edit"></i></a>`
                    tableRow += `<p> ⠀ </p>
                            <form action="/modulos/${link}" method = "post">
                            @csrf
                            @method('DELETE') <button type = "submit" class = "btn btn-danger" onclick =
                            'return confirm("¿Esta seguro que desea eliminar este grupo?");' >
                            <i class = "fas fa-user-times"> </i> </button > </form> </td > </tr>`;
                    $('#dynamic-row').append(tableRow);
                });
                var t = document.getElementById('total');
                t.innerHTML = "Total modulos: " + con;
            },
        });
    });

</script>
@endsection
