<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profesor;
use App\Models\Persona;
use App\Models\User;
use App\Models\Curso;
use App\Models\CursoEstudiante;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

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
            })->paginate(5);

        return view('profesores/listprofesores', compact('profesores'));
    }

    public function verCursosAsignados($id)
    {

        $cursos = Curso::select('c.id', 'c.id_cisco', 'm.nombre as nombre_modulo', 'p.cedula', 'per.nombre as nombreper', 'c.fecha_inicio', 'c.fecha_fin', 'co.nombre')
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
            })->orderBy('id_cisco', 'asc')->paginate(5);
        return view('profesores/cursosasignados', compact('cursos'));
    }



    public function verEstudiantesCursos($id)
    {
        $curso = DB::select('select m.nombre
        from curso c
        inner join modulo m
        on m.id = c.id_modulo
        where c.id = ?', [$id]);

        $estudiantes = DB::select('select ce.id_curso as id, ce.ced_estudiante as cedula, p.nombre, ce.observaciones, ce.estado
        from curso_estudiante ce
        inner join curso c
        on c.id = ce.id_curso
        and c.id = ?
        inner join estudiante e
        on e.cedula = ce.ced_estudiante
        inner join persona p
        on p.cedula = ce.ced_estudiante', [$id]);
        return view('profesores/cursoestudiantes', compact('estudiantes', 'curso'));
    }

    public function agregarObservacion($curso, $estudiante)
    {
        $estudiante = CursoEstudiante::select('ce.id_curso', 'ce.ced_estudiante', 'ce.observaciones', 'p.nombre', 'c.id_cisco', 'm.nombre as modulo')
        ->from('curso_estudiante as ce')
        ->join('curso as c', function($join){
            $join->on('c.id', '=', 'ce.id_curso');
        })
        ->join('modulo as m', function($join){
            $join->on('m.id', '=', 'c.id_modulo');
        })
        ->join('persona as p', function($join){
            $join->on('p.cedula', '=', 'ce.ced_estudiante');
        })
        ->where([
            ['id_curso', $curso],
            ['ced_estudiante', $estudiante]
        ])->first();

        return view('profesores/agregarobservacion', compact('estudiante'));
    }

    

    public function observacionUpdate(Request $request, $id_curso){
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
            'password' => 'required|string|max:20|confirmed',
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        if (Persona::where('cedula', $request->input('cedula'))->first() == null) {
            $this->validate($request, $datosPer, $mensaje);
            $datosPersona = request()->except(['_token', '_method', 'updated_at', 'cod_profesor', 'password', 'id_cisco', 'password_confirmation']);
            Persona::insert($datosPersona);
        } else {
            $mensajep = ' esta persona ya existia en el sistema';
        }
        if (Profesor::where('cedula', $request->input('cedula'))->first() != null) {
            return redirect('profesores/create')->with('Mensaje', 'Este profesor ya existe en el sistema, verfique sus datos');
        }
        $this->validate($request, $datosPer, $mensaje);
        $datosProfesor = request()->except(['_token', '_method', 'updated_at', 'nombre', 'direccion', 'telfijo', 'telcel', 'password_confirmation', 'correo']);
        Profesor::insert($datosProfesor);
        User::insert(['cedula' => $request->input('cedula'), 'password' => Hash::make($request->input('password'))]);
        $user = User::where('cedula', $request->input('cedula'))->firstOrFail();
        $user->roles()->sync([2,3]);
        //$user->roles()->sync([2]);
        return redirect('profesores/listprofesores')->with('Mensaje', 'Profesor agregado con exito'  . $mensajep);
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
        $est = $request->input('estado');
        var_dump($est);
        Profesor::where('cedula',  $id)->update(['estado' => $est]);
        $mensaje = ($est == 0 ? 'Profesor activado con exito' : 'Profesor desactivado con exito');
        return redirect('profesores/listprofesores')->with('Mensaje', $mensaje);
    }
}
