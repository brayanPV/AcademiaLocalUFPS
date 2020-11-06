<div class="form-group">
    <label for="id_cisco"> {{ 'Id cisco' }}</label>
    <input class="form-control {{ $errors->has('id_cisco') ? 'is-invalid' : '' }}" type="text" name="id_cisco"
        id="id_cisco" value="{{ isset($curso->id_cisco) ? $curso->id_cisco : old('id_cisco') }}" placeholder="{{ isset($curso->id_cisco) ? $curso->id_cisco : 'UFPS_CCNA' }}">
    {!! $errors->first('id_cisco', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="modulo" class="control-label"> {{ 'Modulo ' }}</label>
    <select name="id_modulo" id="id_modulo" class="form-control {{ $errors->has('id_modulo') ? 'is-invalid' : '' }}">
        <option value="">Seleccione</option>
        @foreach ($modulos as $modulo)
            <option value="{{ $modulo->id }}">{{ $modulo->nombre }} </>
        @endforeach
    </select>
    {!! $errors->first('id_modulo', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label class="control-label" for="ced_profesor"> {{ 'Profesor' }}</label>
    <select name="ced_profesor" id="ced_profesor" class="form-control {{ $errors->has('ced_profesor') ? 'is-invalid' : '' }}">
        <option value="">Seleccione</option>
        @foreach ($profesores as $profesor)
            <option value="{{ $profesor->cedula }}">{{ $profesor->nombre }} </>
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
<div class="form-group">
    <label class="control-label" for="id_cohorte"> {{ 'Cohorte' }}</label>
    <select name="id_cohorte" id="id_cohorte" class="form-control {{ $errors->has('id_cohorte') ? 'is-invalid' : '' }}">
        <option value="">Seleccione</option>
        @foreach ($cohortes as $cohorte)
            <option value="{{ $cohorte->id }}">{{ $cohorte->nombre }} </>
        @endforeach
    </select>
    {!! $errors->first('id_cohorte', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="row">
<div class="col-10">
    <input class="btn btn-primary" type="submit" value="{{ $Modo == 'Crear' ? 'Agregar Curso' : 'Editar Curso' }}">

</div>
<div class="col-2">
    <a class="btn btn-secondary" href="{{ url('cursos/listcursos') }}">Volver</a>
</div>
</div>
