<div class="form-group">
    <label for="nombre"> {{ 'Nombre' }}</label>
    <input class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}" type="text" name="nombre" id="nombre"
        value="{{ isset($grupoInvestigacion->nombre) ? $grupoInvestigacion->nombre : old('nombre') }}">
    {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="descripcion"> {{ 'Descripcion' }}</label>
    <input class="form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}" type="textarea" name="descripcion" id="descripcion"
        value="{{ isset($grupoInvestigacion->descripcion) ? $grupoInvestigacion->descripcion : old('descripcion') }}"> 
    {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="director" class="control-label"> {{ 'Director ' }}</label>
    <select name="ced_prof_director" id="ced_prof_director"
        class="form-control {{ $errors->has('ced_prof_director') ? 'is-invalid' : '' }}">
        <option value="">Seleccione</option>
        @foreach ($profesores as $profesor)
            <option value="{{ $profesor->cedula }}">{{ $profesor->nombre }} </>
        @endforeach
        {!! $errors->first('ced_prof_director', '<div class="invalid-feedback">:message</div>') !!}
    </select>
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit"
        value="{{ $Modo == 'Crear' ? 'Agregar grupo de investigacion' : 'Editar grupo de investigacion' }}">

</div>
<div class="form-group">
    <a class="btn btn-secondary" href="{{ url('gruposinvestigacion/listgruposinvestigacion') }}">Volver</a>
</div>
