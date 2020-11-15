<div class="form-group">
    <label for="cedula"> {{ 'Cedula' }}</label>
    <input class="form-control {{ $errors->has('cedula') ? 'is-invalid' : '' }}" type="number" name="cedula"
        id="cedula" value="{{ isset($preinscritos->cedula) ? $preinscritos->cedula : old('cedula') }}" @if($Modo=='Editar'){ readonly } @endif>
    {!! $errors->first('cedula', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="nombre"> {{ 'Nombre' }}</label>
    <input class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}" type="text" name="nombre" id="nombre"
    value="{{ isset($preinscritos->nombre) ? $preinscritos->nombre : old('nombre') }}">
    {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="direccion"> {{ 'Direccion' }}</label>
    <input class="form-control {{ $errors->has('direccion') ? 'is-invalid' : '' }}" type="text" name="direccion"
    value="{{ isset($preinscritos->direccion) ? $preinscritos->direccion : old('direccion') }}"  id="direccion">
    {!! $errors->first('direccion', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="telfijo"> {{ 'Telefono' }}</label>
    <input class="form-control {{ $errors->has('telfijo') ? 'is-invalid' : '' }}" type="number" name="telfijo"
    value="{{ isset($preinscritos->telfijo) ? $preinscritos->telfijo : old('telfijo') }}"  id="telfijo">
    {!! $errors->first('telfijo', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="telcel"> {{ 'Celular' }}</label>
    <input class="form-control {{ $errors->has('telcel') ? 'is-invalid' : '' }}" type="number" name="telcel"
    value="{{ isset($preinscritos->telcel) ? $preinscritos->telcel : old('telcel') }}"   id="telcel">
    {!! $errors->first('telcel', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="correo"> {{ 'Correo electronico' }}</label>
    <input class="form-control {{ $errors->has('correo') ? 'is-invalid' : '' }}" type="email" name="correo"
    value="{{ isset($preinscritos->correo) ? $preinscritos->correo : old('correo') }}" id="correo">
    {!! $errors->first('correo', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label class="control-label" for="semestre"> {{ 'Semestre' }}</label>
    <select name="semestre" id="semestre" class="form-control {{ $errors->has('semestre') ? 'is-invalid' : '' }}">
        <option value="0">No pertenezco a la UFPS</option>
        @for ($i = 1; $i < 11; $i++)
            <option value="{{ $i }}"> {{ $i }}</option>
        @endfor
        <option value="11">Ya termine materias</option>
    </select>
    <div class="form-group">
        <label class="control-label" for="certificacion"> {{ 'Certificacion' }}</label>
        <select name="certificacion" id="certificacion"
            class="form-control {{ $errors->has('certificacion') ? 'is-invalid' : '' }}">
            <option value="">Seleccione</option>
            @foreach ($certificaciones as $certificacion)
                <option value="{{ $certificacion->id }}">{{ $certificacion->nombre }} </>
            @endforeach

        </select>
        {!! $errors->first('certificacion', '<div class="invalid-feedback">:message</div>') !!}
    </div>
    <div class="row">
        <div class="col-10">
            <input class="btn btn-primary" type="submit" value="Preinscribir">
        </div>
        <div class="col-2">
           @if(!Auth::check()) <a class="btn btn-secondary" inl href="{{ url('/') }}">Inicio</a>
           @else <a class="btn btn-secondary" inl href="{{ url('/preinscripcion/listpreinscripcion') }}">Lsitado</a>
           @endif
        </div>
    </div>
