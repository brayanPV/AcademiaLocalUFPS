@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-6">
                <div class="card-header">
                    <h2>Matricula</h2>
                </div>
                <div class="card-body">
                    <form action="{{ url('cursos',['id_curso'=>$cursoEstudiante->id, 'cursoestudiantes']) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="id_cisco"> {{ 'Id cisco' }}</label>
                            <input class="form-control" type="hidden" name="id_curso" id="id_curso"
                                value="{{ $cursoEstudiante->id }}">
                            <input class="form-control" type="text" name="id_cisco" id="id_cisco"
                                value="{{ $cursoEstudiante->id_cisco }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="ced_estudiante" class="control-label"> {{ 'Estudiante ' }}</label>
                            <select name="ced_estudiante" id="ced_estudiante"
                                class="form-control {{ $errors->has('ced_estudiante') ? 'is-invalid' : '' }}">
                                <option value="">Seleccione</option>
                                @foreach ($lista as $item)
                                    <option value="{{ $item->cedula }}">{{ $item->cedula }} -- {{ $item->nombre }} </>
                                @endforeach
                            </select>
                            {!! $errors->first('ced_estudiante', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label class="observaciones-label" for="observaciones"> {{ 'Observaciones' }}</label>
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
                            {!! $errors->first('observaciones', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="estado"> Estado </label> </br>
                            <select name="estado" id="estado"
                                class="form-control {{ $errors->has('estado') ? 'is-invalid' : '' }}">
                                <option value="ACTIVO">ACTIVO</option>
                                <option value="INACTIVO">INACTIVO</option>
                                <option value="FINALIZADO">FINALIZADO</option>
                            </select>
                            {!! $errors->first('estado', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="row">
                            <div class="col-10">
                                <input class="btn btn-primary" type="submit" value="Agregar">

                            </div>
                            <div class="col-2">
                                <button class="btn btn-secondary" onclick="goBack()">Volver</button>

                                <script>
                                    function goBack() {
                                        window.history.back();
                                    }

                                </script>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
