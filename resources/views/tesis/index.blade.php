@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Session::has('Mensaje'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('Mensaje') }}
            </div>
        @endif
        
        <div class="alert alert-primary" role="alert">
            <h2><a href="{{ url('tesis/')}}">Gestion de Tesis </a></h2>
        </div>
            
        <div class="row">
            <div class="col">
                  <a class="btn btn-success" href="{{ url('/tesis/create') }}"><i class="fas fa-plus-circle"></i> Agregar Tesis</a>
            </div>
            <br>
            <div class="col">
                    <input type="text" class="form-control" id="buscar" name="buscar"
                        placeholder="Buscar por codigo biblioteca, titulo, director o jurado" aria-label="Recipient's username"
                        aria-describedby="basic-addon2">
            </div>  
        </div>
    </div>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Codigo Biblioteca</th>
                    <th>Titulo</th>
                    <th>Tipo</th>
                    <th>Estudiante</th>
                    <th>Linea de investigacion</th>
                    <th>Estado</th>
                    <th>Director</th>
                    <th>Jurado</th>
                    <th>Fecha</th>
                    <th>Accion</th>
                   
                </tr>
            </thead>
            <tbody id="dynamic-row">
                @forelse ($tesis as $tesi)
                    <tr>
                        <td class="col-md-auto">{{ $tesi->cod_biblioteca }}</td>
                        <td class="col-md-auto">{{ $tesi->titulo }}</td>
                        <td class="col-md-auto">{{ $tesi->tipo }}</td>
                        <td class="col-md-auto">{{ $tesi->estudiante }}</td>
                        <td class="col-md-auto">{{ $tesi->linea }}</td>
                        <td class="col-md-auto">{{ $tesi->estado }}</td>
                        <td class="col-md-auto">{{ $tesi->nombre_director }}</td>
                        <td class="col-md-auto">{{ $tesi->nombre_jurado }}</td>
                        <td class="col-md-auto">{{ $tesi->fecha }}</td>
                        <td class="d-flex justify-content-center"> <a class="btn btn-primary" role="button"
                            href="{{ url('/tesis/' . $tesi->id . '/edit') }}"><i class="fas fa-edit"></i></a>
                        <p>⠀</p>
                        <form method="post" action="{{ url('/tesis/' . $tesi->id) }}" style="display: inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('¿Esta seguro que desea eliminar esta tesis?');"><i
                                    class="fas fa-trash"></i></button>
                        </form>
                        <p>⠀</p>
                        <a class="btn btn-info" href="{{ url('/tesis/' . $tesi->id . '/asignarestudiante') }}"
                            style="display: inline"><i class="fas fa-users"></i></a>
                    </td>
                    </tr>
                @empty
                    <h2>No hay nada por mostrar </h2>

                @endforelse
            </tbody>
        </table>
        <div class="row">
            <h5 id="total">Total de cursos {{ $tesis->total() }} </h5>
            <div class="col-11" id="pagination">

                {{ $tesis->links('pagination::bootstrap-4') }}
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
        var buscarCurso = $(this).val();
        var AuthUser = "{{{ (Auth::user()) ? Auth::user() : null }}}";
        //console.log(AuthUser);
        //console.log(buscarCurso);
        $.ajax({
            method: "POST",
            url: "{{ url('cursos/buscarCurso') }}",
            dateType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                buscarCurso: buscarCurso,
            },
            success: function(res) {
                $("#pagination").remove();
                $('#dynamic-row').html("");
                var con = 0;
                $.each(JSON.parse(res), function(index, value) {
                    con++;
                    var tableRow = "<tr><td class='col-md-auto'>" + value.id_cisco +
                        " </td>";
                    tableRow += "<td class='col-md-auto'>" + value.nombre_modulo + " </td>";
                    tableRow += "<td class='col-md-auto'>" + value.nombreper + " </td>";
                    tableRow += "<td class='col-md-auto'>" + value.fecha_inicio + " </td>";
                    tableRow += "<td class='col-md-auto'>" + value.fecha_fin + "</td>";
                    tableRow += "<td class='col-md-auto'>" + value.nombre + " </td>";
                    var link = value.id;
                    if(AuthUser!=""){
                    tableRow += `<td class="d-flex justify-content-center"><a href="/cursos/${link}/edit " class="btn btn-primary" id="editar" role="button">
                            <i class="fas fa-edit"></i> Editar </a>`
                    tableRow += `<p> ⠀ </p>
                            <form action="/cursos/${link}" method = "post">
                            @csrf
                            @method('DELETE') <button type = "submit" class = "btn btn-danger" onclick =
                            'return confirm("¿Esta seguro que desea eliminar este curso?");' >
                            <i class="fas fa-trash"></i> Borrar </button > </form><p>⠀</p>
                            <a class="btn btn-info p-1" href="/profesores/${link}/cursoestudiantes"
                                style="display: inline"><i class="fas fa-users"></i> Estudiantes </a> </td ></tr>`;
                    }
                    else{
                        tableRow +="</tr>";
                    } 
                    $('#dynamic-row').append(tableRow);
                });
                var t = document.getElementById('total');
                t.innerHTML = "Total de cursos: " + con;
            },
        });
    });

</script>
@endsection
