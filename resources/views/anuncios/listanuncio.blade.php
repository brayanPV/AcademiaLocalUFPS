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
                <h2><a href="{{ url('/anuncios/listanuncio') }}">Gestion de anuncios</a></h2>
            </div>

            <div class="row">
                <div class="col">
                    <a class="btn btn-success" href="{{ url('/anuncios/create') }}"><i class="fas fa-plus-circle"></i>
                        Agregar
                        Anuncio</a>
                </div>
                <br>
                <div class="col">
                    <input type="text" class="form-control" id="buscar" name="buscar" placeholder="Buscar por nombre"
                        aria-label="Recipient's username" aria-describedby="basic-addon2">
                </div>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Nombre</th>
                        <th>Url</th>
                        <th>Img</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody id="dynamic-row">
                    @forelse ($anuncios as $anuncio)
                        <tr>
                            <td class="col-md-auto"> {{ $anuncio->tipo == 0 ? 'Principal' : 'Secundario' }}</td>
                            <td class="col-md-auto">{{ $anuncio->nombre }}</td>
                            <td class="col-md-auto"><a target="_blank" href="{{ $anuncio->url }}">Visitar </a></td>
                            <td class="col-md-auto"> <img src="{{ asset('storage') . '/' . $anuncio->img1 }}" alt=""
                                    width="250"></td>
                            <td class="d-flex justify-content-center"> <a class="btn btn-primary" role="button"
                                    href="{{ url('/anuncios/' . $anuncio->id . '/edit') }}"> <i class="fas fa-edit"></i>Editar
                                </a>
                                <p>⠀</p>
                                <form method="post" action="{{ url('/anuncios/' . $anuncio->id) }}" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('¿Esta seguro que desea eliminar el anuncio?    ');"> <i
                                            class="fas fa-trash"></i>Borrar
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
                <h5 id="total">Total de anuncios: {{ $anuncios->total() }} </h5>
                <div class="col-11" id="pagination">
                    {{ $anuncios->links('pagination::bootstrap-4') }}
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
        var buscarAnuncio = $(this).val();
        $.ajax({
            method: "POST",
            url: "{{ url('anuncios/buscarAnuncio') }}",
            dateType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                buscarAnuncio: buscarAnuncio,
            },
            success: function(res) {
                $('#dynamic-row').html("");
                var con = 0;
                $.each(JSON.parse(res), function(index, value) {
                    con++;
                    var tipo
                    if (value.tipo == 0) {
                        tipo = "Principal"
                    } else {
                        tipo = "Secundario"
                    }
                    var tableRow = `<tr> <td class='col-md-auto'> ${tipo} </td>`
                    tableRow += "<td class='col-md-auto'>" + value.nombre + " </td>";
                    tableRow += "<td class='col-md-auto'> <a target='_blank' href="+value.url+"> visitar</a> </td>";
                    img1 = value.img1;
                    tableRow += `<td class="col-md-auto"> <img src="http://127.0.0.1:8080/storage/${img1}"
                     width = "250" > </td>`;
                    var link = value.id
                    tableRow += `<td class="d-flex"><a href="/anuncios/${link}/edit " class="btn btn-primary" id="editar" role="button">
                            <i class="fas fa-edit"></i>Editar </a>`
                    tableRow += `<p> ⠀ </p>
                            <form action="/anuncios/${link}" method = "post">
                            @csrf
                            @method('DELETE') <button type = "submit" class = "btn btn-danger" onclick =
                            'return confirm("¿Esta seguro que desea eliminar el anuncio?");' >
                            <i class="fas fa-trash"></i>Borrar </button > </form> </td > </tr>`;
                    $('#dynamic-row').append(tableRow);
                });
                var t = document.getElementById('total');
                t.innerHTML = "Total de anuncios: " + con;
            },
        });
    });

</script>
@endsection
