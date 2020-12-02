@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Session::has('Mensaje'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('Mensaje') }}
            </div>
        @endif
        <div class="alert alert-primary" role="alert">
            <h2>Gestion de grupos de investigacion</h2>
        </div>

        <div class="row">
            <div class="col">
                <a class="btn btn-success" href="{{ url('/gruposinvestigacion/create') }}"><i
                        class="fas fa-plus-circle"></i> Agregar grupo de investigacion</a>
            </div>
            <br>
            <div class="col">
                <input type="text" class="form-control" id="buscar" name="buscar"
                    placeholder="Buscar por nombre, descripcion o profesor" aria-label="Recipient's username"
                    aria-describedby="basic-addon2">
            </div>
        </div>



    </div>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Profesor</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody id="dynamic-row">
                @forelse ($grupoInvestigacion as $grupo)
                    <tr>
                        <td class="col-md-auto"> {{ $grupo->nombre }}</td>
                        <td class="col-md-auto">{{ $grupo->descripcion }}</td>
                        <td class="col-md-auto">{{ $grupo->nombre_pro }}</td>
                        <td class="d-flex justify-content-center"> <a class="btn btn-primary" role="button"
                                href="{{ url('/gruposinvestigacion/' . $grupo->id . '/edit') }}"><i class="fas fa-edit"></i>
                                Editar </a>
                            <p>⠀</p>
                            <form method="post" action="{{ url('/gruposinvestigacion/' . $grupo->id) }}"
                                style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('¿Esta seguro que desea eliminar este grupo de investigacion?');"><i
                                        class="fas fa-trash"></i> Borrar
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
            <h5 id="total">Total de grupos de investigacion: {{ $grupoInvestigacion->total() }} </h5>
            <div class="col-11" id="pagination">
                {{ $grupoInvestigacion->links('pagination::bootstrap-4') }}
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
        var buscarGrupo = $(this).val();
        console.log(buscarGrupo);
        $.ajax({
            method: "POST",
            url: "{{ url('gruposinvestigacion/buscarGrupo') }}",
            dateType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                buscarGrupo: buscarGrupo,
            },
            success: function(res) {
                console.log(res);
                $('#dynamic-row').html("");
                var con = 0;
                $.each(JSON.parse(res), function(index, value) {
                    con++;
                    var tableRow = "<tr> <td class='col-md-auto'> " + value.nombre +
                        " </td>"
                    tableRow += "<td class='col-md-auto'>" + value.descripcion + " </td>";
                    tableRow += "<td class='col-md-auto'>" + value.nombre_pro + " </td>";
                    var link = value.id;
                    tableRow += `<td class="d-flex"><a href="/gruposinvestigacion/${link}/edit " class="btn btn-primary" id="editar" role="button">
                            <i class="fas fa-user-edit"></i></a>`
                    tableRow += `<p> ⠀ </p>
                            <form action="/gruposinvestigacion/${link}" method = "post">
                            @csrf
                            @method('DELETE') <button type = "submit" class = "btn btn-danger" onclick =
                            'return confirm("¿Esta seguro que desea eliminar este grupo?");' >
                            <i class = "fas fa-user-times"> </i> </button > </form> </td > </tr>`;
                    $('#dynamic-row').append(tableRow);
                });
                var t = document.getElementById('total');
                t.innerHTML = "Total grupos de investigacion: " + con;
            },
        });
    });

</script>
@endsection
