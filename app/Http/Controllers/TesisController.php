<?php

namespace App\Http\Controllers;

use App\Models\LineaInvestigacion;
use App\Models\Profesor;
use App\Models\Tesis;
use App\Models\TipoTesis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TesisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tesis = Tesis::select(
            't.id',
            't.cod_biblioteca',
            't.fecha',
            't.titulo',
            't.id_tipo_tesis',
            'ti.nombre as tipo',
            't.id_linea_inv',
            'l.nombre as linea',
            't.estado',
            't.director',
            'd.nombre as nombre_director',
            't.jurado',
            'j.nombre as nombre_jurado',
            'a.nombre as estudiante'
        ) //d.nombre as director','j.nombre as jurado')
            ->from('tesis as t')
            ->join('tipo_tesis as ti', function ($join) {
                $join->on('t.id_tipo_tesis', '=', 'ti.id');
            })
            ->join('linea_investigacion as l', function ($join) {
                $join->on('t.id_linea_inv', '=', 'l.id');
            })
            ->leftJoin('estudiante_tipo_certificacion as etc', function ($join) {
                $join->on('t.id', '=', 'etc.tesis_id');
            })
            ->leftJoin('estudiante as e', function ($join) {
                $join->on('etc.estudiante_id', '=', 'e.id');
            })
            ->leftJoin('persona as a', function ($join) {
                $join->on('e.cedula', '=', 'a.cedula');
            })
            ->leftJoin('persona as d', function ($join) {
                $join->on('t.director', '=', 'd.cedula');
            })
            ->leftJoin('persona as j', function ($join) {
                $join->on('t.jurado', '=', 'j.cedula');
            })->paginate(10);//(10);
        return view('tesis/index', compact('tesis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $lineas = LineaInvestigacion::get();
        $tipos = TipoTesis::get();
        $tesis = TipoTesis::get();
        $profesores = Profesor::select('p.cedula', 'per.nombre')
            ->from('profesor as p')
            ->join('persona as per', function ($join) {
                $join->on('p.cedula', '=', 'per.cedula');
            }) ->where('p.estado', '=', 1)->get();
        return view('tesis/create', compact(['lineas', 'tipos', 'profesores', 'tesis']));
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
        $datos = [
            'cod_biblioteca' => 'required|String|Max:10',
            'fecha' => 'required|date',
            'titulo' => 'required|String|max:200',
            'id_tipo_tesis' => 'required',
            'id_linea_inv' => 'required',
            'estado' => 'required|String|max:15',
            'director' => 'required'
        ];
        $Mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $datos, $Mensaje);
        $datostesis = request()->except('_token');
        Tesis::insert($datostesis);
        return redirect('tesis/')->with('Mensaje', 'Tesis agregada con exito');
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
        $lineas = LineaInvestigacion::get();
        $tipos = TipoTesis::get();
        $profesores = Profesor::select('p.cedula', 'per.nombre')
            ->from('profesor as p')
            ->join('persona as per', function ($join) {
                $join->on('p.cedula', '=', 'per.cedula');
            })
            ->where('p.estado', '=', 1)
            ->get();

        $tesis = Tesis::select(
            't.id',
            't.cod_biblioteca',
            't.fecha',
            't.titulo',
            't.id_tipo_tesis',
            'ti.nombre as tipo',
            't.id_linea_inv',
            'l.nombre as linea',
            't.estado',
            't.director',
            'd.nombre as nombre_director',
            't.jurado',
            'j.nombre as nombre_jurado',
        ) //d.nombre as director','j.nombre as jurado')
            ->from('tesis as t')
            ->join('tipo_tesis as ti', function ($join) {
                $join->on('t.id_tipo_tesis', '=', 'ti.id');
            })
            ->join('linea_investigacion as l', function ($join) {
                $join->on('t.id_linea_inv', '=', 'l.id');
            })
            ->leftJoin('persona as d', function ($join) {
                $join->on('t.director', '=', 'd.cedula');
            })
            ->leftJoin('persona as j', function ($join) {
                $join->on('t.jurado', '=', 'j.cedula');
            })->first();

        return view('tesis/edit', compact(['lineas', 'tipos', 'profesores', 'tesis']));
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
        $datos = [
            'cod_biblioteca' => 'required|String|Max:10',
            'fecha' => 'required|date',
            'titulo' => 'required|String|max:200',
            'id_tipo_tesis' => 'required',
            'id_linea_inv' => 'required',
            'estado' => 'required|String|max:15',
            'jurado' => 'required'
        ];
        $Mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $datos, $Mensaje);
        $datostesis = request()->except(['_token', '_method', 'director']);
        //dump($datostesis);
        //die();
        Tesis::where('id', '=', $id)->update($datostesis);
        return redirect('tesis/')->with('Mensaje', 'Tesis editada con exito');
    }

    public function viewAsignarEstudiante($id){
        $tesis = Tesis::find($id);
        return view('tesis/asignarestudiante', compact('tesis'));
    }

    public function asignarEstudianteUpdate(Request $request, $id){
        $datos =[
            'estudiante_tipo_certificacion' => 'required|integer|not_in:0'
        ];
        $Mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $datos, $Mensaje);
        $datostesis = request()->except(['_token', '_method', 'titulo', 'cod_biblioteca','buscar']);
        $est = DB::update('update estudiante_tipo_certificacion set tesis_id = ? where id = ?', [$id, $request->input('estudiante_tipo_certificacion')]);
        return redirect('tesis/')->with('Mensaje', 'estudiante asignado con exito');
       
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
        Tesis::destroy($id);
        return redirect('tesis/')->with('Mensaje', 'Tesis eliminada con exito');
    }
}
