<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modulo;
use App\Models\TipoCertificacion;

class ModuloController extends Controller
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


    public function listModulo(){
        
        $modulos = Modulo::select('m.id', 'm.numero', 'm.nombre', 't.nombre as nombre_certificacion', 'm.url1', 'm.url2')
        ->from('modulo as m')
        ->join('tipo_certificacion as t', function($join){
            $join->on('t.id', '=', 'm.id_tipo_certificacion');
        })->paginate(10);
        return view('modulos/listmodulos', compact('modulos'));
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
        return view('modulos/create', compact('tipoCertificacion'));
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
            'numero' => 'required',
            'nombre' => 'required|unique:modulo,nombre',
            'id_tipo_certificacion' => 'required',
            'url1' => 'required',
            'url2' => 'required'
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $campos, $mensaje);
        $datosModulo = request()->except(['_token', '_method', 'updated_at']);
        Modulo::insert($datosModulo);
        return redirect('modulos/listmodulos')->with('Mensaje', 'Modulo agregado con exito');
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
        //$modulos = Modulo::findOrFail($id);
        $modulos = Modulo::select('m.id', 'm.numero', 'm.nombre as nombre', 'm.url1', 'm.url2', 'm.id_tipo_certificacion' ,'tc.nombre as tc_nombre')
        ->from('modulo as m')
        ->join('tipo_certificacion as tc', function($join){
            $join->on('m.id_tipo_certificacion', '=', 'tc.id');
        })->where('m.id', $id)->first();
        $tipoCertificacion = TipoCertificacion::get();

        return view('modulos.edit',compact(['modulos', 'tipoCertificacion']));
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
        $campos=[
            'numero' => 'required',
            'nombre' => 'required|unique:modulo,nombre,'.$id,
            'id_tipo_certificacion' => 'required',
            'url1' => 'required',
            'url2' => 'required'
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $campos, $mensaje);
        $datosModulo = request()->except(['_token', '_method', 'updated_at']);
        Modulo::where('id', '=', $id)->update($datosModulo);
        return redirect('modulos/listmodulos')->with('Mensaje', 'Modulo editado con exito');
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
        Modulo::destroy($id);
        return redirect('modulos/listmodulos')->with('Mensaje', 'Modulo eliminado con exito');
    }
}
