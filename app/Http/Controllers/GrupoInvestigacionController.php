<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GrupoInvestigacion;
use App\Models\Profesor;

class GrupoInvestigacionController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $grupoInvestigacion = GrupoInvestigacion::get();
        $profesores = Profesor::select('p.cedula', 'per.nombre')
            ->from('profesor as p')
            ->join('persona as per', function ($join) {
                $join->on('p.cedula', '=', 'per.cedula');
            })->get();
        return view('gruposinvestigacion/create', compact(['grupoInvestigacion', 'profesores']));
    }

    public function listGrupoInvestigacion()
    {
        $grupoInvestigacion = GrupoInvestigacion::select('g.id', 'g.nombre', 'g.descripcion', 'g.ced_prof_director', 'per.nombre as nombre_pro')
            ->from('grupo_investigacion as g')
            ->join('profesor as pro', function ($join) {
                $join->on('pro.cedula', '=', 'g.ced_prof_director');
            })
            ->join('persona as per', function ($join) {
                $join->on('per.cedula', '=', 'pro.cedula');
            })->orderBy('id', 'asc')->paginate(5);
        return view('gruposinvestigacion/listgruposinvestigacion', compact('grupoInvestigacion'));
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
        $campos = [
            'nombre' => 'required|unique:grupo_investigacion,nombre',
            'descripcion' => 'required',
            'ced_prof_director' => 'required'
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $campos, $mensaje);
        $datosGrupoInvestigacion = request()->except('_token');
        GrupoInvestigacion::insert($datosGrupoInvestigacion);
        return redirect('gruposinvestigacion/listgruposinvestigacion')->with('Mensaje', 'Grupo de investigacion agregado con exito');
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
        $grupoInvestigacion = GrupoInvestigacion::findOrFail($id);
        $profesores = Profesor::select('p.cedula', 'per.nombre')
            ->from('profesor as p')
            ->join('persona as per', function ($join) {
                $join->on('p.cedula', '=', 'per.cedula');
            })->get();
        return view('gruposinvestigacion.edit', compact(['grupoInvestigacion', 'profesores']));
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
        $campos = [
            'nombre' => 'required|unique:grupo_investigacion,nombre',
            'descripcion' => 'required',
            'ced_prof_director' => 'required'
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $campos, $mensaje);
        $datosGrupoInvestigacion = request()->except(['_token', '_method', 'updated_at']);
        GrupoInvestigacion::where('id', '=', $id)->update($datosGrupoInvestigacion);
        return redirect('gruposinvestigacion/listgruposinvestigacion')->with('Mensaje', 'Grupo de investigacion editado con exito');
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
        GrupoInvestigacion::destroy($id);
        return redirect('gruposinvestigacion/listgruposinvestigacion')->with('Mensaje', 'Grupo de investigacion eliminado con exito');
    }
}
