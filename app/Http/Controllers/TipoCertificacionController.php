<?php

namespace App\Http\Controllers;

use App\Models\TipoCertificacion;
use App\Models\Curso;
use App\Models\Anuncio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TipoCertificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $anuncios = Anuncio::select('*')
            ->from('anuncio')
            ->where('tipo', '=', 0)
            ->get();

        $certificaciones = TipoCertificacion::get();
        return view('welcome', compact(['certificaciones', 'anuncios']));
    }

    public function buscarCertificacion(Request $request)
    {
        $request->get('buscarCertificacion');
        $certificaciones = TipoCertificacion::select('tc.id', 'tc.nombre', 'tc.imagen', 'tc.descripcion')
            ->from('tipo_certificacion as tc')
            ->where('tc.nombre', 'like', '%' . $request->get('buscarCertificacion') . '%')
            ->orWhere('tc.descripcion', 'like', '%' . $request->get('buscarCertificacion') . '%')
            ->get();

        return json_encode($certificaciones);
    }

    public function listTipoCertificacion()
    {

        $certificaciones = TipoCertificacion::paginate(10);
        return view('certificaciones/listcertificaciones', compact('certificaciones'));
    }
    public function cardCertificacion()
    {

        $certificaciones = TipoCertificacion::get();
        return view('certificaciones/card', compact('certificaciones'));
    }

    public function carouselCertificacion()
    {
        $certificaciones = TipoCertificacion::get();
        return view('certificaciones/carouselcertificacion', compact('certificaciones'));
    }


    public function verCursos($id)
    {
        $certificacion = TipoCertificacion::findOrFail($id);
        $cursos = DB::table('cursos')
            ->select('c.id', 'c.id_cisco', 'm.nombre as nombre_modulo', 'p.cedula', 'per.nombre as nombreper', 'c.fecha_inicio', 'c.fecha_fin', 'co.nombre', 'tc.nombre as nombretc')
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
            })
            ->join('tipo_certificacion as tc', function ($join) use ($id) {
                $join->on('tc.id', '=', 'm.id_tipo_certificacion')
                    ->on('tc.id', '=', 'co.id_tipo_certificacion')
                    ->where('tc.id', $id);
            })->paginate(5);
        return view('certificaciones/vercurso', compact(['cursos', 'certificacion']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('certificaciones/create');
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
            'nombre' => 'required|unique:tipo_certificacion|String|max:50',
            'imagen' => 'required|max:10000|mimes:jpeg,png,jpg'
        ];
        $Mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $datos, $Mensaje);
        $datosCertificacion = request()->except('_token');
        if ($request->hasFile('imagen')) {
            $datosCertificacion['imagen'] = $request->file('imagen')->store('uploads', 'public');
        }
        TipoCertificacion::insert($datosCertificacion);
        return redirect('certificaciones/listcertificaciones')->with('Mensaje', 'Certificacion agregada con exito');
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
        $certificaciones = TipoCertificacion::findOrFail($id);
        return view('certificaciones/edit', compact('certificaciones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function update(Request $request, $id)
    {
        //'nombre' => 'required|unique:cohorte,nombre,'.$id,
        $datos = [
            'nombre' => 'required|String|max:50|unique:tipo_certificacion,nombre,' . $id
        ];
        if ($request->hasFile('imagen')) {
            $datos += ['imagen' => 'required|max:10000|mimes:jpeg,png,jpg'];
        }
        $Mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $datos, $Mensaje);
        $datosCertificacion = request()->except(['_token', '_method', 'updated_at']);
        if ($request->hasFile('imagen')) {
            $certificacion = TipoCertificacion::findOrFail($id);
            Storage::delete('public/' . $certificacion->imagen);
            $datosCertificacion['imagen'] = $request->file('imagen')->store('uploads', 'public');
        }
        TipoCertificacion::where('id', $id)->update($datosCertificacion);
        return redirect('certificaciones/listcertificaciones')->with('Mensaje', 'Certificacion editada con exito');
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
    }
}
