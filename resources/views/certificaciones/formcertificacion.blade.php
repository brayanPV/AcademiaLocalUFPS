<div class="form-group">
    <label for="nombre" class="control-label"> {{ 'Nombre' }}</label>
    <input class="form-control {{$errors->has('nombre')? 'is-invalid' : ''}}" type="text" name="nombre" id="nombre"
        value="{{ isset($certificaciones->nombre) ? $certificaciones->nombre :old('nombre') }}">
        {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label class="control-label" for="imagen"> Imagen</label> </br>
    @if (isset($certificaciones->imagen))
        <img class="img-thumbnail img-fluid" src="{{ asset('storage') . '/' . $certificaciones->imagen }}" alt="" width="250">
    @endif
    <input class="form-control {{$errors->has('imagen')? 'is-invalid' : ''}}" type="file" name="imagen" id="imagen" >
    {!! $errors->first('imagen', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="row">
<div class="col">
    <input class="btn btn-primary" type="submit" value="{{ $Modo == 'Crear' ? 'Agregar certificacion' : 'Editar certificacion' }}">

</div>
<div class="col">
    <a class="btn btn-secondary" href="{{ url('certificaciones/listcertificaciones') }}">Lista de Certificaciones</a>
</div>
</div>
