<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\TipoCertificacion;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        $tipoCertificacion =  TipoCertificacion::get();
        return view('estudiantes/create', compact('tipoCertificacion'));

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
        $mensajep = '';
        $datosPer= [
            'cedula' => 'required|unique:profesor',
            'nombre' => 'required|max:50|string',
            'direccion' => 'required|max:50',
            'telcel' => 'required|max:20',
            'cedula' => 'required',
            'cod_estudiante' => 'required',
            'id_cisco' => 'required',
            'id_tipo_certificacion' => 'required',
            'password' => 'required|string|max:20|confirmed',
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        if(Persona::where('cedula', $request->input('cedula'))->first() == null){
            $this->validate($request, $datosPer, $mensaje);
            $datosPersona = request()->except(['_token', '_method', 'updated_at', 'cod_estudiante', 'id_cisco', 'password', 'id_tipo_certificacion','password_confirmation']);
            Persona::insert($datosPersona);
        }else{
            $mensajep = ' esta persona ya existia en el sistema';
        }
        if(Estudiante::where('cedula', $request->input('cedula'))->first()!=null){
            return redirect('estudiantes/create')->with('Mensaje', 'Este profesor ya existe en el sistema, verfique sus datos');
        }
        $this->validate($request, $datosPer, $mensaje);
        $datosEstudiante = request()->except(['_token', '_method', 'updated_at', 'nombre','direccion', 'telfijo', 'telcel', 'password_confirmation', 'correo']);
        Estudiante::insert($datosEstudiante);
        User::insert(['cedula' => $request->input('cedula'), 'password' => Hash::make($request->input('password')), 'tipo' => 'estudiante']);
        return redirect('estudiantes/listestudiantes')->with('Mensaje', 'Estudiante agregado con exito'  .$mensajep);
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
