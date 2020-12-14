<div class="form-group">
    <label for="cedula"> {{ 'Cedula' }}</label>
    <input class="form-control {{ $errors->has('cedula') ? 'is-invalid' : '' }}" type="number" name="cedula" id="cedula"
        value="{{ isset($inscritos->cedula) ? $inscritos->cedula : old('cedula') }}" @if ($Modo == 'Editar' || $Modo == 'Upload') readonly @endif>
    {!! $errors->first('cedula', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="nombre"> {{ 'Nombre' }}</label>
    <input class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}" type="text" name="nombre" id="nombre"
        value="{{ isset($inscritos->nombre) ? $inscritos->nombre : old('nombre') }}" @if ($Modo == 'Upload') readonly @endif>
    {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
</div>
@if ($Modo != 'Upload')
    <div class="form-group">
        <label for="direccion"> {{ 'Direccion' }}</label>
        <input class="form-control {{ $errors->has('direccion') ? 'is-invalid' : '' }}" type="text" name="direccion"
            value="{{ isset($inscritos->direccion) ? $inscritos->direccion : old('direccion') }}" id="direccion">
        {!! $errors->first('direccion', '<div class="invalid-feedback">:message</div>') !!}
    </div>
    <div class="form-group">
        <label for="telfijo"> {{ 'Telefono' }}</label>
        <input class="form-control {{ $errors->has('telfijo') ? 'is-invalid' : '' }}" type="number" name="telfijo"
            value="{{ isset($inscritos->telfijo) ? $inscritos->telfijo : old('telfijo') }}" id="telfijo">
        {!! $errors->first('telfijo', '<div class="invalid-feedback">:message</div>') !!}
    </div>
    <div class="form-group">
        <label for="telcel"> {{ 'Celular' }}</label>
        <input class="form-control {{ $errors->has('telcel') ? 'is-invalid' : '' }}" type="number" name="telcel"
            value="{{ isset($inscritos->telcel) ? $inscritos->telcel : old('telcel') }}" id="telcel">
        {!! $errors->first('telcel', '<div class="invalid-feedback">:message</div>') !!}
    </div>
    <div class="form-group">
        <label for="correo"> {{ 'Correo electronico' }}</label>
        <input class="form-control {{ $errors->has('correo') ? 'is-invalid' : '' }}" type="email" name="correo"
            value="{{ isset($inscritos->correo) ? $inscritos->correo : old('correo') }}" id="correo">
        {!! $errors->first('correo', '<div class="invalid-feedback">:message</div>') !!}
    </div>
    <div class="form-group">
        <label class="control-label" for="semestre"> {{ 'Semestre' }}</label>
        <select name="semestre" id="semestre" class="form-control {{ $errors->has('semestre') ? 'is-invalid' : '' }}">
            <option value="{{ isset($inscritos->semestre) }}">
                {{ isset($inscritos->semestre) ? $inscritos->semestre : 'No pertenezco a la ufps' }}
            </option>
            @for ($i = 1; $i < 11; $i++)
                @if (isset($inscritos->semestre))
                    @if ($inscritos->semestre != $i)
                        <option value="{{ $i }}"> {{ $i }}</option>
                    @endif
                @else
                    <option value="{{ $i }}">{{ $i }} </>
                @endif
            @endfor
            <option value="11">Ya termine materias</option>
        </select>
        <div class="form-group">
            <label class="control-label" for="certificacion"> {{ 'Certificacion' }}</label>
            <select name="certificacion" id="certificacion"
                class="form-control {{ $errors->has('certificacion') ? 'is-invalid' : '' }}">
                <option value="{{ isset($inscritos->certificacion) }}">
                    {{ isset($inscritos->certificacion) ? $inscritos->nombre_tc : 'Seleccione' }}
                </option>
                @foreach ($certificaciones as $certificacion)
                    @if (isset($inscritos->certificacion))
                        @if ($inscritos->certificacion != $certificacion->id)
                            <option value="{{ $certificacion->id }}">{{ $certificacion->nombre }} </>
                        @endif
                    @else
                        <option value="{{ $certificacion->id }}">{{ $certificacion->nombre }} </>
                    @endif
                @endforeach

            </select>
            {!! $errors->first('certificacion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    @else
        <div class="form-group">
            <label for="recibo_pago_inscripcion"> {{ 'Archivo' }}</label>
            @if ($inscritos->recibo_pago_inscripcion != '')
                <img class="img-thumbnail img-fluid" src="/Users/stive/Documents/uploads/recibo/eps.png">
                <img class="img-thumbnail img-fluid"
                    src="{{ Storage::disk('upload')->path($inscritos->recibo_pago_inscripcion) }}" width="250">
            @endif
            <input class="form-control {{ $errors->has('recibo_pago_inscripcion') ? 'is-invalid' : '' }}" type="file"
                name="recibo_pago_inscripcion" id="recibo_pago_inscripcion"
                value="{{ isset($inscritos->recibo_pago_inscripcion) ? $inscritos->recibo_pago_inscripcion : old('recibo_pago_inscripcion') }}">
            {!! $errors->first('url', '<div class="invalid-feedback">:message</div>') !!}
        </div>
@endif
<div class="row">
    <div class="col-10">
        <input class="btn btn-primary" type="submit" value="{{ $Modo == 'Crear' ? 'Inscribir' : 'Editar' }}">
    </div>
    <div class="col-2">
        @if (!Auth::check()) <a class="btn btn-secondary" inl
                href="{{ url('/') }}">Inicio</a>
        @else <a class="btn btn-secondary" inl href="{{ url('/inscritos/listinscritos') }}">Listado</a>
        @endif
    </div>
</div>
