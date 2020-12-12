<?php

namespace App\Http\Controllers;

use App\Models\CursoEstudiante;
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
            'e.id',
            'per.nombre',
            'c.id as tipo_certificacion_id',
            'c.nombre as nombre_certificacion',
            'per.correo',
            'per.telfijo',
            'e.estado',
            'e.id_cisco',
            'e.cod_estudiante',
            'per.telcel',
            'per.direccion',
            'e.recibo_pago_inscripcion',
            'e.recibo_pago_matricula',
            'ec.id as est_cer_id'
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
            'e.id',
            'per.nombre',
            'e.estado',
            'c.id as tipo_certificacion_id',
            'c.nombre as nombre_certificacion',
            'per.correo',
            'per.telfijo',
            'e.id_cisco',
            'e.cod_estudiante',
            'per.telcel',
            'per.direccion',
            'e.recibo_pago_inscripcion',
            'e.recibo_pago_matricula',
            'etc.id as est_cer_id'
        )
            ->from('estudiante as e')
            ->join('persona as per', function ($join) {
                $join->on('e.cedula', '=', 'per.cedula');
            })->join('estudiante_tipo_certificacion as etc', function ($join) {
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

    public function verNotasCertificacion($id_cer_est)
    {


        $est = DB::select("Select m.nombre as modulo, p.nombre as profesor, ce.valor, ce.laboratorio, tc.nombre as nombre_cer
        from curso_estudiante ce
        inner join estudiante e
        on ce.ced_estudiante = e.cedula
        inner join estudiante_tipo_certificacion etc
        on etc.estudiante_id = e.id
        and etc.id = ?
        inner join tipo_certificacion tc 
        on etc.tipo_certificacion_id = tc.id
        inner join modulo m 
        on tc.id = m.id_tipo_certificacion
        inner join curso c 
        on m.id = c.id_modulo
        and c.id = ce.id_curso
        inner join persona p
        on c.ced_profesor = p.cedula", [$id_cer_est]);


        $modulos = 0;
        $laboratorios = 0;
        $cont = 0;
        foreach ($est as $e) {
            $cont++;
            $modulos += $e->valor;
            $laboratorios += $e->laboratorio;
        }
        $notaM = $modulos / $cont;
        $notaL = $laboratorios / $cont;

        DB::update('update estudiante_tipo_certificacion set nota_final_modulo = ?, nota_final_laboratorio = ? where id = ?', [$notaM, $notaL, $id_cer_est]);
        $est_cer = DB::select('select * from estudiante_tipo_certificacion where id = ?', [$id_cer_est]);

        $estudiante =  DB::select('select p.nombre, etc.nota_final_modulo, etc.nota_final_laboratorio, etc.nota_prueba, etc.nota_sustentacion 
        from estudiante_tipo_certificacion etc
        inner join estudiante e 
        on etc.estudiante_id = e.id
        and etc.id = ?
        inner join persona p
        on e.cedula = p.cedula', [$id_cer_est]);
        if ($estudiante[0]->nota_prueba != null) {
            $definitiva = ($estudiante[0]->nota_final_modulo * 0.15) + ($estudiante[0]->nota_final_laboratorio * 0.15) + ($estudiante[0]->nota_prueba * 0.40) + ($estudiante[0]->nota_sustentacion * 0.30);
            DB::update('update estudiante_tipo_certificacion set definitiva = ? where id = ?', [$definitiva, $id_cer_est]);
        }
        return view('estudiantes/vernotascertificacion', compact(['est', 'est_cer', 'estudiante']));
    }

    public function createNotaPrueba($id_cer_est)
    {
        $est_cer = DB::table('estudiante_tipo_certificacion')
            ->select('etc.nota_prueba', 'p.nombre as estudiante', 'tc.nombre as certificacion', 'etc.id')
            ->from('estudiante_tipo_certificacion as etc')
            ->join('estudiante as e', function ($join) {
                $join->on('etc.estudiante_id', '=', 'e.id');
            })
            ->join('persona as p', function ($join) {
                $join->on('e.cedula', '=', 'p.cedula');
            })
            ->join('tipo_certificacion as tc', function ($join) {
                $join->on('etc.tipo_certificacion_id', '=', 'tc.id');
            })
            ->where('etc.id', '=', $id_cer_est)->first();
        return view('estudiantes/subirnotaprueba', compact('est_cer'));
    }

    public function updateNotaPrueba(Request $request, $id_cer_est)
    {
        $dato = [
            'nota_prueba' => 'required|numeric|max:100',
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $dato, $mensaje);
        if ($request->input('nota_prueba') > 82.5) {
            DB::update('update estudiante_tipo_certificacion set nota_prueba = ?, nota_sustentacion = ? where id = ?', [$request->input('nota_prueba'), $request->input('nota_prueba'), $id_cer_est]);
        }
        DB::update('update estudiante_tipo_certificacion set nota_prueba = ? where id = ?', [$request->input('nota_prueba'), $id_cer_est]);
        return $this->verNotasCertificacion($id_cer_est);
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
        $cursos = CursoEstudiante::select('m.nombre', 'tc.nombre as certificacion', 'm.url1', 'm.url2', 'c.id', 'ce.valor', 'ce.laboratorio', 'ce.certificado', 'ce.carta')
            ->from('curso_estudiante as ce')
            ->join('curso as c', function ($join) {
                $join->on('ce.id_curso', '=', 'c.id');
            })
            ->join('modulo as m', function ($join) {
                $join->on('c.id_modulo', '=', 'm.id');
            })
            ->join('tipo_certificacion as tc', function ($join) {
                $join->on('m.id_tipo_certificacion', '=', 'tc.id');
            })
            ->join('estudiante as e', function ($join) use ($id) {
                $join->on('ce.ced_estudiante', '=', 'e.cedula')
                    ->where('e.cedula', '=', $id);
            })->paginate(10)->sortBy('tc.id');

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
            ->join('estudiante_tipo_certificacion as etc', function ($join) {
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
        $datosEstudiante = request()->except(['_token', '_method', 'updated_at', 'nombre', 'direccion', 'telfijo', 'telcel', 'correo', 'id_cisco', 'id_tipo_certificacion']);
        Estudiante::where('cedula', $id)->update($datosEstudiante);
        return redirect('estudiantes/listestudiantes')->with('Mensaje', 'Estudiante editado con exito'  . $mensajep);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $estado = $request->input('estado');
        if ($estado == 0) {
            Estudiante::where('cedula', $id)->update(['estado' => $estado]);
            User::where('cedula', $id)->delete();
        } else {
            Estudiante::where('cedula', $id)->update(['estado' => $estado]);
            User::insert(['cedula' => $id, 'password' => Hash::make($id)]);
            $user = User::where('cedula', $id)->firstOrFail();
            $user->roles()->sync(Role::where('nombre', 'estudiante')->first());
        }

        $mensaje = ($estado == 0 ? ' Estudiante desactivado con exito' : ' Estudiante activado con exito');
        return redirect('estudiantes/listestudiantes')->with('Mensaje', $mensaje);
    }
}
