@extends('layouts.app')

@section('content')
    
    <div class="container">
        <div class="alert alert-primary" role="alert">
            <h2><a href="{{ url('/profesores/' . Auth::user()->cedula . '/cursosasignados') }}">Cursos Asignados</a></h2>
        </div>

        <div class="col">
            <input type="text" class="form-control" id="buscar" name="buscar"
                placeholder="Buscar por modulo, certificacion o cohorte" aria-label="Recipient's username"
                aria-describedby="basic-addon2">
        </div>
    </div>
    <div class="container">
       
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Modulo</th>
                    <th>Cohorte</th>
                    <th>Profesor</th>
                    <th>Feha inicio</th>
                    <th>Fecha fin</th>
                    <th>Certificacion</th>
                    @if (Auth::check() && Auth::user()->hasrole('profesor'))
                        <th></th>
                    @endif
                </tr>
            </thead>
            <tbody id="dynamic-row">
                @forelse ($cursos as $curso)
                    <tr>
                        
                        <td class="col-md-auto">{{ $curso->id_cisco }}</td>
                        <td class="col-md-auto">{{ $curso->nombre_modulo }}</td>
                        <td class="col-md-auto">{{ $curso->nombre }}</td>
                        <td class="col-md-auto">{{ $curso->nombreper }}</td>
                        <td class="col-md-auto">{{ $curso->fecha_inicio }}</td>
                        <td class="col-md-auto">{{ $curso->fecha_fin }}</td>
                        <td class="col-md-auto">{{ $curso->nombre_certificacion }}</td>
                        @if (Auth::check() && Auth::user()->hasrole('profesor'))
                            <td class="d-flex justify-content-center">
                                <a class="btn btn-success p-1" href="{{ url('/materialapoyo/' . $curso->id . '/listmaterial') }}"
                                    style="display: inline"><i class="fas fa-book"></i> Material </a>

                                <p> ⠀ </p>

                                <a class="btn btn-info p-1" href="{{ url('/profesores/' . $curso->id . '/cursoestudiantes') }}"
                                    style="display: inline"><i class="fas fa-users"></i> Estudiantes </a>

                            </td>
                        @endif
                    </tr>
                @empty
                    <h2>No tiene cursos asignados   </h2>

                @endforelse
            </tbody>
        </table>


        <div class="row">
            <h5 id="total">Total de cursos asignados: {{ $cursos->total() }} </h5>
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
        var buscarCursoAsignado = $(this).val();
        var profesor = "{{{ (Auth::user()->hasrole('profesor')) ? true : false }}}";
        var cedula = "{{{ Auth::user()->cedula }}}";
        //console.log(cedula);
        $.ajax({
            method: "POST",
            url: "{{ url('profesores/buscarCursoAsignado') }}",
            dateType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                buscarCursoAsignado: buscarCursoAsignado,
                cedula: cedula,
            },
            success: function(res) {
                $("#pagination").remove();
                $('#dynamic-row').html("");
                //console.log(res);
                var con = 0;
                $.each(JSON.parse(res), function(index, value) {
                    con++;
                    //console.log(res);
                    var tableRow = "<tr> <td class='col-md-auto'> " + value.id_cisco +" </td>";
                    tableRow += "<td class='col-md-auto'> " + value.nombre_modulo +" </td>";
                    tableRow += "<td class='col-md-auto'> " + value.nombre +" </td>";
                    tableRow += "<td class='col-md-auto'> " + value.nombreper +" </td>";
                    tableRow += "<td class='col-md-auto'> " + value.fecha_inicio +" </td>"; 
                    tableRow += "<td class='col-md-auto'> " + value.fecha_fin +" </td>"; 
                    tableRow += "<td class='col-md-auto'> " + value.nombre_certificacion +" </td>"; 
                

                   
                var id = value.id;
                    if(profesor){
                        tableRow += `<td class="d-flex justify-content-center">
                            <form method="post" action="/materialapoyo/listmaterial" class="form">
                                @csrf
                                <input class="form-control" type="hidden" name="id" id="id" value="${id}">
                                <div class="input-group" id="submit-group" >
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-book"></i> Material
                                    </button>
                                </div>
                            </form> 
                            <p> ⠀ </p>

                            <a class="btn btn-info p-1" href="/profesores/${id}/cursoestudiantes"
                                style="display: inline"><i class="fas fa-users"></i> Estudiantes </a>

                        </td>`
                    }
                    tableRow += `</tr>`
                 $('#dynamic-row').append(tableRow);
                });
                var t = document.getElementById('total');
                t.innerHTML = "Total de estudiantes: " + con;
            },
        });
    });

    
</script>
@endsection