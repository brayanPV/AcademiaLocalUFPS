<div class="form-group">
    <label for="cedula"> {{ 'Cedula' }}</label>
    <input class="form-control {{ $errors->has('cedula') ? 'is-invalid' : '' }}" type="number" name="cedula" id="cedula"
        value="{{ isset($estudiantes->cedula) ? $estudiantes->cedula : old('cedula') }}" {{ $Modo == 'Crear' ?: 'readonly' }}>
    
    {!! $errors->first('cedula', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="nombre"> {{ 'Nombre' }}</label>
    <input class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}" type="text" name="nombre" id="nombre"
        value="{{ isset($personas->nombre) ? $personas->nombre : old('nombre') }}">
    {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="direccion"> {{ 'Direccion' }}</label>
    <input class="form-control {{ $errors->has('direccion') ? 'is-invalid' : '' }}" type="text" name="direccion"
        id="direccion" value="{{ isset($personas->direccion) ? $personas->direccion : old('direccion') }}">
    {!! $errors->first('direccion', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="telfijo"> {{ 'Telefono' }}</label>
    <input class="form-control {{ $errors->has('telfijo') ? 'is-invalid' : '' }}" type="number" name="telfijo"
        id="telfijo" value="{{ isset($personas->telfijo) ? $personas->telfijo : old('telfijo') }}">
    {!! $errors->first('telfijo', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="telcel"> {{ 'Celular' }}</label>
    <input class="form-control {{ $errors->has('telcel') ? 'is-invalid' : '' }}" type="number" name="telcel" id="telcel"
        value="{{ isset($personas->telcel) ? $personas->telcel : old('telcel') }}">
    {!! $errors->first('telcel', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="correo"> {{ 'Correo electronico' }}</label>
    <input class="form-control {{ $errors->has('correo') ? 'is-invalid' : '' }}" type="email" name="correo" id="correo"
        value="{{ isset($personas->correo) ? $personas->correo : old('correo') }}">
    {!! $errors->first('correo', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="cod_estudiante"> {{ 'Codigo Estudiante' }}</label>
    <input class="form-control {{ $errors->has('cod_estudiante') ? 'is-invalid' : '' }}" type="text" name="cod_estudiante"
        id="cod_estudiante"
        value="{{ isset($estudiantes->cod_estudiante) ? $estudiantes->cod_estudiante : old('cod_estudiante') }}">
    {!! $errors->first('cod_estudiante', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="id_cisco"> {{ 'Id cisco' }}</label>
    <input class="form-control {{ $errors->has('id_cisco') ? 'is-invalid' : '' }}" type="text" name="id_cisco"
        id="id_cisco" value="{{ isset($estudiantes->id_cisco) ? $estudiantes->id_cisco : old('id_cisco') }}">
    {!! $errors->first('id_cisco', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="Certificacion" class="control-label"> {{ 'Certificacion ' }}</label>
    @if($Modo == 'Crear')
    <select name="id_tipo_certificacion" id="id_tipo_certificacion" class="form-control {{ $errors->has('id_tipo_certificacion') ? 'is-invalid' : '' }}">
        <option value="">Seleccione</option>
        @foreach ($tipoCertificacion as $tipo)
            <option value="{{ $tipo->id }}">{{ $tipo->nombre }} </>
        @endforeach
        {!! $errors->first('id_tipo_certificacion', '<div class="invalid-feedback">:message</div>') !!}
    </select>
    @else 
    <input type="hidden" id="id_tipo_certificacion" name="id_tipo_certificacion" class="form-control" value="{{$estudiantes->id_tipo_certificacion}}" readonly>
   <input type="text" class="form-control" value="{{ $tipoCertificacion->nombre}}" readonly>

    @endif
</div>

<div class="row">
    <div class="col-10">
        <input class="btn btn-primary" type="submit"
            value="{{ $Modo == 'Crear' ? 'Agregar Estudiante' : 'Editar Esutidante' }}">
    </div>
    <div class="col-2">
        <a class="btn btn-secondary" inl href="{{ url('estudiantes/listestudiantes') }}">Volver</a>
    </div>
</div>
