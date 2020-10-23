<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;

class EstudianteController extends Controller
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

    public function listEstudiante(){
        $estudiantes = Estudiante::select('e.cedula', 'per.nombre','e.id_tipo_certificacion', 'c.nombre as nombre_certificacion' ,'per.correo', 'per.telcel', 'per.direccion', 'e.recibo_pago_inscripcion', 'e.recibo_pago_matricula')
            ->from('estudiante as e')
            ->join('tipo_certificacion as c', function($join){
                $join->on('e.id_tipo_certificacion', '=', 'c.id');
            })
            ->join('persona as per', function ($join) {
                $join->on('e.cedula', '=', 'per.cedula');
            })->paginate(5);

        return view('estudiantes/listestudiantes', compact('estudiantes'));
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
