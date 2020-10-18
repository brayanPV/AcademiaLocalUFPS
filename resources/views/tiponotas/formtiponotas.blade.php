<div class="form-group">
    <label for="nombre"> {{ 'Nombre' }}</label>
    <input class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}" type="text" name="nombre"
        id="nombre" value="{{ isset($tipoNota->nombre) ? $tipoNota->nombre : old('nombre') }}">
    {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="modulo" class="control-label"> {{ 'Modulo ' }}</label>
    <select name="id_tipo_certificacion" id="id_tipo_certificacion" class="form-control {{ $errors->has('id_tipo_certificacion') ? 'is-invalid' : '' }}">
        <option value="">Seleccione</option>
        @foreach ($tipoCertificacion as $tipo)
            <option value="{{ $tipo->id }}">{{ $tipo->nombre }} </>
        @endforeach
        {!! $errors->first('id_tipo_certificacion', '<div class="invalid-feedback">:message</div>') !!}
    </select>
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $Modo == 'Crear' ? 'Agregar tipo de nota' : 'Editar tipo de nota' }}">

</div>
<div class="form-group">
    <a class="btn btn-secondary" href="{{ url('tiponotas/listtiponotas') }}">Listado</a>
</div>
