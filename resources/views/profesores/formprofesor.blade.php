<div class="form-group">
    <label for="cedula"> {{ 'Cedula' }}</label>
    <input class="form-control {{ $errors->has('cedula') ? 'is-invalid' : '' }}" type="number" name="cedula" id="cedula"
        value="{{ isset($profesores->cedula) ? $profesores->cedula : old('cedula') }}">
    {!! $errors->first('cedula', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="nombre"> {{ 'Nombre' }}</label>
    <input class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}" type="text" name="nombre" id="nombre"
        value="{{ isset($profesores->nombre) ? $profesores->nombre : old('nombre') }}"> 
    {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="direccion"> {{ 'Direccion' }}</label>
    <input class="form-control {{ $errors->has('direccion') ? 'is-invalid' : '' }}" type="text" name="direccion" id="direccion"
        value="{{ isset($profesores->direccion) ? $profesores->direccion : old('direccion') }}"> 
    {!! $errors->first('direccion', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="telfijo"> {{ 'Telefono' }}</label>
    <input class="form-control {{ $errors->has('telfijo') ? 'is-invalid' : '' }}" type="number" name="telfijo" id="telfijo"
        value="{{ isset($profesores->telfijo) ? $profesores->telfijo : old('telfijo') }}"> 
    {!! $errors->first('telfijo', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="telcel"> {{ 'Celular' }}</label>
    <input class="form-control {{ $errors->has('telcel') ? 'is-invalid' : '' }}" type="number" name="telcel" id="telcel"
        value="{{ isset($profesores->telcel) ? $profesores->telcel : old('telcel') }}"> 
    {!! $errors->first('telcel', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="correo"> {{ 'Correo electronico' }}</label>
    <input class="form-control {{ $errors->has('correo') ? 'is-invalid' : '' }}" type="email" name="correo" id="correo"
        value="{{ isset($profesores->correo) ? $profesores->correo : old('correo') }}"> 
    {!! $errors->first('correo', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="cod_profesor"> {{ 'Codigo profesor' }}</label>
    <input class="form-control {{ $errors->has('cod_profesor') ? 'is-invalid' : '' }}" type="text" name="cod_profesor" id="cod_profesor"
        value="{{ isset($profesores->cod_profesor) ? $profesores->cod_profesor : old('cod_profesor') }}"> 
    {!! $errors->first('cod_profesor', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="id_cisco"> {{ 'Id cisco' }}</label>
    <input class="form-control {{ $errors->has('id_cisco') ? 'is-invalid' : '' }}" type="text" name="id_cisco" id="id_cisco"
        value="{{ isset($profesores->id_cisco) ? $profesores->id_cisco : old('id_cisco') }}"> 
    {!! $errors->first('id_cisco', '<div class="invalid-feedback">:message</div>') !!}
</div>

<div class="form-group row">
    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

    <div class="col-md-6">
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

    <div class="col-md-6">
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
    </div>
</div>


<div class="row">
    <div class="col-10">
    <input class="btn btn-primary" type="submit" value="{{ $Modo == 'Crear' ? 'Agregar Profesor' : 'Editar Modulo' }}">
    </div>
    <div class="col-2">
        <a class="btn btn-secondary" inl href="{{ url('profesores/listprofesores') }}">Volver</a>
    </div>
</div>
