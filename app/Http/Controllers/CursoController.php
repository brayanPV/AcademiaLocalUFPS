<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Anuncio;
use App\Models\Modulo;
use App\Models\Profesor;
use App\Models\Cohorte;


class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        
    }

    public function carouselCursos(){
        $cursos = Curso::select('c.id_cisco', 'c.imagen', 'm.nombre')
            ->from('curso as c')
            ->join('modulo as m', function ($join) {
                $join->on('m.id', '=', 'c.id_modulo');
            })
            ->get();
        return view('cursos.carouselcursos', compact('cursos'));
    }

    public function listCursos()
    {
        $cursos = Curso::select('c.id','c.id_cisco', 'm.nombre as nombre_modulo', 'p.cedula', 'per.nombre as nombreper', 'c.fecha_inicio', 'c.fecha_fin', 'co.nombre')
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
            })->orderBy('id_cisco','asc')->paginate(5);
        return view('cursos.listcursos', compact('cursos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $modulos = Modulo::get();
        $profesores = Profesor::select('p.cedula', 'per.nombre')
        ->from('profesor as p')
        ->join('persona as per', function($join){
            $join->on('p.cedula','=','per.cedula');
        })->get();
        $cohortes = Cohorte::get();
        return view('cursos.create', compact(['modulos','profesores', 'cohortes']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        $campos=[
            'id_cisco' => 'required',
            'id_modulo' => 'required',
            'ced_profesor' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'id_cohorte' => 'required'
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $campos, $mensaje);
        $datoscurso = request()->except('_token');
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
        $curso = Curso::findOrFail($id);
        $modulos = Modulo::get();
        $profesores = Profesor::select('p.cedula', 'per.nombre')
        ->from('profesor as p')
        ->join('persona as per', function($join){
            $join->on('p.cedula','=','per.cedula');
        })->get();
        $cohortes = Cohorte::get();
        return view('cursos.edit', compact(['curso','modulos','profesores', 'cohortes']));
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
        $campos=[
            'id_cisco' => 'required',
            'id_modulo' => 'required',
            'ced_profesor' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'id_cohorte' => 'required'
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $campos, $mensaje);
        $datoscurso = request()->except(['_token', '_method', 'updated_at']);
        Curso::where('id', '=', $id)->update($datoscurso);
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
        $curso = Curso::findOrFail($id);
        if (Storage::delete('public/' . $curso->imagen)) {
            Anuncio::destroy($id);
        }
        return redirect('cursos/listcursos')->with('Mensaje', 'Curso eliminado con exito');
    }
}
