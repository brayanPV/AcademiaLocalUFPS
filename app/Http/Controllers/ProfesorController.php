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
        $profesores = Profesor::select('p.cedula', 'p.cod_profesor', 'p.id_cisco', 'per.nombre', 'per.correo', 'per.telfijo', 'per.telcel', 'per.direccion', 'p.estado')
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
        $mensajep = '';
        $datosPer= [
            'cedula' => 'required|unique:profesor',
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
        if(Persona::where('cedula', $request->input('cedula'))->first() == null){
            $this->validate($request, $datosPer, $mensaje);
            $datosPersona = request()->except(['_token', '_method', 'updated_at', 'cod_profesor', 'id_cisco', 'password', 'password_confirmation']);
            Persona::insert($datosPersona);
        }else{
            $mensajep = ' esta persona ya existia en el sistema';
        }
        if(Profesor::where('cedula', $request->input('cedula'))->first()!=null){
            return redirect('profesores/create')->with('Mensaje', 'Este profesor ya existe en el sistema, verfique sus datos');
        }
        $this->validate($request, $datosPer, $mensaje);
        $datosProfesor = request()->except(['_token', '_method', 'updated_at', 'nombre','direccion', 'telfijo', 'telcel', 'password_confirmation', 'correo']);
        Profesor::insert($datosProfesor);
        return redirect('profesores/listprofesores')->with('Mensaje', 'Profesor agregado con exito'  .$mensajep);
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
       /* $profesores = Profesor::select('p.cedula', 'p.cod_profesor', 'p.id_cisco', 'per.nombre', 'per.correo', 'per.telfijo', 'per.telcel', 'per.direccion')
        ->from('profesor as p')
        -where('cedula, $id)
        ->join('persona as per', function ($join) {
            $join->on('p.cedula', '=', 'per.cedula');
    
        })->get();
*/
        $profesores = Profesor::where('cedula', $id)->first();
        $personas = Persona::where('cedula', $id)   ->first();
        return view('profesores/edit', compact(['profesores' ,'personas']));
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
    public function destroy(Request $request, $id)
    {
        //
        $est = $request->input('estado');
        var_dump($est);
        Profesor::where('cedula',  $id)->update(['estado'=> $est]);
        $mensaje = ($est==0? 'Profesor activado con exito' : 'Profesor desactivado con exito');
        return redirect('profesores/listprofesores')->with('Mensaje', $mensaje);
    }
}
