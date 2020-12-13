<?php

namespace App\Http\Controllers;

use App\Models\GrupoInvestigacion;
use App\Models\LineaInvestigacion;
use Illuminate\Http\Request;

class LineaInvestigacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$lineas = LineaInvestigacion::paginate();
        $lineas = LineaInvestigacion::select('l.id', 'l.nombre', 'l.descripcion', 'l.id_grupo_inv', 'g.id as id_gru_inv', 'g.nombre as grupo', 'p.nombre as profesor')
            ->from('linea_investigacion as l')
            ->join('grupo_investigacion as g', function ($join) {
                $join->on('l.id_grupo_inv', '=', 'g.id');
            })
            ->join('persona as p', function ($join) {
                $join->on('g.ced_prof_director', '=', 'p.cedula');
            })->paginate(10);

        return view('lineas/index', compact('lineas'));
    }


    public function buscarLinea(Request $request)
    {
        $lineas = LineaInvestigacion::select('l.id', 'l.nombre', 'l.descripcion', 'l.id_grupo_inv', 'g.id as id_gru_inv', 'g.nombre as grupo', 'p.nombre as profesor')
            ->from('linea_investigacion as l')
            ->join('grupo_investigacion as g', function ($join) {
                $join->on('l.id_grupo_inv', '=', 'g.id');
            })
            ->join('persona as p', function ($join) {
                $join->on('g.ced_prof_director', '=', 'p.cedula');
            })
            ->where(function ($query) use ($request) {
                return $query->where('p.nombre', 'like', '%' . $request->get('buscarLinea') . '%')
                    ->orWhere('l.nombre', 'like', '%' . $request->get('buscarLinea') . '%')
                    ->orWhere('l.descripcion', 'like', '%' . $request->get('buscarLinea') . '%');
            })->get();
        return json_encode($lineas);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $grupos = GrupoInvestigacion::get();
        $lineas = LineaInvestigacion::get();

        return view('lineas/create', compact(['grupos', 'lineas']));
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
            'nombre' => 'required|String|max:20',
            'descripcion' => 'required|String',
            'id_grupo_inv' => 'required',
        ];
        $Mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $datos, $Mensaje);
        $datosLinea = request()->except('_token');
        LineaInvestigacion::insert($datosLinea);
        return redirect('lineas/')->with('Mensaje', 'Linea de investigacion agregada con exito');
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
        $grupos = GrupoInvestigacion::get();
        $lineas = LineaInvestigacion::select('l.id', 'l.nombre', 'l.descripcion', 'g.nombre as grupo', 'g.id as grupo_id')
            ->from('linea_investigacion as l')
            ->join('grupo_investigacion as g', function ($join) {
                $join->on('l.id_grupo_inv', '=', 'g.id');
            })
            ->where('l.id', '=', $id)->first();

        return view('lineas/edit', compact(['grupos', 'lineas']));
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
            'nombre' => 'required|String|unique:linea_investigacion,id,' . $id,
            'descripcion' => 'required|String',
            'id_grupo_inv' => 'required'
        ];
        $Mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $datos, $Mensaje);
        $datosLinea = request()->except(['_token', '_method']);
        LineaInvestigacion::where('id', '=', $id)->update($datosLinea);
        return redirect('lineas/')->with('Mensaje', 'Linea de investigacion editada con exito');
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
        LineaInvestigacion::destroy($id);
        return redirect('lineas/')->with('Mensaje', 'Linea de investigacion eliminada con exito');
    }
}
