@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="container">
            @if (Session::has('Mensaje'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('Mensaje') }}
                </div>
            @endif
            @if (Auth::check() && Auth::user()->hasrole('administrador'))
                <div class="alert alert-primary" role="alert">
                    <h2><a href="{{ url('/certificaciones/listcertificaciones') }}">Gestion de certificaciones</a></h2>
                </div>

                <div class="row">
                    <div class="col">
                        <a class="btn btn-success" href="{{ url('/certificaciones/create') }}"> <i
                                class="fas fa-plus-circle"></i> Agregar certificacion</a>
                    </div>
                    <br>
                    <div class="col">
                        <input type="text" class="form-control" id="buscar" name="buscar"
                            placeholder="Buscar por nombre o descripcion" aria-label="Recipient's username"
                            aria-describedby="basic-addon2">
                    </div>
                </div>


            @else
                <div class="alert alert-primary" role="alert">
                    <h2>Certificaciones</h2>
                </div>

            @endif
        </div>
        <div class="container">
            <table class="table table-hover">
                <thead>
                    <tr>

                        <th>Nombre</th>
                        <th>Imagen</th>
                        <th>Descripcion</th>
                        @if (Auth::check() && Auth::user()->hasrole('administrador'))
                            <th>Accion</th>
                        @endif
                    </tr>
                </thead>
                <tbody id="dynamic-row">
                    @forelse ($certificaciones as $certificacion)
                        <tr>
                            <td class="col-md-auto">{{ $certificacion->nombre }}</td>
                            <td class="col-md-auto"> <img src="{{ asset('storage') . '/' . $certificacion->imagen }}" alt=""
                                    width="250"></td>
                            <td class="col-md-auto">{{ $certificacion->descripcion }}</td>
                            @if (Auth::check() && Auth::user()->hasrole('administrador'))
                                <td class="d-flex justify-content-center"> <a class="btn btn-primary" role="button"
                                        href="{{ url('/certificaciones/' . $certificacion->id . '/edit') }}"> <i
                                            class="fas fa-edit"></i>Editar </a> <p>⠀</p>
                                    <form method="post" action="{{ url('/certificaciones/' . $certificacion->id) }}"
                                        style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('¿Esta seguro que desea eliminar la certificacion?    ');"><i
                                                class="fas fa-trash"></i>Borrar
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
                <h5 id="total">Total de certificaciones: {{ $certificaciones->total() }} </h5>
                <div class="col-11">
                    {{ $certificaciones->links('pagination::bootstrap-4') }}
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
        var buscarCertificacion = $(this).val();
        $.ajax({
            method: "POST",
            url: "{{ url('certificaciones/buscarCertificacion') }}",
            dateType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                buscarCertificacion: buscarCertificacion,
            },
            success: function(res) {
                $('#dynamic-row').html("");
                var con = 0;
                $.each(JSON.parse(res), function(index, value) {
                    con++;
                    var tableRow = "<tr> <td class='col-md-auto'> " + value.nombre +
                        " </td>"
                    img = value.imagen;
                    tableRow += `<td class="col-md-auto"> <img src="http://127.0.0.1:8080/storage/${img}"
                     width = "250" > </td>`;
                    tableRow += "<td class='col-md-auto'>" + value.descripcion + " </td>";
                    var link = value.id
                    tableRow += `<td class="d-flex"><a href="/certificaciones/${link}/edit " class="btn btn-primary" id="editar" role="button">
                            <i class="fas fa-edit"></i>Editar </a>`
                    tableRow += `<p>⠀</p>
                            <form action="/certificaciones/${link}" method = "post">
                            @csrf
                            @method('DELETE') <button type = "submit" class = "btn btn-danger" onclick =
                            'return confirm("¿Esta seguro que desea eliminar la certificacion?");' >
                            <i class="fas fa-trash"></i>Borrar </button > </form> </td > </tr>`;
                    $('#dynamic-row').append(tableRow);
                });
                var t = document.getElementById('total');
                t.innerHTML = "Total de certificaciones: " + con;
            },
        });
    });

</script>

@endsection
