@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-6">
                <div class="card-header">
                    <h2>Editar Tesis</h2>
                </div>
                <div class="card-body">
                    <form action="{{ url('/tesis/' . $tesis->id) }}" class="form-horizontal" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="cod_biblioteca"> {{ 'Codigo Biblioteca' }}</label>
                            <input class="form-control {{ $errors->has('cod_biblioteca') ? 'is-invalid' : '' }}" type="text"
                                name="cod_biblioteca" id="cod_biblioteca" max="10"
                                value="{{ isset($tesis->cod_biblioteca) ? $tesis->cod_biblioteca : old('cod_biblioteca') }}" readonly>
                            {!! $errors->first('cod_biblioteca', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="titulo"> {{ 'Titulo' }}</label>
                            <input class="form-control {{ $errors->has('titulo') ? 'is-invalid' : '' }}" type="text" name="titulo" id="titulo"
                                value="{{ isset($tesis->titulo) ? $tesis->titulo : old('titulo') }}" readonly>
                            {!! $errors->first('titulo', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label for="titulo"> {{ 'Buscar estudiante' }}</label>
                            <input type="text" class="form-control" id="buscar" name="buscar"
                        placeholder="Buscar por nombre o cedula" aria-label="Recipient's username"
                        aria-describedby="basic-addon2">
                     </div>
                     <div class="form-group">
                        <label for="estudiante_tipo_certificacion"> {{ 'Seleccione estudiante' }}</label>
                        <select name="estudiante_tipo_certificacion" id="estudiante_tipo_certificacion"
                        class="form-control {{ $errors->has('estudiante_tipo_certificacion') ? 'is-invalid' : '' }}">
                        <option value="0"> Por favor utilice el buscador</option>
                    </select>
                    {!! $errors->first('estudiante_tipo_certificacion', '<div class="invalid-feedback">:message</div>') !!}
                 </div>
                 <div class="row">
                    <div class="col-10">
                        <input class="btn btn-primary" type="submit" value="Asignar">
                
                    </div>
                    <div class="col-2">
                        <a class="btn btn-secondary" href="{{ url('tesis/') }}">Volver</a>
                    </div>
                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
 <script> 

    $('body').on('keyup', '#buscar', function() {
        var buscarEstudiante = $(this).val();
        console.log(buscarEstudiante);
        $.ajax({
            method: "POST",
            url: "{{ url('estudiantes/buscarEstudiante') }}",
            dateType: "json",
            data: {
                "_token": "{{ csrf_token() }}",
                buscarEstudiante: buscarEstudiante,
            },
            success: function(res) {
                $("#estudiante_tipo_certificacion").empty();
                var con = 0;
                $.each(JSON.parse(res), function(index, value) {
                    if(value.cod_estudiante != null){
                        $('#estudiante_tipo_certificacion').append("<option value='" + value.est_cer_id + "'>" + value.nombre + "--" + value.nombre_certificacion +
                                    "</option>");
                        //console.log(value.nombre + " --- " + value.nombre_certificacion);
                    }
                });
               
            },
        });
     });


   
 </script>   
@endsection