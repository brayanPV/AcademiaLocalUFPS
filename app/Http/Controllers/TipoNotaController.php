<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoNota;
use App\Models\TipoCertificacion;

class TipoNotaController extends Controller
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

    public function listTipoNotas()
    {
            $tipoNotas = TipoNota::select('t.id','t.nombre', 'tc.id as idcerti', 'tc.nombre as tc_nombre')
            ->from('tipo_nota as t')
            ->join('tipo_certificacion as tc', function ($join) {
                $join->on('tc.id', '=', 't.id_tipo_certificacion');
            })->orderBy('id','asc')->paginate(10);
        return view('tiponotas.listtiponotas', compact('tipoNotas'));
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
        $tipoNota = TipoNota::get();

        return view('tiponotas.create', compact(['tipoCertificacion', 'tipoNota']));
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
            'nombre' => 'required',
            'id_tipo_certificacion' => 'required'
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $campos, $mensaje);
        $datostiponota = request()->except('_token');
        TipoNota::insert($datostiponota);
        return redirect('tiponotas/listtiponotas')->with('Mensaje', 'Se ha registrado con exito');
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
        $tipoCertificacion = TipoCertificacion::get();
        $tipoNota = TipoNota::findOrFail($id);
         return view('tiponotas.edit', compact(['tipoCertificacion', 'tipoNota']));
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
            'nombre' => 'required',
            'id_tipo_certificacion' => 'required'
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $campos, $mensaje);
        $datostiponota = request()->except(['_token', '_method', 'updated_at']);
        TipoNota::where('id', '=', $id)->update($datostiponota);
        return redirect('tiponotas/listtiponotas')->with('Mensaje', 'Se ha editado con exito');
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
        TipoNota::destroy($id);
        return redirect('tiponotas/listtiponotas')->with('Mensaje', 'Eliminada con exito');
    }
}
