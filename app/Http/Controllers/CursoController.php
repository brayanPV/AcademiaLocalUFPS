<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Anuncio;
use App\Models\Modulo;
use App\Models\Profesor;
use App\Models\Cohorte;
use App\Models\CursoEstudiante;
use App\Models\Estudiante;
use App\Models\TipoCertificacion;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { }

    public function carouselCursos()
    {
        $cursos = Curso::select('c.id_cisco', 'c.imagen', 'm.nombre')
            ->from('curso as c')
            ->join('modulo as m', function ($join) {
                $join->on('m.id', '=', 'c.id_modulo');
            })
            ->get();
        return view('cursos/carouselcursos', compact('cursos'));
    }

    public function listCursos()
    {
        $cursos = Curso::select('c.id', 'c.id_cisco', 'm.nombre as nombre_modulo', 'p.cedula', 'per.nombre as nombreper', 'c.fecha_inicio', 'c.fecha_fin', 'co.nombre', 'm.id_tipo_certificacion as certificacion')
            ->from('curso as c')
            ->join('modulo as m', function ($join) {
                $join->on('m.id', '=', 'c.id_modulo');
            })
            ->join('profesor as p', function ($join) {
                $join->on('p.cedula', '=', 'c.ced_profesor');
            })
            ->join('persona as per', function ($join) {
                $join->on('per.cedula', '=', 'p.cedula');
            })
            ->join('cohorte as co', function ($join) {
                $join->on('co.id', '=', 'c.id_cohorte');
            })->orderBy('id_cisco', 'asc')->paginate(10);
        return view('cursos/listcursos', compact('cursos'));
    }

    public function getModulos(Request $request)
    {

        if ($request->ajax()) {
            $modulos = Modulo::where('id_tipo_certificacion', $request->certificacion_id)->get();
            $moduloArray = array();
            foreach ($modulos as $modulo) {
                $moduloArray[$modulo->id] = $modulo->nombre;
            }
            return response()->json($moduloArray);
        }
    }

    public function getCohortes(Request $request)
    {

        if ($request->ajax()) {
            $cohortes = Cohorte::where('id_tipo_certificacion', $request->certificacion_id)->get();
            $cohortesArray = array();
            foreach ($cohortes as $cohorte) {
                $cohortesArray[$cohorte->id] = $cohorte->nombre;
            }
            return response()->json($cohortesArray);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $certificaciones = TipoCertificacion::get();
        $profesores = Profesor::select('p.cedula', 'per.nombre')
            ->from('profesor as p')
            ->join('persona as per', function ($join) {
                $join->on('p.cedula', '=', 'per.cedula');
            })
            ->where('p.estado', '=', '1')->get();
        return view('cursos/create', compact(['certificaciones', 'profesores']));
    }


    public function verEstudiantes()
    { }


    public function createNuevoEstudianteCurso($curso, $certificacion)
    {

        $estudiantescertificacion = Estudiante::select('p.nombre', 'e.cedula')
            ->from('estudiante as e')
            ->join('persona as p', function ($join) use ($certificacion) {
                $join->on('p.cedula', '=', 'e.cedula')
                    ->where('e.id_tipo_certificacion', $certificacion);
            })->get();


        $estudiantesmatriculados = Estudiante::select('p.nombre', 'e.cedula')
            ->from('estudiante as e')
            ->join('persona as p', function ($join) {
                $join->on('p.cedula', '=', 'e.cedula');
            })
            ->join('curso_estudiante as ce', function ($join) {
                $join->on('ce.ced_estudiante', '=', 'e.cedula');
            })
            ->join('curso as c', function ($join) use ($curso) {
                $join->on('c.id', '=', 'ce.id_curso')
                    ->where('c.id', $curso);
            })
            ->join('cohorte as co', function ($join) {
                $join->on('c.id_cohorte', '=', 'co.id');
            })
            ->join('tipo_certificacion as t_cer', function ($join) use ($certificacion) {
                $join->on('co.id_tipo_certificacion', '=', 't_cer.id')
                    ->where('t_cer.id', $certificacion);
            })->get();

        $lista = array();
        if (!empty($estudiantescertificacion)) {
            foreach ($estudiantescertificacion as $cer) {
                $cc = $cer->cedula;
                $sw = true;
                if (!empty($estudiantesmatriculados)) {
                    foreach ($estudiantesmatriculados as $mat) {
                        $cc1 = $mat->cedula;
                        if ($cc == $cc1) {
                            $sw = ($sw && false);
                        }
                    }
                }
                if ($sw) {
                    $rta = $cer;
                    array_push($lista, $rta);
                }
            }
        }

        $cursoEstudiante = Curso::where('id', $curso)->first();
        return view('cursos/agregarestudiante', compact(['lista', 'cursoEstudiante']));
    }

    public function storeNuevoEstudianteCurso(Request $request)
    {
        $campos = [
            'id_curso' => 'required',
            'ced_estudiante' => 'required',
            'estado' => 'required'
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $campos, $mensaje);
        $datos = request()->except(['_token', 'id_cisco']);
        CursoEstudiante::insert($datos);

        return redirect('profesores/' . $request->input('id_curso') . '/cursoestudiantes')->with('Mensaje', 'Estudiante agregado con exito');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $campos = [
            'id_cisco' => 'required',
            'id_modulo' => 'required',
            'ced_profesor' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'id_cohorte' => 'required'
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $campos, $mensaje);
        $datoscurso = request()->except('_token', 'certificaciones');
        Curso::insert($datoscurso);
        return redirect('cursos/listcursos')->with('Mensaje', 'Curso agregado con exito');
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
        //

        $curso = Curso::select('c.id', 'c.id_cisco', 'c.ced_profesor', 'tc.nombre', 'c.fecha_inicio', 'c.fecha_fin', 'tc.id as id_certificacion', 'm.id as id_modulo', 'm.nombre as nombre_modulo')
            ->from('curso as c')
            ->join('modulo as m', function ($join) {
                $join->on('c.id_modulo', '=', 'm.id');
            })
            ->join('tipo_certificacion as tc', function ($join) {
                $join->on('m.id_tipo_certificacion', '=', 'tc.id');
            })->where('c.id', $id)->first();
        //Curso::findOrFail($id);
        $certificaciones = TipoCertificacion::get();
        $profesores = Profesor::select('p.cedula', 'per.nombre')
            ->from('profesor as p')
            ->join('persona as per', function ($join) {
                $join->on('p.cedula', '=', 'per.cedula');
            })
            ->where('p.estado', '=', '1')->get();
        $cer = $curso->id_certificacion;
        $cohortes = Cohorte::select('c.id', 'c.id_cisco', 'c.nombre')
            ->from('cohorte as c')
            ->join('tipo_certificacion as tc', function ($join) use ($cer) {
                $join->on('c.id_tipo_certificacion', '=', 'tc.id')
                    ->where('tc.id', $cer);
            })->get();
        return view('cursos/edit', compact(['curso', 'certificaciones', 'profesores', 'cohortes']));
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
        $campos = [
            'id_cisco' => 'required',
            'id_modulo' => 'required',
            'ced_profesor' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'id_cohorte' => 'required'
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $campos, $mensaje);
        $datoscurso = request()->except(['_token', '_method', 'updated_at', 'certificaciones']);
        Curso::where('id', '=', $id)->update($datoscurso);
        var_dump($id);
        return redirect('cursos/listcursos')->with('Mensaje', 'Curso Editado con exito');
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
        Curso::destroy($id);
        return redirect('cursos/listcursos')->with('Mensaje', 'Curso eliminado con exito');
    }
}
