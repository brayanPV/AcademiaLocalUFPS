<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\TipoCertificacion;
use App\Models\Persona;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function listEstudiante()
    {
        $estudiantes = Estudiante::select(
            'e.cedula',
            'per.nombre',
            'c.id',
            'c.nombre as nombre_certificacion',
            'per.correo',
            'per.telfijo',
            'e.id_cisco',
            'e.cod_estudiante',
            'per.telcel',
            'per.direccion',
            'e.recibo_pago_inscripcion',
            'e.recibo_pago_matricula'
        )
            ->from('estudiante as e')
            ->join('persona as per', function ($join) {
                $join->on('e.cedula', '=', 'per.cedula');
            })->join('estudiante_tipo_certificacion as ec', function ($join) {
                $join->on('e.id', '=', 'ec.estudiante_id');
            })->join('tipo_certificacion as c', function ($join) {
                $join->on('ec.tipo_certificacion_id', '=', 'c.id');
            })->paginate(10);

        return view('estudiantes/listestudiantes', compact('estudiantes'));
    }

    public function buscarEstudiante(Request $request)
    {
        $estudiantes = Estudiante::select(
            'e.cedula',
            'per.nombre',
            'c.id',
            'c.nombre as nombre_certificacion',
            'per.correo',
            'per.telfijo',
            'e.id_cisco',
            'e.cod_estudiante',
            'per.telcel',
            'per.direccion',
            'e.recibo_pago_inscripcion',
            'e.recibo_pago_matricula'
        )
            ->from('estudiante as e')
            ->join('persona as per', function ($join) {
                $join->on('e.cedula', '=', 'per.cedula');
            })->join('estudiante_tipo_certificacion as etc', function($join) {
                $join->on('etc.estudiante_id', '=', 'e.id');
            })
            ->join('tipo_certificacion as c', function ($join) use ($request) {
                $join->on('etc.tipo_certificacion_id', '=', 'c.id')
                    ->where(function ($query) use ($request) {
                        if (is_numeric($request->get('buscarEstudiante'))) {
                            return $query->where('e.cedula', 'like', '%' . $request->get('buscarEstudiante') . '%');
                        } else {
                            return $query->where('per.nombre', 'like', '%' . $request->get('buscarEstudiante') . '%')
                                ->orWhere('per.correo', 'like', '%' . $request->get('buscarEstudiante') . '%')
                                ->orWhere('c.nombre', 'like', '%' . $request->get('buscarEstudiante') . '%');
                        }
                    });
            })->get();

        return json_encode($estudiantes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $tipoCertificacion =  TipoCertificacion::get();
        return view('estudiantes/create', compact('tipoCertificacion'));
    }


    public function verCursosAsignados($id)
    {
        $cursos = DB::select('select m.nombre, tc.nombre as nombrec, m.url1, m.url2, c.id
        from modulo m
        inner join tipo_certificacion tc
        on m.id_tipo_certificacion = tc.id
        inner join curso c
        on c.id_modulo = m.id
        inner join curso_estudiante ce
        on ce.id_curso = c.id
        and ce.ced_estudiante = ?', [$id]);
        return view('estudiantes/cursosasignados', compact('cursos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $mensajep = '';
        $datosPer = [
            'cedula' => 'required',
            'nombre' => 'required|max:50|string',
            'direccion' => 'required|max:50',
            'telcel' => 'required|max:20',
            'id_cisco' => 'required|unique:estudiante',
            'id_tipo_certificacion' => 'required',
            'cod_estudiante' => 'string',
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        $certificacion = $request->input('id_tipo_certificacion');
        if (Persona::where('cedula', $request->input('cedula'))->first() == null) {
            $this->validate($request, $datosPer, $mensaje);
            $datosPersona = request()->except(['_token', '_method', 'updated_at', 'cod_estudiante', 'id_cisco', 'id_tipo_certificacion']);
            Persona::insert($datosPersona);
        } else {
            $mensajep = ' esta persona ya existia en el sistema';
        }

        if (Estudiante::where('cedula', $request->input('cedula'))->first() != null) {
            $est = Estudiante::where('cedula', $request->input('cedula'))->first();
            $e = Estudiante::find($est->id);

            if ($e->hasCertificacion($certificacion)) {
                return redirect('estudiantes/create')->with('Mensaje', 'Este estudiante ya esta matriculado en esa certificacion, por favor verifique sus datos' . $est->hasCertificacion($certificacion)->nombre);
            } else {
                $e->certificaciones()->attach($certificacion);
                return redirect('estudiantes/listestudiantes')->with('Mensaje', 'Estudiante agregado con exito,'  . $mensajep);
            }
        } else {
            $this->validate($request, $datosPer, $mensaje);
            $datosEstudiante = request()->except(['_token', '_method', 'updated_at', 'nombre', 'direccion', 'telfijo', 'telcel', 'correo', 'id_tipo_certificacion']);
            Estudiante::insert($datosEstudiante);
            $est = Estudiante::where('cedula', $request->input('cedula'))->first();
            $e = Estudiante::find($est->id);
            $e->certificaciones()->attach($certificacion);
            User::insert(['cedula' => $request->input('cedula'), 'password' => Hash::make($request->input('cedula'))]);
            $user = User::where('cedula', $request->input('cedula'))->firstOrFail();
            $user->roles()->sync(Role::where('nombre', 'estudiante')->first());
            return redirect('estudiantes/listestudiantes')->with('Mensaje', 'Estudiante agregado con exito'  . $mensajep);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Persona::where('cedula', $request->input('cedula'))->first()
        $estudiantes = Estudiante::where('cedula', $id)->first();
        $personas = Persona::where('cedula', $id)->first();
        $tipoCertificacion = TipoCertificacion::select('tc.id', 'tc.nombre')
            ->from('tipo_certificacion as tc')
            ->join('estudiante_tipo_certificacion as etc', function($join){
                $join->on('etc.tipo_certificacion_id', '=', 'tc.id');
            })
            ->join('estudiante as e', function ($join) use ($estudiantes) {
                $join->on('e.id', '=', 'etc.estudiante_id')
                    ->where('e.id', $estudiantes->id);
            })->first();
        return view('estudiantes/edit', compact(['estudiantes', 'personas', 'tipoCertificacion']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $mensajep = '';
        $datosPer = [
            'nombre' => 'required|max:50|string',
            'direccion' => 'required|max:50',
            'telcel' => 'required|max:20',
            'cedula' => 'required',
            'id_cisco' => 'required',
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];

        $this->validate($request, $datosPer, $mensaje);
        $datosPersona = request()->except(['_token', '_method', 'updated_at', 'cod_estudiante', 'id_cisco', 'id_tipo_certificacion']);
        Persona::where('cedula', $id)->update($datosPersona);

        $this->validate($request, $datosPer, $mensaje);
        $datosEstudiante = request()->except(['_token', '_method', 'updated_at', 'nombre', 'direccion', 'telfijo', 'telcel', 'correo']);
        Estudiante::where('cedula', $id)->update($datosEstudiante);
        return redirect('estudiantes/listestudiantes')->with('Mensaje', 'Estudiante agregado con exito'  . $mensajep);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
