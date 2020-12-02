@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Session::has('Mensaje'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('Mensaje') }}
            </div>
        @endif
        
        <div class="alert alert-primary" role="alert">
            <h2><a href="{{ url('/cursos/listcursos') }}"> {{ Auth::check() && Auth::user()->hasrole('administrador') ? "Gestion de cursos" : "Cursos"}}</a> </h2>
        </div>
            
        <div class="row">
            <div class="col">
                @if(Auth::check() && Auth::user()->hasrole('administrador'))  <a class="btn btn-success" href="{{ url('/cursos/create') }}"><i class="fas fa-plus-circle"></i> Agregar
                        Curso</a>
                @endif
            </div>
            <br>
            <div class="col">
                    <input type="text" class="form-control" id="buscar" name="buscar"
                        placeholder="Buscar por id, modulo, cohorte o profesor" aria-label="Recipient's username"
                        aria-describedby="basic-addon2">
            </div>  
        </div>
    </div>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id Cisco</th>
                    <th>Modulo</th>
                    <th>Profesor</th>
                    <th>Feha inicio</th>
                    <th>Fecha fin</th>
                    <th>Cohorte</th>
                    @if (Auth::check() && Auth::user()->hasrole('administrador'))
                        <th>Accion</th>
                    @endif
                </tr>
            </thead>
            <tbody id="dynamic-row">
                @forelse ($cursos as $curso)
                    <tr>
                        <td class="col-md-auto">{{ $curso->id_cisco }}</td>
                        <td class="col-md-auto">{{ $curso->nombre_modulo }}</td>
                        <td class="col-md-auto">{{ $curso->nombreper }}</td>
                        <td class="col-md-auto">{{ $curso->fecha_inicio }}</td>
                        <td class="col-md-auto">{{ $curso->fecha_fin }}</td>
                        <td class="col-md-auto">{{ $curso->nombre }}</td>
                        @if (Auth::check() && Auth::user()->hasrole('administrador'))
                            <td class="d-flex justify-content-center"> <a class="btn btn-primary" role="button"
                                    href="{{ url('/cursos/' . $curso->id . '/edit') }}"><i class="fas fa-edit"></i> Editar </a>
                                <p>⠀</p>
                                <form method="post" action="{{ url('/cursos/' . $curso->id) }}" style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('¿Esta seguro que desea eliminar el curso?    ');"><i
                                            class="fas fa-trash"></i> Borrar </button>
                                </form>
                                <p>⠀</p>
                                <a class="btn btn-info p-1" href="{{ url('/profesores/' . $curso->id . '/cursoestudiantes') }}"
                                    style="display: inline"><i class="fas fa-users"></i> Estudiantes </a>
                            </td>
                        @endif
                    </tr>
                @empty
                    <h2>No hay nada por mostrar </h2>

                @endforelse
            </tbody>
        </table>
        <div class="row">
            <h5 id="total">Total de cursos {{ $cursos->total() }} </h5>
            <div class="col-11" id="pagination">

                {{ $cursos->links('pagination::bootstrap-4') }}
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
