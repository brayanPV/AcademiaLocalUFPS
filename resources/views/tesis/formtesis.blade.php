<div class="form-group">
    <label for="cod_biblioteca"> {{ 'Codigo Biblioteca' }}</label>
    <input class="form-control {{ $errors->has('cod_biblioteca') ? 'is-invalid' : '' }}" type="text"
        name="cod_biblioteca" id="cod_biblioteca" max="10"
        value="{{ isset($tesis->cod_biblioteca) ? $tesis->cod_biblioteca : old('cod_biblioteca') }}"
        {{ $Modo == 'Crear' ?: 'readonly' }}>
    {!! $errors->first('cod_biblioteca', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="fecha"> {{ 'Fecha' }}</label>
    <input class="form-control {{ $errors->has('fecha') ? 'is-invalid' : '' }}" type="date" name="fecha" id="fecha"
        value="{{ isset($tesis->fecha) ? $tesis->fecha : old('fecha') }}">
    {!! $errors->first('fecha', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="titulo"> {{ 'Titulo' }}</label>
    <input class="form-control {{ $errors->has('titulo') ? 'is-invalid' : '' }}" type="text" name="titulo" id="titulo"
        value="{{ isset($tesis->titulo) ? $tesis->titulo : old('titulo') }}">
    {!! $errors->first('titulo', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label class="control-label" for="id_tipo_tesis"> {{ 'Tipo de Tesis' }}</label>
    <select name="id_tipo_tesis" id="id_tipo_tesis"
        class="form-control {{ $errors->has('id_tipo_tesis') ? 'is-invalid' : '' }}">
        <option value="{{ isset($tesis->id_tipo_tesis) ? $tesis->id_tipo_tesis : 0}}">
            {{ isset($tesis->id_tipo_tesis) ? $tesis->tipo : 'Seleccione' }}
        </option>
        @foreach ($tipos as $tipo)
            @if (isset($tesis->id_tipo_tesis))
                @if ($tesis->id_tipo_tesis != $tipo->id)
                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }} </>
                @endif
            @else
                <option value="{{ $tipo->id }}">{{ $tipo->nombre }} </>
            @endif
        @endforeach
    </select>
    {!! $errors->first('id_tipo_tesis', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label class="control-label" for="id_linea_inv"> {{ 'Linea de Investigacion' }}</label>
    <select name="id_linea_inv" id="id_linea_inv"
        class="form-control {{ $errors->has('id_linea_inv') ? 'is-invalid' : '' }}">
        <option value="{{ isset($tesis->id_linea_inv) ? $tesis->id_linea_inv : 0 }}">
            {{ isset($tesis->id_linea_inv) ? $tesis->linea : 'Seleccione' }}
        </option>
        @foreach ($lineas as $linea)
            @if (isset($tesis->id_linea_inv))
                @if ($tesis->id_linea_inv != $linea->id)
                    <option value="{{ $linea->id }}">{{ $linea->nombre }} {{ $linea->id }}</>
                @endif
            @else
                <option value="{{ $linea->id }}">{{ $linea->nombre }} </>
            @endif
        @endforeach
    </select>
    {!! $errors->first('id_linea_inv', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="estado"> {{ 'Estado' }}</label>
    <input class="form-control {{ $errors->has('estado') ? 'is-invalid' : '' }}" type="text" name="estado" id="estado"
        value="{{ isset($tesis->estado) ? $tesis->estado : old('estado') }}">
    {!! $errors->first('estado', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label class="control-label" for="director"> {{ 'Director' }}</label>
    <select name="director" id="director" class="form-control {{ $errors->has('director') ? 'is-invalid' : '' }}" {{$Modo=='Crear' ? : 'disabled'}}>
        <option value="{{ isset($tesis->director) ? $tesis->director : 0 }}">
            {{ isset($tesis->director) ? $tesis->nombre_director : 'Seleccione' }}
        </option>
        @foreach ($profesores as $profesor)
            @if (isset($tesis->director))
                @if ($tesis->director != $profesor->cedula)
                    <option value="{{ $profesor->cedula }}">{{ $profesor->nombre }} </>
                @endif
            @else
                <option value="{{ $profesor->cedula }}">{{ $profesor->nombre }} </>
            @endif
        @endforeach
    </select>
    {!! $errors->first('director', '<div class="invalid-feedback">:message</div>') !!}
</div>
@if ($Modo == 'Editar')
    <div class="form-group">
        <label class="control-label" for="jurado"> {{ 'Jurado' }}</label>
        <select name="jurado" id="jurado" class="form-control {{ $errors->has('jurado') ? 'is-invalid' : '' }}">
            <option value="{{ isset($tesis->jurado) ? $tesis->jurado : 0 }}">
                {{ isset($tesis->jurado) ? $tesis->nombre_jurado : 'Seleccione' }}
            </option>
            @foreach ($profesores as $profesor)
            @if (isset($tesis->jurado))
                @if ($tesis->jurado != $profesor->cedula and $profesor->cedula != $tesis->director)
                    <option value="{{ $profesor->cedula }}">{{ $profesor->nombre }} </>
                @endif
            @else
                <option value="{{ $profesor->cedula }}">{{ $profesor->nombre }} </>
            @endif
        @endforeach
        </select>
        {!! $errors->first('jurado', '<div class="invalid-feedback">:message</div>') !!}
    </div>
@endif
<div class="row">
    <div class="col-10">
        <input class="btn btn-primary" type="submit" value="{{ $Modo == 'Crear' ? 'Agregar Tesis' : 'Editar Tesis' }}">

    </div>
    <div class="col-2">
        <a class="btn btn-secondary" href="{{ url('tesis/') }}">Volver</a>
    </div>
</div>
