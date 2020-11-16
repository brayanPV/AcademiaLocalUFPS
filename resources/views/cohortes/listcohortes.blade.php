@extends('layouts.app')
@section('content')
    <div class="container">
        @if (Session::has('Mensaje'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('Mensaje') }}
            </div>
        @endif
        @if (Auth::check() && Auth::user()->hasrole('administrador'))
            <div class="alert alert-primary" role="alert">
                <h2>Gestion de cohortes</h2>
            </div>
            <div class="row">
                <div class="col">
                    <a class="btn btn-success" href="{{ url('/cohortes/create') }}"><i class="fas fa-plus-circle"></i>
                        Agregar
                        Cohorte</a>
                </div>
                <br>
                <div class="col">
                    <input type="text" class="form-control" id="buscar" name="buscar"
                        placeholder="Buscar por id, nombre o certificacion" aria-label="Recipient's username"
                        aria-describedby="basic-addon2">
                </div>
            </div>

        @else
            <div class="alert alert-primary" role="alert">
                <h2>Cohortes</h2>
            </div>
        @endif
    </div>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id cisco</th>
                    <th>Nombre</th>
                    <th>Fecha inicio</th>
                    <th>Fecha fin</th>
                    <th>Certificacion</th>
                    @if (Auth::check() && Auth::user()->hasrole('administrador'))
                        <th>Accion</th>
                    @endif
                </tr>
            </thead>
            <tbody id="dynamic-row">
                @forelse ($cohortes as $cohorte)
                    <tr>
                        <td class="col-md-auto"> {{ $cohorte->id_cisco }}</td>
                        <td class="col-md-auto">{{ $cohorte->nombre }}</td>
                        <td class="col-md-auto">{{ $cohorte->fecha_inicio }}</td>
                        <td class="col-md-auto">{{ $cohorte->fecha_fin }}</td>
                        <td class="col-md-auto">{{ $cohorte->tc_nombre }}</td>
                        @if (Auth::check() && Auth::user()->hasrole('administrador'))
                            <td class="d-flex justify-content-center"> <a class="btn btn-primary" role="button"
                                    href="{{ url('/cohortes/' . $cohorte->id . '/edit') }}"><i class="fas fa-edit"></i> Editar
                                </a>
                                <p>⠀</p>
                                <form method="post" action="{{ url('/cohortes/' . $cohorte->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('¿Esta seguro que desea eliminar el cohorte?    ');"><i
                                            class="fas fa-trash"></i> Borrar
                                    </button>
                                </form>

                            </td>
                        @endif
                    </tr>
                @empty
                    <h2>No hay nada por mostrar </h2>

                @endforelse
            </tbody>
        </table>

        <div class="row">
            <h5 id="total">Total de cohortes: {{ $cohortes->total() }} </h5>
            <div class="col-11" id="pagination">
                {{ $cohortes->links('pagination::bootstrap-4') }}
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
        var buscarCohorte = $(this).val();
        console.log(buscarCohorte);
        $.ajax({
            method: "POST",
            url: "{{ url('cohortes/buscarCohorte') }}",
            dateType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                buscarCohorte: buscarCohorte,
            },
            success: function(res) {
                $('#dynamic-row').html("");
                var con = 0;
                $("#pagination").remove();
                $.each(JSON.parse(res), function(index, value) {
                    con++;
                    var tableRow = "<tr><td class='col-md-auto'>" + value.id_cisco + " </td>";
                    tableRow += "<td class='col-md-auto'>" + value.nombre + " </td>";
                    tableRow += "<td class='col-md-auto'>" + value.fecha_inicio + " </td>";
                    tableRow += "<td class='col-md-auto'>" + value.fecha_fin + " </td>";
                    tableRow += "<td class='col-md-auto'>" + value.tc_nombre + "</td>";
                    var link = value.id
                    tableRow += `<td class="d-flex"><a href="/cohortes/${link}/edit " class="btn btn-primary" id="editar" role="button">
                            <i class="fas fa-edit"></i></a>`
                    tableRow += `<p> ⠀ </p>
                            <form action="/cohortes/${link}" method = "post">
                            @csrf
                            @method('DELETE') <button type = "submit" class = "btn btn-danger" onclick =
                            'return confirm("¿Esta seguro que desea eliminar el cohorte?");' >
                            <i class="fas fa-trash"> </i> </button > </form> </td > </tr>`;
                    $('#dynamic-row').append(tableRow);
                });
                var t = document.getElementById('total');
                t.innerHTML = "Total de cohortes: " + con;
            },
        });
    });

</script>

@endsection

