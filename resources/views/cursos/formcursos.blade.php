<div class="form-group">
    <label for="id_cisco"> {{ 'Id cisco' }}</label>
    <input class="form-control {{ $errors->has('id_cisco') ? 'is-invalid' : '' }}" type="text" name="id_cisco"
        id="id_cisco" value="{{ isset($curso->id_cisco) ? $curso->id_cisco : old('id_cisco') }}"
        placeholder="{{ isset($curso->id_cisco) ? $curso->id_cisco : 'UFPS_CCNA' }}">
    {!! $errors->first('id_cisco', '<div class="invalid-feedback">:message</div>') !!}
</div>
@if ($Modo == 'Crear')
    <div class="form-group">
        <label for="certificaciones" class="control-label"> {{ 'Certificacion ' }}</label>
        <select name="certificaciones" id="certificaciones"
            class="form-control {{ $errors->has('certificaciones') ? 'is-invalid' : '' }}">
            <option value="">Seleccione</option>
            @foreach ($certificaciones as $certificacion)
                <option value="{{ $certificacion->id }}"
                    {{ old('certificaciones') == $certificacion->id ? 'selected' : '' }}>
                    {{ $certificacion->nombre }} </>
            @endforeach
        </select>
        {!! $errors->first('id_tipo_certificacion', '<div class="invalid-feedback">:message</div>') !!}
    </div>
@endif
@if ($Modo == 'Crear')
    <div class="form-group">
        <label for="modulo" class="control-label"> {{ 'Modulo ' }}</label>
        <select data-old="{{ old('id_modulo') }}" name="id_modulo" id="id_modulo"
            class="form-control {{ $errors->has('id_modulo') ? 'is-invalid' : '' }}">
        </select>
        {!! $errors->first('id_modulo', '<div class="invalid-feedback">:message</div>') !!}
    </div>
@else
    <div class="form-group">
        <label for="modulo" class="control-label"> {{ 'Modulo ' }}</label>
        <input class="form-control {{ $errors->has('id_modulo') ? 'is-invalid' : '' }}" type="hidden" name="id_modulo"
            id="id_modulo" value="{{ $curso->id_modulo }}">
        <label for="modulo" class="form-control"> {{ $curso->nombre_modulo }}</label>
@endif
<div class="form-group">
    <label class="control-label" for="id_cohorte"> {{ 'Cohorte' }}</label>
    <select data-old="{{ old('id_cohorte') }}" name="id_cohorte" id="id_cohorte"
        class="form-control {{ $errors->has('id_cohorte') ? 'is-invalid' : '' }}">
        @if ($Modo == 'Editar')
            @foreach ($cohortes as $cohorte)
                <option value="{{ $cohorte->id }}" {{ old('id_cohorte') == $cohorte->id ? 'selected' : '' }}>
                    {{ $cohorte->nombre }} </>
            @endforeach
        @endif
    </select>
    {!! $errors->first('id_cohorte', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label class="control-label" for="ced_profesor"> {{ 'Profesor' }}</label>
    <select name="ced_profesor" id="ced_profesor"
        class="form-control {{ $errors->has('ced_profesor') ? 'is-invalid' : '' }}">
        <option value="{{ isset($curso->cedula) ? $curso->cedula : 0 }}">{{ isset($curso->nombre_profesor) ? $curso->nombre_profesor : 'Seleccione' }}</option>
        @foreach ($profesores as $profesor)
            @if (isset($curso->cedula))
                @if ($curso->cedula != $profesor->cedula)
                    <option value="{{ $profesor->cedula }}">{{ $profesor->nombre }} </>
                @endif
            @else
                <option value="{{ $profesor->cedula }}">{{ $profesor->nombre }} </>
            @endif
        @endforeach
    </select>
    {!! $errors->first('ced_profesor', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label class="control-label" for="fecha_inicio"> Fecha Inicio </label> </br>
    <input class="form-control {{ $errors->has('fecha_inicio') ? 'is-invalid' : '' }}" type="date" name="fecha_inicio"
        id="fecha_inicio" value="{{ isset($curso->fecha_inicio) ? $curso->fecha_inicio : old('fecha_inicio') }}">
    {!! $errors->first('fecha_inicio', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label class="control-label" for="fecha_fin"> Fecha Fin </label> </br>
    <input class="form-control {{ $errors->has('fecha_fin') ? 'is-invalid' : '' }}" type="date" name="fecha_fin"
        id="fecha_fin" value="{{ isset($curso->fecha_fin) ? $curso->fecha_inicio : old('fecha_inicio') }}">
    {!! $errors->first('fecha_fin', '<div class="invalid-feedback">:message</div>') !!}
</div>

<div class="row">
    <div class="col-10">
        <input class="btn btn-primary" type="submit" value="{{ $Modo == 'Crear' ? 'Agregar Curso' : 'Editar Curso' }}">

    </div>
    <div class="col-2">
        <a class="btn btn-secondary" href="{{ url('cursos/listcursos') }}">Volver</a>
    </div>
</div>

@section('scripts')
    <script>
        $(document).ready(function() {
            function cargarCertificacion() {
                var certificacion_id = $('#certificaciones').val();
                if ($.trim(certificacion_id) != '') {
                    $.get('modulos', {
                        certificacion_id: certificacion_id
                    }, function(modulos) {
                        var old = $('#id_modulo').data('old') != '' ? $('#id_modulo').data('old') : '';
                        $('#id_modulo').empty();
                        $('#id_modulo').append("<option value=''>Seleccione un modulo</option>");

                        console.log(_.isEmpty(modulos));
                        $.each(modulos, function(id, nombre) {
                            if (id === null) {
                                console.log("Es nulo");
                                $('#id_modulo').empty();
                                $('#id_modulo').append(
                                    "<option disabled value=''></option>").attr("disabled",
                                    true);
                            } else {
                                $('#id_modulo').append("<option value='" + id + "' " + (old == id ?
                                    'selected' : '') + ">" + nombre + "</option>");
                            }
                        })

                        $.get('cohortes', {
                            certificacion_id: certificacion_id
                        }, function(cohortes) {
                            var old = $('#id_cohorte').data('old') != '' ? $('#id_cohorte').data(
                                'old') : '';
                            $('#id_cohorte').empty();
                            $('#id_cohorte').append(
                                "<option value=''>Seleccione un cohorte</option>");
                            $.each(cohortes, function(id, nombre) {
                                $('#id_cohorte').append("<option value='" + id + "' " + (
                                        old == id ? 'selected' : '') + ">" + nombre +
                                    "</option>");
                            })

                        });
                    });

                }
            }
            cargarCertificacion();
            $('#certificaciones').on('change', cargarCertificacion);
        });

    </script>
@endsection
