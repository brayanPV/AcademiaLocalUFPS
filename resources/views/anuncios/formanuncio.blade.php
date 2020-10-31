<div class="form-group">
    <label for="tipo"> {{ 'Tipo' }}</label>
    <select name="tipo" id="tipo" class="form-control {{ $errors->has('tipo') ? 'is-invalid' : '' }}">
        <option value="">Seleccione el tipo</option>
        <option value="0"> Primario </option>
        <option value="1"> Secundario </option>
        {!! $errors->first('tipo', '<div class="invalid-feedback">:message</div>') !!}
    </select>
</div>
<div class="form-group">
    <label for="nombre" class="control-label"> {{ 'Nombre' }}</label>
    <input class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}" type="text" name="nombre" id="nombre"
        value="{{ isset($anuncio->nombre) ? $anuncio->nombre : old('nombre') }}">
    {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label class="control-label" for="url"> {{ 'Url' }}</label>
    <input class="form-control {{ $errors->has('url') ? 'is-invalid' : old('url') }}" type="text" name="url" id="url"
        value="{{ isset($anuncio->url) ? $anuncio->url : '' }}">
    {!! $errors->first('url', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label class="control-label" for="img1"> Imagen</label> </br>
    @if (isset($anuncio->img1))
        <img class="img-thumbnail img-fluid" src="{{ asset('storage') . '/' . $anuncio->img1 }}" alt="" width="250">
    @endif
    <input class="form-control {{ $errors->has('img1') ? 'is-invalid' : '' }}" type="file" name="img1" id="img1">
    {!! $errors->first('img1', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="row">
    <div class="col-8">
        <input class="btn btn-primary" type="submit"
            value="{{ $Modo == 'Crear' ? 'Agregar Anuncio' : 'Editar Anuncio' }}">

    </div>
    <div class="col-4">
        <a class="btn btn-secondary text-left" href="{{ url('anuncios/listanuncio') }}">Lista de Anuncios</a>
    </div>
</div>
