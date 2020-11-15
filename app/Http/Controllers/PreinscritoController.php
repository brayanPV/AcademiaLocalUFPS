<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoCertificacion;
use App\Models\Inscrito;
use App\Models\Persona;

class PreinscritoController extends Controller
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

    public function listPreinscritos()
    {
        $preinscritos = Inscrito::select('i.cedula', 'p.nombre', 'i.semestre', 'tc.nombre as nombre_certificacion', 'p.correo', 'p.telcel', 'p.telfijo', 'p.direccion')
            ->from('inscrito as i')
            ->join('persona as p', function ($join) {
                $join->on('i.cedula', '=', 'p.cedula');
            })
            ->join('tipo_certificacion as tc', function ($join) {
                $join->on('i.certificacion', '=', 'tc.id');
            })
            ->where('i.estado', '=', 'PRE-INSCRITO')->paginate(10);

        return view('preinscripcion/listpreinscripcion', compact('preinscritos'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $certificaciones = TipoCertificacion::get();
        return view('preinscripcion/create', compact('certificaciones'));
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
            'cedula' => 'required',
            'nombre' => 'required',
            'direccion' => 'required',
            'telfijo' => 'required',
            'telcel' => 'required',
            'correo' => 'required',
            'semestre' => 'required',
            'certificacion' => 'required'
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        if (Persona::where('cedula', $request->input('cedula'))->first() == null) {
            $this->validate($request, $datos, $mensaje);
            $datosPersona = request()->except(['_token', '_method', 'updated_at', 'certificacion', 'semestre']);
            Persona::insert($datosPersona);
        } else {
            $mensajep = ' esta persona ya existia en el sistema';
        }

        $this->validate($request, $datos, $mensaje);
        $datosInscrito = request()->except(['_token', '_method', 'updated_at', 'nombre', 'correo', 'direccion', 'telfijo', 'telcel']);
        Inscrito::insert($datosInscrito);
        return redirect('/')->with('Mensaje', 'Se ha registrado con exito' . $mensajep);
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
        $preinscritos = Inscrito::select('i.cedula', 'p.nombre', 'i.semestre', 'tc.nombre as nombre_certificacion', 'p.correo', 'p.telcel', 'p.telfijo', 'p.direccion')
            ->from('inscrito as i')
            ->join('persona as p', function ($join) use ($id) {
                $join->on('i.cedula', '=', 'p.cedula')
                    ->where('i.cedula', $id);
            })
            ->join('tipo_certificacion as tc', function ($join) {
                $join->on('i.certificacion', '=', 'tc.id');
            })->first();

        $certificaciones = TipoCertificacion::get();
        return view('preinscripcion/edit', compact(['preinscritos', 'certificaciones']));
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
            'nombre' => 'required',
            'direccion' => 'required',
            'telfijo' => 'required',
            'telcel' => 'required',
            'correo' => 'required',
            'semestre' => 'required',
            'certificacion' => 'required'
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $datos, $mensaje);
        $datosPersona = request()->except(['_token', '_method', 'updated_at', 'certificacion', 'semestre', 'cedula']);
        Persona::where('cedula', $request->input('cedula'))->update($datosPersona);
        $datosInscrito = request()->except(['_token', '_method', 'updated_at', 'nombre', 'correo', 'direccion', 'telfijo', 'telcel', 'cedula']);
        Inscrito::where('cedula', $request->input('cedula'))->update($datosInscrito);
        return redirect('preinscripcion/listpreinscripcion')->with('Mensaje', 'Se ha editado con exito');
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
