<div class="form-group">
    <label for="nombre"> {{ 'Nombre' }}</label>
    <input class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}" type="text" name="nombre" id="nombre"
        value="{{ isset($material->nombre) ? $material->nombre : old('nombre') }}">
    {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="descripcion"> {{ 'Descripcion' }}</label>
    <textarea class="form-control" id="descripcion" name="descripcion" rows="3">
    {{ isset($material->descripcion) ? $material->descripcion : old('descripcion') }}</textarea>
    {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="url"> {{ 'Archivo' }}</label>
    <input class="form-control {{ $errors->has('url') ? 'is-invalid' : '' }}" type="file" name="url" id="url"
        value="{{ isset($material->url) ? $material->url : old('url') }}">
    <input type="hidden" id="id_curso" name="id_curso" value="{{ $curso->id }}">
    {!! $errors->first('url', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="row">
    <div class="col-9">
        <input class="btn btn-primary" type="submit"
            value="{{ $Modo == 'Crear' ? 'Agregar material' : 'Editar material' }}">
    </div>
    <div class="col-3">
        <button class="btn btn-secondary" onclick="goBack()">Volver</button>

        <script>
            function goBack() {
                window.history.back();
            }

        </script>
    </div>
</div>
