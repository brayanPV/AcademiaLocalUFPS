<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Persona;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdministradorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$results = DB::select('select * from users where id = :id', ['id' => 1]);
        $administradores = DB::select('select u.id, u.cedula, p.nombre, p.telfijo, p.telcel, p.correo, p.direccion
        from role_user ru
        inner join users u
        on u.id = ru.user_id
        inner join roles r
        on r.id = ru.role_id
        and r.nombre = ?
        inner join persona p
        on u.cedula = p.cedula', ['administrador']);
        return view('administradores/listadministradores', compact('administradores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('administradores/create');
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
        $datosPer = [
            'cedula' => 'required|unique:users',
            'nombre' => 'required|max:50|string',
            'direccion' => 'required|max:50',
            'telcel' => 'required|max:20',
            'correo' => 'required',
            'password' => 'required|string|max:20|confirmed',
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        if (Persona::where('cedula', $request->input('cedula'))->first() == null) {
            $this->validate($request, $datosPer, $mensaje);
            $datosPersona = request()->except(['_token', '_method', 'updated_at', 'password', 'password_confirmation']);
            Persona::insert($datosPersona);
        } else {
            $mensajep = ' esta persona ya existia en el sistema';
        }
        if (User::where('cedula', $request->input('cedula'))->first() != null) {
            return redirect('administradores/create')->with('Mensaje', 'Este administrador ya existe en el sistema, verfique sus datos');
        }
        $this->validate($request, $datosPer, $mensaje);
        $datosAdmin = request()->except(['_token', '_method', 'updated_at', 'nombre', 'direccion', 'telfijo', 'telcel', 'password_confirmation', 'correo']);
        User::insert(['cedula' => $request->input('cedula'), 'password' => Hash::make($request->input('password'))]);
        $user = User::where('cedula', $request->input('cedula'))->firstOrFail();
        $user->roles()->sync([1,2,3]);
        return redirect('administradores/')->with('Mensaje', 'Administrador agregado con exito'  . $mensajep);
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
        $administradores = User::findOrFail($id);
        return view('administradores/edit', compact('administradores'));
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
        User::destroy($id);
        return redirect('administradores/')->with('Mensaje', 'Administrador eliminado con exito');
    }
}
