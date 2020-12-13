<div class="form-group">
    <label for="nombre"> {{ 'Nombre' }}</label>
    <input class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}" type="text" name="nombre" id="nombre"
        value="{{ isset($lineas->nombre) ? $lineas->nombre : old('nombre') }}">
    {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="descripcion">Descripcion</label>
    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
        value="{{ isset($lineas->descripcion) ? $lineas->descripcion : old('descripcion') }}">{{isset($lineas->descripcion) ? $lineas->descripcion : old('descripcion')}}</textarea>
    {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label class="control-label" for="id_grupo_inv"> {{ 'Grupo de Investigacion' }}</label>
    <select name="id_grupo_inv" id="id_grupo_inv"
        class="form-control {{ $errors->has('id_grupo_inv') ? 'is-invalid' : '' }}">
        <option value="{{ isset($lineas->grupo_id) }}">{{ isset($lineas->grupo) ? $lineas->grupo : 'Seleccione' }}
        </option>
        @foreach ($grupos as $grupo)
            @if (isset($lineas->grupo_id))
                @if ($lineas->grupo_id != $grupo->id)
                    <option value="{{ $grupo->id }}">{{ $grupo->nombre }} </>
                @endif
            @else
                <option value="{{ $grupo->id }}">{{ $grupo->nombre }} </>
            @endif
        @endforeach
        </select>
    {!! $errors->first('id_grupo_inv', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="row">
    <div class="col-10">
        <input class="btn btn-primary" type="submit" value="{{ $Modo == 'Crear' ? 'Registrar' : 'Editar' }}">
    </div>
    <div class="col-2">
        <a class="btn btn-secondary" inl href="{{ url('/lineas') }}">Listado</a>
    </div>
</div>
