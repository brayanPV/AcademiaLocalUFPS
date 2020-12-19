<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cohorte;
use App\Models\TipoCertificacion;

class CohorteController extends Controller
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

    public function listCohorte()
    {

        $cohortes = Cohorte::select('c.id', 'c.id_cisco', 'c.nombre', 'c.fecha_inicio', 'c.fecha_fin', 'tc.nombre as tc_nombre')
            ->from('cohorte as c')
            ->join('tipo_certificacion as tc', function ($join) {
                $join->on('tc.id', '=', 'c.id_tipo_certificacion');
            })->paginate(10);

        return view('cohortes.listcohortes', compact('cohortes'));
    }

    public function buscarCohorte(Request $request)
    {
        $cohortes = Cohorte::select('c.id', 'c.id_cisco', 'c.nombre', 'c.fecha_inicio', 'c.fecha_fin', 'tc.nombre as tc_nombre')
            ->from('cohorte as c')
            ->join('tipo_certificacion as tc', function ($join) {
                $join->on('tc.id', '=', 'c.id_tipo_certificacion');
            })->where('c.nombre', 'like', '%' . $request->get('buscarCohorte') . '%')
            ->orWhere('c.id_cisco', 'like', '%' . $request->get('buscarCohorte') . '%')
            ->orWhere('tc.nombre', 'like', '%' . $request->get('buscarCohorte') . '%')->get();

        return json_encode($cohortes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $tipoCertificacion = TipoCertificacion::get();
        return view('cohortes.create', compact('tipoCertificacion'));
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
            'id_cisco' => 'required|unique:cohorte,id_cisco',
            'nombre' => 'required|unique:cohorte,nombre',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'id_tipo_certificacion' => 'required'
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $campos, $mensaje);
        $datosCohorte = request()->except(['_token', '_method', 'updated_at']);
        Cohorte::insert($datosCohorte);
        return redirect('cohortes/listcohortes')->with('Mensaje', 'Cohorte agregado con exito');
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
        //$cohortes = Cohorte::findOrFail($id);
        $cohortes = Cohorte::select('c.id', 'c.id_cisco', 'c.nombre', 'c.fecha_inicio', 'c.fecha_fin', 'c.id_tipo_certificacion', 'tc.nombre as nombre_cer')
            ->from('cohorte as c')
            ->join('tipo_certificacion as tc', function ($join) {
                $join->on('c.id_tipo_certificacion', '=', 'tc.id');
            })->where('c.id', $id)->first();
        $tipoCertificacion = TipoCertificacion::get();

        return view('cohortes.edit', compact(['cohortes', 'tipoCertificacion']));
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
            'id_cisco' => 'required|unique:cohorte,id_cisco,' . $id,
            'nombre' => 'required|unique:cohorte,nombre,' . $id,
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required'
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $campos, $mensaje);
        $datosCohorte = request()->except(['_token', '_method', 'updated_at']);
        Cohorte::where('id', '=', $id)->update($datosCohorte);
        return redirect('cohortes/listcohortes')->with('Mensaje', 'Cohorte editado con exito');
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
        Cohorte::destroy($id);
        return redirect('cohortes/listcohortes')->with('Mensaje', 'Cohorte eliminado con exito');
    }
}
