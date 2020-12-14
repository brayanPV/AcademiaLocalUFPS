<div class="form-group">
    <label for="tipo_certificacion_id"> {{ 'Certificacion' }}</label>
    <input type="hidden" id="id" name="id" value="{{ $estudiantes->id }}">
    <input class="form-control {{ $errors->has('tipo_certificacion_id') ? 'is-invalid' : '' }}" type="text"
        name="tipo_certificacion_id" id="tipo_certificacion_id"
        value="{{ isset($estudiantes->certificacion) ? $estudiantes->certificacion : old('certificacion') }}" readonly>
    {!! $errors->first('cedula', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    <label for="nombre"> {{ 'Nombre' }}</label>
    <input class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}" type="text" name="nombre" id="nombre"
        value="{{ isset($estudiantes->nombre) ? $estudiantes->nombre : old('nombre') }}" readonly>
    {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
</div>
@if ($Modo == 'inscripcion')
    <div class="form-group">
        <label for="recibo_pago_inscripcion"> {{ 'Inscripcion' }}</label>
        @if ($estudiantes->recibo_pago_inscripcion != '')
            <img class="img-thumbnail img-fluid"
                src="{{ asset('storage') . '/' . $estudiantes->recibo_pago_inscripcion }}" width="250">
        @endif
        <input class="form-control {{ $errors->has('recibo_pago_inscripcion') ? 'is-invalid' : '' }}" type="file"
            name="recibo_pago_inscripcion" id="recibo_pago_inscripcion"
            value="{{ isset($estudiantes->recibo_pago_inscripcion) ? $estudiantes->recibo_pago_inscripcion : old('recibo_pago_inscripcion') }}">
        {!! $errors->first('url', '<div class="invalid-feedback">:message</div>') !!} </br>
        <div class="alert alert-danger">Si no selecciona ningun recibo el actual se va a eliminar, para regresar de
            click en listado </div>
    </div>
@else
    <div class="form-group">
        <label for="recibo_pago_matricula"> {{ 'Matricula' }}</label>
        @if ($estudiantes->recibo_pago_matricula != '')
            <img class="img-thumbnail img-fluid"
                src="{{ asset('storage') . '/' . $estudiantes->recibo_pago_matricula }}" width="250">
        @endif
        <input class="form-control {{ $errors->has('recibo_pago_matricula') ? 'is-invalid' : '' }}" type="file"
            name="recibo_pago_matricula" id="recibo_pago_matricula"
            value="{{ isset($estudiantes->recibo_pago_matricula) ? $estudiantes->recibo_pago_matricula : old('recibo_pago_matricula') }}">
        {!! $errors->first('url', '<div class="invalid-feedback">:message</div>') !!}
        </br>
        <div class="alert alert-danger">Si no selecciona ningun recibo el actual se va a eliminar, para regresar de
            click en listado </div>
    </div>
@endif
<div class="row">
    <div class="col-10">
        <input class="btn btn-primary" type="submit" id="submit" value="Subir">
    </div>
    <div class="col-2">
        @if (!Auth::check()) <a class="btn btn-secondary" inl
                href="{{ url('/') }}">Inicio</a>
        @else <a class="btn btn-secondary" inl href="{{ url('/estudiantes/listestudiantes') }}">Listado</a>
        @endif
    </div>
</div>
