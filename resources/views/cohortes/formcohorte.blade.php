<div class="form-group">
    <label for="id_cisco"> {{ 'Id Cisco' }}</label>
    <input class="form-control {{ $errors->has('id_cisco') ? 'is-invalid' : '' }}" type="text" name="id_cisco"
        id="id_cisco" value="{{ isset($cohortes->id_cisco) ? $cohortes->id_cisco : old('id_cisco') }}"
        placeholder="{{ isset($cohortes->id_cisco) ? $cohortes->id_cisco : 'UFPS_CCNA' }}">
    {!! $errors->first('id_cisco', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="nombre"> {{ 'Nombre' }}</label>
    <input class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}" type="textarea" name="nombre"
        id="nombre" value="{{ isset($cohortes->nombre) ? $cohortes->nombre : old('nombre') }}">
    {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="fecha_inicio"> {{ 'Fecha Inicio' }}</label>
    <input class="form-control {{ $errors->has('fecha_inicio') ? 'is-invalid' : '' }}" type="date" name="fecha_inicio"
        id="fecha_inicio" value="{{ isset($cohortes->fecha_inicio) ? $cohortes->fecha_inicio : old('fecha_inicio') }}">
    {!! $errors->first('fecha_inicio', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="fecha_fin"> {{ 'Fecha Fin' }}</label>
    <input class="form-control {{ $errors->has('fecha_fin') ? 'is-invalid' : '' }}" type="date" name="fecha_fin"
        id="fecha_fin" value="{{ isset($cohortes->fecha_fin) ? $cohortes->fecha_fin : old('fecha_fin') }}">
    {!! $errors->first('fecha_fin', '<div class="invalid-feedback">:message</div>') !!}
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
            value="{{ isset($cohortes->id_tipo_certificacion) ? $cohortes->id_tipo_certificacion : old('id_tipo_certificacion') }}">
            <label class="form-control">{{$cohortes->nombre_cer}} </label>
    @endif
    {!! $errors->first('Id_tipo_certificacion', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="row">
    <div class="col-10">
        <input class="btn btn-primary" type="submit"
            value="{{ $Modo == 'Crear' ? 'Agregar Cohorte' : 'Editar Cohorte' }}">

    </div>
    <div class="col-2">
        <a class="btn btn-secondary" href="{{ url('cohortes/listcohortes') }}">Volver</a>
    </div>
</div>
