<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profesor;
use App\Models\Persona;

class ProfesorController extends Controller
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


    public function listProfesor()
    {
        $profesores = Profesor::select('p.cedula', 'p.cod_profesor', 'p.id_cisco', 'per.nombre', 'per.correo', 'per.telfijo', 'per.telcel', 'per.direccion')
            ->from('profesor as p')
            ->join('persona as per', function ($join) {
                $join->on('p.cedula', '=', 'per.cedula');
            })->paginate(5);

        return view('profesores/listprofesores', compact('profesores'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('profesores/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //'password' => ['required', 'string', 'min:8', 'confirmed'],
        $datosPer= [
            'cedula' => 'required',
            'nombre' => 'required|max:50|string',
            'direccion' => 'required|max:50',
            'telfijo' => 'required|max:20',
            'telcel' => 'required|max:20',
            'cedula' => 'required',
            'cod_profesor' => 'required',
            'id_cisco' => 'required',
            'password' => 'required|string|max:20|confirmed',
        ];
        
        $mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $datosPer, $mensaje);
        $datosPersona = request()->except(['_token', '_method', 'updated_at', 'cod_profesor', 'id_cisco', 'password', 'password_confirmation']);
        $this->validate($request, $datosPer, $mensaje);
        $datosProfesor = request()->except(['_token', '_method', 'updated_at', 'nombre','direccion', 'telfijo', 'telcel', 'password_confirmation', 'correo']);
        Persona::insert($datosPersona);
        Profesor::insert($datosProfesor);
        return redirect('profesores/listprofesores')->with('Mensaje', 'Profesor agregado con exito');
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
        $profesores = Profesor::select('p.cedula', 'p.cod_profesor', 'p.id_cisco', 'per.nombre', 'per.correo', 'per.telfijo', 'per.telcel', 'per.direccion')
        ->from('profesor as p')
        ->where('p.cedula', '=', $id)
        ->join('persona as per', function ($join) {
            $join->on('p.cedula', '=', 'per.cedula');
        })->get();

        return view('profesores/edit', compact('profesores'));
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
        Profesor::where('cedula',  $id)->delete();
        return redirect('profesores/listprofesores')->with('Mensaje', 'Profesor eliminado con exito');
    }
}
