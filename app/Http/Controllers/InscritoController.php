<?php

namespace App\Http\Controllers;

use App\Models\TipoCertificacion;
use App\Models\Inscrito;
use App\Models\Persona;
use Illuminate\Http\Request;

class InscritoController extends Controller
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


    public function preInscribirView(){

        $certificaciones= TipoCertificacion::get();
        return view('preinscripcion.preinscripcion', compact('certificaciones'));
    }

    public function preInscribir(Request $request){
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $datos=[
            'cedula' => 'required',
            'nombre' => 'required',
            'direccion' => 'required',
            'telfijo'=> 'required',
            'telcel'=> 'required',
            'correo'=> 'required',
            'semestre'=> 'required',
            'certificacion'=> 'required'
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        if(Persona::where('cedula', $request->input('cedula'))->first() == null){
            $this->validate($request, $datos, $mensaje);
            $datosPersona = request()->except(['_token', '_method', 'updated_at', 'certificacion', 'semestre']);
            Persona::insert($datosPersona);
        }else{
            $mensajep = ' esta persona ya existia en el sistema';
        }
       
        $this->validate($request, $datos, $mensaje);
        $datosInscrito = request()->except(['_token', '_method', 'updated_at', 'nombre','correo','direccion', 'telfijo', 'telcel']);
        Inscrito::insert($datosInscrito);
        return redirect('/')->with('Mensaje', 'Se ha registrado con exito' .$mensajep);
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
    public function destroy($id)
    {
        //
    }
}
