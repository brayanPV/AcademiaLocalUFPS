@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Session::has('Mensaje'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('Mensaje') }}
            </div>
        @endif
        <div class="alert alert-primary" role="alert">
            <h2>{{ $curso[0]->nombre }}</h2>
        </div>
        <div class="row">
        @if (Auth::user()->hasrole('administrador'))
        <div class="col">
            <a role="button" class="btn btn-success p-1"
                href="{{ url('cursos', ['curso' => $curso[0]->id, 'certificacion' => $curso[0]->tipo_certificacion, 'agregarestudiante']) }}">
                <i class="fas fa-user-plus"></i> Agregar Estudiante </a>
        </div>
        @endif
        <div class="col">
            <input type="text" class="form-control" id="buscar" name="buscar"
                placeholder="Buscar por nombre, cedula o estado" aria-label="Recipient's username"
                aria-describedby="basic-addon2">
            <input type="hidden" value="{{$curso[0]->id}}" name="id_curso" id="id_curso">
        </div>
    </div>
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Cedula</th>
                    <th>Nombre</th>
                    <th>Observacion</th>
                    <th>Estado</th>
                    <th>Nota Modulo</th>
                    <th>Nota Laboratorio</th>
                    <th>Certificado</th>
                    <th>Carta</th>
                    @if (Auth::check() && Auth::user()->hasrole('profesor'))
                        <th>Accion</th>
                    @endif
                </tr>
            </thead>
            <tbody id="dynamic-row">
                @forelse ($estudiantes as $estudiante)
                    <tr>
                        <td class="col-md-auto">{{ $estudiante->cedula }}</td>
                        <td class="col-md-auto">{{ $estudiante->nombre }}</td>
                        <td class="col-md-auto">{{ $estudiante->observaciones }}</td>
                        <td class="col-md-auto">{{ $estudiante->estado }}</td>
                        <td class="col-md-auto">{{ $estudiante->valor }}</td>
                        <td class="col-md-auto">{{ $estudiante->laboratorio }}</td>
                        <td class="col-md-auto align-content-center">
                            <a href="{{ $estudiante->certificado }}" target="_blank">Certificado <button class="btn">
                                    @if ($estudiante->certificado != '')<i
                                        class="fas fa-check-square"></i> @else <i class="far fa-square"></i>
                                </button> @endif</a>
                        </td>
                        <td class="col-md-auto align-content-center">
                            <a href="{{ $estudiante->carta }}" target="_blank">Carta <button class="btn">
                                    @if ($estudiante->carta != '')<i
                                        class="fas fa-check-square"></i> @else <i class="far fa-square"></i>
                                </button> @endif</a>
                        </td>
                        <td class="d-flex p-1">
                            @if (Auth::check() && Auth::user()->hasrole('profesor') && Auth::user()->cedula == $curso[0]->ced_profesor)



                                <a class="btn btn-warning" data-toggle="tooltip" data-placement="bottom"
                                    title="Agregar observacion" role="button"
                                    href="{{ url('profesores', ['curso' => $estudiante->id, 'estudiante' => $estudiante->cedula, 'agregarobservacion']) }}"
                                    style="display: inline"><i class="fas fa-comments"></i></a>
                                </br>
                                <p>⠀ </p>
                                <a class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Agregar notas"
                                    role="button"
                                    href="{{ url('profesores', ['curso' => $estudiante->id, 'estudiante' => $estudiante->cedula, 'agregarnota']) }}"><i
                                        class="fas fa-plus-square"></i></a>
                                </br>
                                <p>⠀ </p>
                                <a class="btn btn-primary" data-toggle="tooltip" data-placement="bottom"
                                    title="Agregar Cartificado y Carta"> <i class="fas fa-sticky-note"></i></a>
                                </br>
                                <p>⠀ </p>
                        
                            @endif
                            @if (Auth::user()->hasrole('administrador'))

                            <form method="post" action="{{ url('/profesores/' . $estudiante->id . '/cursoestudiantes') }}"
                                style="display: inline">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" value="{{ $estudiante->cedula }}" id="cedula" name="cedula">
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('¿Esta seguro que desea Eliminar este estudiante del curso?');"
                                    data-toggle="tooltip" title="Eliminar"> <i class="fas fa-user-times"></i>
                                </button>
                            </form>
                            
                            @endif
                        </td>
                    </tr>
                @empty
                    <h2>Este curso no tiene estudiantes </h2>

                @endforelse
            </tbody>

        </table>
        <h5 id="total"> total estudiantes {{ $estudiantes->total() }} </h5>
        <div class="row">
            <div class="col-11">
                {{ $estudiantes->links('pagination::bootstrap-4') }}
            </div>
            <div class="col-1">
                <a class="btn btn-primary" role="button" onclick="goBack()">
                    Volver</a>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    $('body').on('keyup', '#buscar', function() {
        var buscarEstudianteCurso = $(this).val();
        var AuthUser = "{{{ (Auth::user()->hasrole('administrador')) ? 'admin' : 'null' }}}";
        var profesor =  "{{{ (Auth::user()->hasrole('profesor') && Auth::user()->cedula == $curso[0]->ced_profesor)   ? 'profesor' : 'null' }}}";
        var id_curso = document.getElementById('id_curso').value;
        //console.log(buscarEstudianteCurso);
        //console.log(AuthUser);
        //console.log(profesor);
        //console.log(id_curso);

        $.ajax({
            method: "POST",
            url: "{{ url('profesores/buscarEstudianteCurso') }}",
            dateType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                buscarEstudianteCurso: buscarEstudianteCurso,
                id_curso: id_curso,
            },
            success: function(res) {
                $("#pagination").remove();
                $('#dynamic-row').html("");
                //console.log(res);
                var con = 0;
                $.each(JSON.parse(res), function(index, value) {
                    con++;
                    console.log(res);
                    var tableRow = "<tr> <td class='col-md-auto'> " + value.cedula +" </td>";
                    tableRow += `<td class='col-md-auto'> ${value.nombre != null ?  value.nombre : ''}   </td>`;
                    tableRow += `<td class='col-md-auto'> ${value.observaciones != null ?  value.observaciones : ''} </td>`;
                    tableRow += `<td class='col-md-auto'> ${value.estado != null ?  value.estado : ''} </td>`;
                    tableRow += `<td class='col-md-auto'> ${value.valor != null ?  value.valor : ''} </td>`; 
                    tableRow += `<td class='col-md-auto'> ${value.laboratorio != null ?  value.laboratorio : ''} </td>`; 
                    var link = value.cedula;
                    var certificado = value.certificado; 
                    var carta = value.carta; 
                    var curso = value.id; 
                    console.log("Curso " + curso);
                    console.log(link);
                    tableRow += `<td class="col-md-auto align-content-center"><a target="_blank" href="${certificado}">
                        Certificado  ${certificado != null ?  '<i class="fas fa-check-square"></i>' : '<i class="far fa-square"></i>'} 
                        </a> </td>`;
                    tableRow +=  `<td class="col-md-auto align-content-center"><a target="_blank" href="${carta}">
                        Carta  ${carta != null ?  '<i class="fas fa-check-square"></i>' : '<i class="far fa-square"></i>'} 
                        </a> </td>`;
                    tableRow += `<td class="d-flex p-1"> ${profesor == "profesor" ? '<a class="btn btn-warning" data-toggle="tooltip" data-placement="bottom"'+
                        'title="Agregar observacion" role="button" href="/profesores/'+curso +'/'+link +'/agregarobservacion"'+
                        'style="display: inline"><i class="fas fa-comments"></i> </a> </br>'+
                        '<p>⠀ </p><a class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Agregar notas"'+
                            'role="button" href="/profesores/'+curso +'/'+link +'/agregarnota"><i class="fas fa-plus-square"></i></a>'+
                        '</br><p>⠀ </p>'+
                        '<a class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Agregar Cartificado y Carta"> <i class="fas fa-sticky-note"></i></a>'+
                        '</br><p>⠀ </p>' : ''}`;
                    tableRow += `${AuthUser == "admin" ? '<form method="post" action="/profesores/'+curso+'/cursoestudiantes"'+
                        'style="display: inline">'+
                        '@csrf'+
                        '@method('DELETE')'+
                        '<input type="hidden" value="'+link+'" id="cedula" name="cedula">'+
                        '<button type="submit" class="btn btn-danger" onclick="return confirm(\'¿Esta seguro que desea Eliminar este estudiante del curso?\');"'+
                            'data-toggle="tooltip" title="Eliminar"> <i class="fas fa-user-times"></i></button></form>' : ''}`;
                    tableRow += ` </td></tr>`;

                    $('#dynamic-row').append(tableRow);
                });
                var t = document.getElementById('total');
                t.innerHTML = "Total de estudiantes: " + con;
            },
        });
    });

    
</script>
<script>
    function goBack() {
      window.history.back();
    }
    </script>
@endsection