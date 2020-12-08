<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\TipoCertificacion;
use App\Models\Inscrito;
use App\Models\Persona;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

    public function listInscritos()
    {
        $inscritos = Inscrito::select('i.cedula', 'p.nombre', 'i.semestre', 'tc.nombre as nombre_certificacion', 'p.correo', 'p.telcel', 'p.telfijo', 'p.direccion', 'i.recibo_pago_inscripcion')
            ->from('inscrito as i')
            ->join('persona as p', function ($join) {
                $join->on('i.cedula', '=', 'p.cedula');
            })
            ->join('tipo_certificacion as tc', function ($join) {
                $join->on('i.certificacion', '=', 'tc.id');
            })
            ->where('i.estado', '=', 'INSCRITO')->paginate(10);

        return view('inscritos/listinscritos', compact('inscritos'));
    }


    public function viewUpload($id)
    {
        $inscritos = Inscrito::select('i.cedula', 'p.nombre', 'i.semestre', 'tc.nombre as nombre_certificacion', 'p.correo', 'p.telcel', 'p.telfijo', 'p.direccion', 'i.recibo_pago_inscripcion')
            ->from('inscrito as i')
            ->join('persona as p', function ($join) use ($id) {
                $join->on('i.cedula', '=', 'p.cedula')
                    ->where('i.cedula', $id);
            })
            ->join('tipo_certificacion as tc', function ($join) {
                $join->on('i.certificacion', '=', 'tc.id');
            })->first();
        //$visibility = Storage::disk('upload')->getVisibility($inscritos->recibo_pago_inscripcion);    
        return view('inscritos/uploadrecibo', compact('inscritos'));
    }

    public function upload(Request $request, $id)
    {
        $datos = [
            'recibo_pago_inscripcion' => 'required|max:10000|mimes:jpeg,png,jpg'
        ];
        $Mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $datos, $Mensaje);
        $datos = request()->except(['_token', '_method', 'nombre', 'direccion', 'telfijo', 'telcel', 'correo', 'semestre', 'certificacion']);
        if ($request->hasFile('recibo_pago_inscripcion')) {
            $name = $request->file('recibo_pago_inscripcion')->getClientOriginalName();
            $datos['recibo_pago_inscripcion'] = $request->file('recibo_pago_inscripcion')->storeAs('recibo', $name, 'upload');
        }
        Inscrito::where('cedula', $id)->update($datos);
        return redirect('inscritos/listinscritos')->with('Mensaje', 'Se ha subido el recibo de pago con exito');
    }

    public function viewMatricular($id)
    {
        $inscritos = Inscrito::select(
            'i.cedula',
            'p.nombre',
            'i.semestre',
            'tc.nombre as nombre_certificacion',
            'p.correo',
            'p.telcel',
            'p.telfijo',
            'p.direccion',
            'i.recibo_pago_inscripcion',
            'tc.id'
        )
            ->from('inscrito as i')
            ->join('persona as p', function ($join) use ($id) {
                $join->on('i.cedula', '=', 'p.cedula')
                    ->where('i.cedula', $id);
            })
            ->join('tipo_certificacion as tc', function ($join) {
                $join->on('i.certificacion', '=', 'tc.id');
            })->first();
        $certificaciones = TipoCertificacion::get();
        return view('inscritos/matricular', compact(['inscritos', 'certificaciones']));
    }

    public function matricular(Request $request)
    {
        //'recibo_pago_inscripcion' => 'required|max:10000|mimes:jpeg,png,jpg',
        $user = Inscrito::where([['cedula', $request->input('cedula')], ['certificacion', $request->input('id_tipo_certificacion')]])->first();
        if ($user->recibo_pago_inscripcion == null) {
            $datos = [
                'recibo_pago_inscripcion' => 'required|max:10000|mimes:jpeg,png,jpg',
                'cedula' => 'required',
                'nombre' => 'required',
                'id_tipo_certificacion' => 'required',
                'id_cisco' => 'required'
            ];
            $mensaje = ["required" => 'El :attribute es requerido'];
            $this->validate($request, $datos, $mensaje);
            $datosmatricula = request()->except(['_token',  'updated_at', 'nombre']);
            if ($request->hasFile('recibo_pago_inscripcion')) {
                $name = $request->file('recibo_pago_inscripcion')->getClientOriginalName();
                $reciboInscripcion = $request->file('recibo_pago_inscripcion')->storeAs('recibo', $name, 'upload');
            }
        } else {
            $datos = [
                'cedula' => 'required',
                'nombre' => 'required',
                'id_tipo_certificacion' => 'required',
                'id_cisco' => 'required'
            ];
            $mensaje = ["required" => 'El :attribute es requerido'];
            $this->validate($request, $datos, $mensaje);
            $datosmatricula = request()->except(['_token',  'updated_at', 'nombre', 'recibo_pago_inscripcion']);
            $reciboInscripcion =$request->input('recibo_pago_inscripcion');
        }

        if (Estudiante::where('cedula', $request->input('cedula'))->first() ==  null) {
            $datosmatricula['password'] = $request->input('cedula');
            Estudiante::insert($datosmatricula);
            $est = Estudiante::where('cedula', $request->input('cedula'))->first();
            $e = Estudiante::find($est->id);
            $e->certificaciones()->attach($request->input('id_tipo_certificacion'), ['recibo_pago_inscripcion' => $reciboInscripcion]);
            User::insert(['cedula' => $request->input('cedula'), 'password' => Hash::make($request->input('cedula'))]);
            $user = User::where('cedula', $request->input('cedula'))->firstOrFail();
            $user->roles()->sync(Role::where('nombre', 'estudiante')->first());
        } else {
            $est = Estudiante::where('cedula', $request->input('cedula'))->first();
            $e = Estudiante::find($est->id);
            $e->certificaciones()->attach($request->input('id_tipo_certificacion'), ['recibo_pago_inscripcion' => $request->input('recibo_pago_inscripcion')]);
        }
        Inscrito::where('cedula', $request->input('cedula'))->delete();

        return redirect('inscritos/listinscritos')->with('Mensaje', 'Se ha matriculado con exito');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $certificaciones = TipoCertificacion::get();
        return view('inscritos/create', compact('certificaciones'));
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
        $mensajep = "";
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
        $est = "INSCRITO";
        Inscrito::where('cedula', $request->input('cedula'))->update(['estado' => $est]);

        return redirect('inscritos/listinscritos')->with('Mensaje', 'Se ha registrado con exito');
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
