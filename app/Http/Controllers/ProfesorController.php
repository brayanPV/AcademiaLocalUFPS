<?php

namespace App\Http\Controllers;

use App\Models\ArchivoCurso;
use Illuminate\Http\Request;
use App\Models\Profesor;
use App\Models\Persona;
use App\Models\User;
use App\Models\Curso;
use App\Models\CursoEstudiante;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Storage;

class ProfesorController extends Controller
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


    public function listProfesor()
    {
        $profesores = Profesor::select('p.cedula', 'p.cod_profesor', 'p.id_cisco', 'per.nombre', 'per.correo', 'per.telfijo', 'per.telcel', 'per.direccion', 'p.estado')
            ->from('profesor as p')
            ->join('persona as per', function ($join) {
                $join->on('p.cedula', '=', 'per.cedula');
            })->paginate(10);

        return view('profesores/listprofesores', compact('profesores'));
    }

    public function verCursosAsignados($id)
    {

        $cursos = Curso::select('c.id', 'c.id_cisco', 'm.nombre as nombre_modulo', 'p.cedula', 'per.nombre as nombreper', 'c.fecha_inicio', 'c.fecha_fin', 'co.nombre', 'tc.nombre as nombre_certificacion')
            ->from('curso as c')
            ->join('modulo as m', function ($join) {
                $join->on('m.id', '=', 'c.id_modulo');
            })
            ->join('profesor as p', function ($join) use ($id) {
                $join->on('p.cedula', '=', 'c.ced_profesor')
                    ->where('p.cedula', $id);
            })
            ->join('persona as per', function ($join) {
                $join->on('per.cedula', '=', 'p.cedula');
            })
            ->join('cohorte as co', function ($join) {
                $join->on('co.id', '=', 'c.id_cohorte');
            })
            ->join('tipo_certificacion as tc', function ($join) {
                $join->on('co.id_tipo_certificacion', '=', 'tc.id');
            })
            ->orderBy('id_cisco', 'asc')->paginate(5);
        return view('profesores/cursosasignados', compact('cursos'));
    }

    public function showMaterial($id)
    {
        $material = ArchivoCurso::select('a.nombre', 'a.url', 'a.descripcion', 'a.id', 'a.id_curso')
            ->from('archivo_curso as a')
            ->where('a.id_curso', $id)->get();
        $curso = Curso::where('id', $id)->first();
        return view('materialapoyo/listmaterial', compact(['material', 'curso']));
    }

    public function verMaterialApoyo(Request $request)
    {
        $material = ArchivoCurso::select('a.nombre', 'a.url', 'a.descripcion', 'a.id', 'a.id_curso')
            ->from('archivo_curso as a')
            ->where('a.id_curso', $request->input('id'))->get();
        $curso = Curso::where('id', $request->input('id'))->first();
        return view('materialapoyo/listmaterial', compact(['material', 'curso']));
    }

    public function createMaterialApoyo(Request $request)
    {
        $curso = Curso::findOrFail($request->input('id'));
        return view('materialapoyo/create', compact('curso'));
    }


    public function storeMaterialApoyo(Request $request)
    {
        $datos = [
            'nombre' => 'required|string',
            'url' => 'required|file|mimes:zip,rar,png,jpg,jpeg,pptx,pdf,docx,doc,pkt',
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $datos, $mensaje);
        $datos = request()->except(['_token', '_method']);
        if ($request->hasFile('url')) {
            $name = $request->file('url')->getClientOriginalName();
            $datos['url'] = $request->file('url')->storeAs('/', $name, 'upload');
        }
        ArchivoCurso::insert($datos);
        return $this->showMaterial($request->input('id_curso'));
        //return redirect('materialapoyo/listmaterial');
    }

    public function downloadFile($id)
    {
        $path = 'C:\Users\stive\Documents\uploads';
        var_dump($path);
        $file = $path . '/' . $id;
        return response()->download($file);
    }

    public function editMaterialApoyo(Request $request, $id)
    {
        $material = ArchivoCurso::findOrFail($id);
        $curso = Curso::findOrFail($request->input('id_curso'));
        return view('materialapoyo/edit', compact(['material', 'curso']));
    }

    public function verEstudiantesCursos($id)
    {

        $curso = DB::table('curso as c')->select('c.ced_profesor', 'c.id', 'm.nombre', 'tc.id as tipo_certificacion')
            ->join('modulo as m', function ($join) {
                $join->on('c.id_modulo', '=', 'm.id');
            })
            ->join('tipo_certificacion as tc', function ($join) {
                $join->on('m.id_tipo_certificacion', '=', 'tc.id');
            })
            ->where('c.id', $id)->get();

        $estudiantes = DB::table('curso_estudiante')
            ->Join('curso', function ($join) use ($id) {
                $join->on('curso_estudiante.id_curso', '=', 'curso.id')
                    ->Where('curso.id', $id);
            })
            ->Join('estudiante', 'curso_estudiante.ced_estudiante', '=', 'estudiante.cedula')
            ->Join('persona', 'curso_estudiante.ced_estudiante', '=', 'persona.cedula')
            ->select('curso_estudiante.id_curso as id', 'curso_estudiante.ced_estudiante as cedula', 'persona.nombre', 'curso_estudiante.observaciones', 'curso_estudiante.estado')->paginate(10);
        return view('profesores/cursoestudiantes', compact('estudiantes', 'curso'));
    }

    public function agregarObservacion($curso, $estudiante)
    {
        $estudiante = CursoEstudiante::select('ce.id_curso', 'ce.ced_estudiante', 'ce.observaciones', 'p.nombre', 'c.id_cisco', 'm.nombre as modulo')
            ->from('curso_estudiante as ce')
            ->join('curso as c', function ($join) {
                $join->on('c.id', '=', 'ce.id_curso');
            })
            ->join('modulo as m', function ($join) {
                $join->on('m.id', '=', 'c.id_modulo');
            })
            ->join('persona as p', function ($join) {
                $join->on('p.cedula', '=', 'ce.ced_estudiante');
            })
            ->where([
                ['id_curso', $curso],
                ['ced_estudiante', $estudiante]
            ])->first();

        return view('profesores/agregarobservacion', compact('estudiante'));
    }



    public function observacionUpdate(Request $request, $id_curso)
    {
        $curso = DB::select('select m.nombre
        from curso c
        inner join modulo m
        on m.id = c.id_modulo
        where c.id = ?', [$id_curso]);
        CursoEstudiante::where([
            ['id_curso', $id_curso],
            ['ced_estudiante', $request->input('cedula')]
        ])->update(['observaciones' => $request->input('observaciones')]);
        return $this->verEstudiantesCursos($id_curso);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('profesores/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //'password' => ['required', 'string', 'min:8', 'confirmed'],
        $mensajep = '';
        $datosPer = [
            'cedula' => 'required|unique:profesor',
            'nombre' => 'required|max:50|string',
            'direccion' => 'required|max:50',
            'telcel' => 'required|max:20',
            'cedula' => 'required',
            'cod_profesor' => 'required|max:10',
            'id_cisco' => 'required',
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        if (Persona::where('cedula', $request->input('cedula'))->first() == null) {
            $this->validate($request, $datosPer, $mensaje);
            $datosPersona = request()->except(['_token', '_method', 'updated_at', 'cod_profesor', 'id_cisco']);
            Persona::insert($datosPersona);
        } else {
            $mensajep = ' esta persona ya existia en el sistema';
        }
        if (Profesor::where('cedula', $request->input('cedula'))->first() != null) {
            return redirect('profesores/create')->with('Mensaje', 'Este profesor ya existe en el sistema, verfique sus datos');
        }
        $this->validate($request, $datosPer, $mensaje);
        $datosProfesor = request()->except(['_token', '_method', 'updated_at', 'nombre', 'direccion', 'telfijo', 'telcel',  'correo']);
        Profesor::insert($datosProfesor);
        User::insert(['cedula' => $request->input('cedula'), 'password' => Hash::make($request->input('cedula'))]);
        $user = User::where('cedula', $request->input('cedula'))->firstOrFail();
        $user->roles()->sync([2, 3]);
        //$user->roles()->sync([2]);
        return redirect('profesores/listprofesores')->with('Mensaje', 'Profesor agregado con exito'  . $mensajep);
    }


    public function buscarProfesor(Request $request)
    {


        /*
$profesores = Profesor::select('p.cedula', 'p.cod_profesor', 'p.id_cisco', 'per.nombre', 'per.correo', 'per.telfijo', 'per.telcel', 'per.direccion', 'p.estado')
            ->from('profesor as p')
            ->join('persona as per', function ($join) {
                $join->on('p.cedula', '=', 'per.cedula');
            })->paginate(10);
            */

        $request->get('buscarProfesor');
        $profesores = Profesor::select('p.cedula', 'p.cod_profesor', 'p.id_cisco', 'per.nombre', 'per.correo', 'per.telfijo', 'per.telcel', 'per.direccion', 'p.estado')
            ->from('profesor as p')
            ->join('persona as per', function ($join) use ($request) {
                $join->on('p.cedula', '=', 'per.cedula')
                    ->where(function ($query) use ($request) {
                        if (is_numeric($request->get('buscarProfesor'))) {
                            return $query->where('p.cedula', 'like', '%' . $request->get('buscarProfesor') . '%');
                        } else {
                            return $query->where('per.nombre', 'like', '%' . $request->get('buscarProfesor') . '%')
                                ->orWhere('per.correo', 'like', '%' . $request->get('buscarProfesor') . '%');
                        }
                    });
            })->get();

        return json_encode($profesores);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $profesores = Profesor::where('cedula', $id)->first();
        $personas = Persona::where('cedula', $id)->first();
        return view('profesores/edit', compact(['profesores', 'personas']));
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
        //
        $mensajep = '';
        $datosPer = [
            'nombre' => 'required|max:50|string',
            'direccion' => 'required|max:50',
            'telcel' => 'required|max:20',
            'cedula' => 'required',
            'cod_profesor' => 'required|max:10',
            'id_cisco' => 'required',
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];

        $this->validate($request, $datosPer, $mensaje);
        $datosPersona = request()->except(['_token', '_method', 'updated_at', 'cod_profesor', 'id_cisco']);
        Persona::where('cedula', $request->input('cedula'))->update($datosPersona);


        $this->validate($request, $datosPer, $mensaje);
        $datosProfesor = request()->except(['_token', '_method', 'updated_at', 'nombre', 'direccion', 'telfijo', 'telcel',  'correo']);
        Profesor::where('cedula', $request->input('cedula'))->update($datosProfesor);
        return redirect('profesores/listprofesores')->with('Mensaje', 'Profesor agregado con exito'  . $mensajep);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        $mensaje = "";
        $est = $request->input('estado');
        var_dump($est);
        Profesor::where('cedula',  $id)->update(['estado' => $est]);
        //
        $user = User::where('cedula', $id)->firstOrFail();
        if ($est == 0) {
            if ($user->hasRole('administrador')) {
                $user->roles()->sync([1, 3]);
                var_dump("ES ADMIN");
            } else {
                $user->roles()->sync([3]);
            }
        } else {
            if ($user->hasRole('administrador')) {
                $user->roles()->sync([1, 2, 3]);
            } else {
                $user->roles()->sync([2, 3]);
            }
        }
        $mensaje .= ($est == 0 ? ' Profesor desactivado con exito' : ' Profesor activado con exito');
        return redirect('profesores/listprofesores')->with('Mensaje', $mensaje);
    }
}
