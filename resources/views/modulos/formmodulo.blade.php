<div class="form-group">
    <label for="numero"> {{ 'Numero' }}</label>
    <input class="form-control {{ $errors->has('numero') ? 'is-invalid' : '' }}" type="number" name="numero" id="numero"
        value="{{ isset($modulos->numero) ? $modulos->numero : old('numero') }}">
    {!! $errors->first('numero', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="nombre"> {{ 'Nombre' }}</label>
    <input class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}" type="text" name="nombre" id="nombre"
        value="{{ isset($modulos->nombre) ? $modulos->nombre : old('nombre') }}">
    {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="director" class="control-label"> {{ 'Certificacion ' }}</label>
    @if ($Modo == 'Crear')
        <select name="id_tipo_certificacion" id="id_tipo_certificacion"
            class="form-control {{ $errors->has('id_tipo_certificacion') ? 'is-invalid' : '' }}">
            <option value="">Seleccione</option>
            @foreach ($tipoCertificacion as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->nombre }} </>
            @endforeach
        </select>
    @else
    <input class="form-control {{ $errors->has('id_tipo_certificacion') ? 'is-invalid' : '' }}" type="hidden"
    name="id_tipo_certificacion" id="id_tipo_certificacion"
    value="{{ isset($modulos->id_tipo_certificacion) ? $modulos->id_tipo_certificacion : old('id_tipo_certificacion') }}">
    <label class="form-control">{{$modulos->tc_nombre}} </label>
    @endif
    {!! $errors->first('id_tipo_certificacion', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="url1"> {{ 'Url 1' }}</label>
    <input class="form-control {{ $errors->has('url1') ? 'is-invalid' : '' }}" type="url" name="url1" id="url1"
        value="{{ isset($modulos->url1) ? $modulos->url1 : old('url1') }}">
    {!! $errors->first('url1', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="url2"> {{ 'Url 2' }}</label>
    <input class="form-control {{ $errors->has('url2') ? 'is-invalid' : '' }}" type="url" name="url2" id="url2"
        value="{{ isset($modulos->url2) ? $modulos->url2 : old('url2') }}">
    {!! $errors->first('url2', '<div class="invalid-feedback">:message</div>') !!}
</div>


<div class="row">
    <div class="col-10">
        <input class="btn btn-primary" type="submit"
            value="{{ $Modo == 'Crear' ? 'Agregar Modulo' : 'Editar Modulo' }}">
    </div>
    <div class="col-2">
        <a class="btn btn-secondary" inl href="{{ url('modulos/listmodulos') }}">Volver</a>
    </div>
</div>
