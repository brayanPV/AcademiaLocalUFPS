<?php

namespace App\Http\Controllers;

use App\Models\CursoEstudiante;
use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\TipoCertificacion;
use App\Models\Persona;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;
use App;
use Illuminate\Support\Facades\Mail;

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

    public function listEstudiante()
    {
        $estudiantes = Estudiante::select(
            'e.cedula',
            'e.id',
            'per.nombre',
            'c.id as tipo_certificacion_id',
            'c.nombre as nombre_certificacion',
            'per.correo',
            'per.telfijo',
            'e.estado',
            'e.id_cisco',
            'e.cod_estudiante',
            'per.telcel',
            'per.direccion',
            'ec.recibo_pago_inscripcion',
            'ec.recibo_pago_matricula',
            'ec.id as est_cer_id'
        )
            ->from('estudiante as e')
            ->join('persona as per', function ($join) {
                $join->on('e.cedula', '=', 'per.cedula');
            })->join('estudiante_tipo_certificacion as ec', function ($join) {
                $join->on('e.id', '=', 'ec.estudiante_id');
            })->join('tipo_certificacion as c', function ($join) {
                $join->on('ec.tipo_certificacion_id', '=', 'c.id');
            })->paginate(10);

        return view('estudiantes/listestudiantes', compact('estudiantes'));
    }

    public function buscarEstudiante(Request $request)
    {
        $estudiantes = Estudiante::select(
            'e.cedula',
            'e.id',
            'per.nombre',
            'e.estado',
            'c.id as tipo_certificacion_id',
            'c.nombre as nombre_certificacion',
            'per.correo',
            'per.telfijo',
            'e.id_cisco',
            'e.cod_estudiante',
            'per.telcel',
            'per.direccion',
            'etc.recibo_pago_inscripcion',
            'etc.recibo_pago_matricula',
            'etc.id as est_cer_id'
        )
            ->from('estudiante as e')
            ->join('persona as per', function ($join) {
                $join->on('e.cedula', '=', 'per.cedula');
            })->join('estudiante_tipo_certificacion as etc', function ($join) {
                $join->on('etc.estudiante_id', '=', 'e.id');
            })
            ->join('tipo_certificacion as c', function ($join) use ($request) {
                $join->on('etc.tipo_certificacion_id', '=', 'c.id')
                    ->where(function ($query) use ($request) {
                        if (is_numeric($request->get('buscarEstudiante'))) {
                            return $query->where('e.cedula', 'like', '%' . $request->get('buscarEstudiante') . '%');
                        } else {
                            return $query->where('per.nombre', 'like', '%' . $request->get('buscarEstudiante') . '%')
                                ->orWhere('per.correo', 'like', '%' . $request->get('buscarEstudiante') . '%')
                                ->orWhere('c.nombre', 'like', '%' . $request->get('buscarEstudiante') . '%');
                        }
                    });
            })->get();

        return json_encode($estudiantes);
    }


    public function viewUploadInscripcion($id)
    {
        $estudiantes = Estudiante::select('e.cedula', 'p.nombre', 'etc.recibo_pago_inscripcion', 'tc.nombre as certificacion', 'etc.id')
            ->from('estudiante as e')
            ->join('persona as p', function ($join) use ($id) {
                $join->on('e.cedula', '=', 'p.cedula')
                    ->where('e.cedula', $id);
            })
            ->join('estudiante_tipo_certificacion as etc', function ($join) {
                $join->on('e.id', '=', 'etc.estudiante_id');
            })
            ->join('tipo_certificacion as tc', function ($join) {
                $join->on('etc.tipo_certificacion_id', '=', 'tc.id');
            })->first();
        //$visibility = Storage::disk('upload')->getVisibility($inscritos->recibo_pago_inscripcion);    
        return view('estudiantes/uploadreciboinscripcion', compact('estudiantes'));
    }

    public function updateInscripcion(Request $request)
    {
        $datos = [
            'recibo_pago_inscripcion' => 'max:10000|mimes:jpeg,png,jpg'
        ];
        $Mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $datos, $Mensaje);
        $datosEst = request()->except(['_token', '_method', 'nombre', 'id', 'recibo_pago_matricula', 'tipo_certificacion_id']);
        //dump($request->hasFile('recibo_pago_inscripcion'));
        //die();
        if ($request->hasFile('recibo_pago_inscripcion')) {
            $est = DB::select('select * from estudiante_tipo_certificacion where id = ?', [$request->input('id')]);
            if ($est[0]->recibo_pago_inscripcion != null) {
                if (str_contains($est[0]->recibo_pago_inscripcion, "uploads/reciboinscripcion")) {
                    Storage::delete('public/' . $est[0]->recibo_pago_inscripcion);
                }
            }
            $name = $request->file('recibo_pago_inscripcion')->getClientOriginalName();
            $recibo = $request->file('recibo_pago_inscripcion')->storeAs('uploads/reciboinscripcion', $name, 'public');
        } else {
            $est = DB::select('select * from estudiante_tipo_certificacion where id = ?', [$request->input('id')]);
            if ($est[0]->recibo_pago_inscripcion != null) {
                if (str_contains($est[0]->recibo_pago_inscripcion, "uploads/reciboinscripcion")) {
                    Storage::delete('public/' . $est[0]->recibo_pago_inscripcion);
                }
            }
            $recibo = $request->input('recibo_pago_inscripcion');
        }

        DB::update('update estudiante_tipo_certificacion set recibo_pago_inscripcion = ? where id = ?', [$recibo, $request->input('id')]);

        return redirect('estudiantes/listestudiantes')->with('Mensaje', 'Se ha editado el recibo de inscripcion con exito');
    }

    public function updatematricula(Request $request)
    {
        $datos = [
            'recibo_pago_matricula' => 'max:10000|mimes:jpeg,png,jpg'
        ];
        $Mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $datos, $Mensaje);
        $datosEst = request()->except(['_token', '_method', 'nombre', 'id', 'recibo_pago_inscripcion', 'tipo_certificacion_id']);

        if ($request->hasFile('recibo_pago_matricula')) {
            $est = DB::select('select * from estudiante_tipo_certificacion where id = ?', [$request->input('id')]);
            if ($est[0]->recibo_pago_matricula != null) {
                if (str_contains($est[0]->recibo_pago_matricula, "uploads/recibomatricula")) {
                    Storage::delete('public/' . $est[0]->recibo_pago_matricula);
                }
            }
            $name = $request->file('recibo_pago_matricula')->getClientOriginalName();
            $recibo = $request->file('recibo_pago_matricula')->storeAs('uploads/recibomatricula', $name, 'public');
        } else {
            $est = DB::select('select * from estudiante_tipo_certificacion where id = ?', [$request->input('id')]);
            if ($est[0]->recibo_pago_matricula != null) {
                if (str_contains($est[0]->recibo_pago_matricula, "uploads/recibomatricula")) {
                    Storage::delete('public/' . $est[0]->recibo_pago_matricula);
                }
            }
            $recibo = $request->input('recibo_pago_matricula');
        }

        DB::update('update estudiante_tipo_certificacion set recibo_pago_matricula = ? where id = ?', [$recibo, $request->input('id')]);

        return redirect('estudiantes/listestudiantes')->with('Mensaje', 'Se ha editado el recibo de matricula con exito');
    }

    public function viewUploadMatricula($id)
    {
        $estudiantes = Estudiante::select('e.cedula', 'p.nombre', 'etc.recibo_pago_matricula', 'etc.id', 'tc.nombre as certificacion')
            ->from('estudiante as e')
            ->join('persona as p', function ($join) use ($id) {
                $join->on('e.cedula', '=', 'p.cedula')
                    ->where('e.cedula', $id);
            })
            ->join('estudiante_tipo_certificacion as etc', function ($join) {
                $join->on('e.id', '=', 'etc.estudiante_id');
            })
            ->join('tipo_certificacion as tc', function ($join) {
                $join->on('etc.tipo_certificacion_id', '=', 'tc.id');
            })->first();
        //$visibility = Storage::disk('upload')->getVisibility($inscritos->recibo_pago_inscripcion);    
        return view('estudiantes/uploadrecibomatricula', compact('estudiantes'));
    }

    public function verCertificaciones($id)
    {

        $estudiantes = Estudiante::select(
            't.nombre as nombre_cer',
            'etc.recibo_pago_inscripcion',
            'etc.recibo_pago_matricula',
            'etc.nota_final_modulo',
            'etc.nota_final_laboratorio',
            'etc.nota_sustentacion',
            'etc.nota_prueba',
            'etc.definitiva',
            'etc.certificado_final_notas'
        )
            ->from('estudiante as e')
            ->join('estudiante_tipo_certificacion as etc', function ($join) {
                $join->on('e.id', '=', 'etc.estudiante_id');
            })
            ->join('tipo_certificacion as t', function ($join) {
                $join->on('t.id', '=', 'etc.tipo_certificacion_id');
            })->where('e.cedula', '=', $id)->get();

        return view('estudiantes/miscertificaciones', compact('estudiantes'));
    }

    public function verNotasCertificacion($id_cer_est)
    {


        $est = DB::select("Select m.nombre as modulo, p.nombre as profesor, ce.valor, ce.laboratorio, tc.nombre as nombre_cer, e.cod_estudiante
        from curso_estudiante ce
        inner join estudiante e
        on ce.ced_estudiante = e.cedula
        inner join estudiante_tipo_certificacion etc
        on etc.estudiante_id = e.id
        and etc.id = ?
        inner join tipo_certificacion tc 
        on etc.tipo_certificacion_id = tc.id
        inner join modulo m 
        on tc.id = m.id_tipo_certificacion
        inner join curso c 
        on m.id = c.id_modulo
        and c.id = ce.id_curso
        inner join persona p
        on c.ced_profesor = p.cedula", [$id_cer_est]);

        $modulos = 0;
        $laboratorios = 0;
        $cont = 0;
        foreach ($est as $e) {
            $cont++;
            $modulos += $e->valor;
            $laboratorios += $e->laboratorio;
        }

        if ($cont == 0) {
            return redirect('estudiantes/listestudiantes')->with('Mensaje', "Este estudiante no tiene cursos matriculados, por favor agregar uno primero");
        }
        $notaM = $modulos / $cont;
        $notaL = $laboratorios / $cont;

        DB::update('update estudiante_tipo_certificacion set nota_final_modulo = ?, nota_final_laboratorio = ? where id = ?', [$notaM, $notaL, $id_cer_est]);
        $est_cer = DB::select('select * from estudiante_tipo_certificacion where id = ?', [$id_cer_est]);

        $estudiante =  DB::select('select p.nombre, etc.nota_final_modulo, etc.nota_final_laboratorio, etc.nota_prueba, etc.nota_sustentacion 
        from estudiante_tipo_certificacion etc
        inner join estudiante e 
        on etc.estudiante_id = e.id
        and etc.id = ?
        inner join persona p
        on e.cedula = p.cedula', [$id_cer_est]);
        if ($estudiante[0]->nota_prueba != null) {
            $definitiva = ($estudiante[0]->nota_final_modulo * 0.15) + ($estudiante[0]->nota_final_laboratorio * 0.15) + ($estudiante[0]->nota_prueba * 0.40) + ($estudiante[0]->nota_sustentacion * 0.30);
            $definitiva = number_format($definitiva, 1);
            DB::update('update estudiante_tipo_certificacion set definitiva = ? where id = ?', [$definitiva, $id_cer_est]);
        }
        return view('estudiantes/vernotascertificacion', compact(['est', 'est_cer', 'estudiante']));
    }

    public function verInformeFinal($id)
    {
        $est = Estudiante::select('p.nombre', 't.nombre as nombre_cer', 'e.cedula', 'etc.nota_final_modulo', 'etc.nota_final_laboratorio', 'etc.nota_prueba', 'etc.nota_sustentacion', 'etc.definitiva')
            ->from('estudiante as e')
            ->join('persona as p', function ($join) {
                $join->on('p.cedula', '=', 'e.cedula');
            })
            ->join('estudiante_tipo_certificacion as etc', function ($join) use ($id) {
                $join->on('etc.estudiante_id', '=', 'e.id')
                    ->where('etc.id', '=', $id);
            })
            ->join('tipo_certificacion as t', function ($join) {
                $join->on('etc.tipo_certificacion_id', '=', 't.id');
            })->first();

        return view('estudiantes/informe_nota_final', compact('est'));
    }

    public function crearPDF($id)
    {
        $est = Estudiante::select(
            'p.nombre',
            't.nombre as nombre_cer',
            'e.cedula',
            'etc.nota_final_modulo',
            'etc.nota_final_laboratorio',
            'etc.nota_prueba',
            'etc.nota_sustentacion',
            'etc.definitiva',
            'p.correo',
            'etc.id'
        )
            ->from('estudiante as e')
            ->join('persona as p', function ($join) {
                $join->on('p.cedula', '=', 'e.cedula');
            })
            ->join('estudiante_tipo_certificacion as etc', function ($join) use ($id) {
                $join->on('etc.estudiante_id', '=', 'e.id')
                    ->where('etc.id', '=', $id);
            })
            ->join('tipo_certificacion as t', function ($join) {
                $join->on('etc.tipo_certificacion_id', '=', 't.id');
            })->first();
        $data["nombre"] = $est->nombre;
        $data["nombre_cer"] = $est->nombre_cer;
        $data["cedula"] = $est->cedula;
        $data["nota_final_modulo"] = $est->nota_final_modulo;
        $data["nota_final_laboratorio"] = $est->nota_final_laboratorio;
        $data["nota_prueba"] = $est->nota_prueba;
        $data["nota_sustentacion"] = $est->nota_sustentacion;
        $data["definitiva"] = $est->definitiva;
        $data["email"] = $est->correo;
        $pdf = PDF::loadView('estudiantes/informe_nota_final', compact('est'));

        /*   Mail::send('etc.tipo_certificacion_id', $est, function ($message) use ($est, $pdf) {
            $message->to("brayanstivenpv@ufps.edu.co", "brayanstivenpv@ufps.edu.co")
                ->subject($est["nombre"])
                ->attachData($pdf->output(), "text.pdf");
        });*/

        Mail::send('estudiantes/enviarinforme', $data, function ($message) use ($data, $pdf) {
            $message->to('brayanstivenpv@ufps.edu.co', $data["email"])
                ->subject("infome final")
                ->attachData($pdf->output(), "informe final ".$data["nombre"] .".pdf");
        });

       // dd('Mail sent successfully');

       // return $pdf->stream();
        return redirect()->action([EstudianteController::class, 'verNotasCertificacion'], ['est_cert' => $est->id])->with('Mensaje', 'Email enviado con exito');
    }

    public function viewCertificadoFinal($id_cer_est)
    {

        $est = CursoEstudiante::select('m.nombre as modulo', 'p.nombre as estudiante', 'tc.nombre as nombre_cer', 'etc.id', 'etc.certificado_final_notas', 'e.cod_estudiante')
            ->from('curso_estudiante as ce')
            ->join('estudiante as e', function ($join) {
                $join->on('ce.ced_estudiante', '=', 'e.cedula');
            })
            ->join('estudiante_tipo_certificacion as etc', function ($join) use ($id_cer_est) {
                $join->on('etc.estudiante_id', '=', 'e.id')
                    ->where('etc.id', '=', $id_cer_est);
            })
            ->join('tipo_certificacion as tc', function ($join) {
                $join->on('etc.tipo_certificacion_id', '=', 'tc.id');
            })
            ->join('modulo as m', function ($join) {
                $join->on('tc.id', '=', 'm.id_tipo_certificacion');
            })
            ->join('curso as c', function ($join) {
                $join->on('m.id', '=', 'c.id_modulo');
            })
            ->join('persona as p', function ($join) {
                $join->on('e.cedula', '=', 'p.cedula');
            })->first();

        return view('estudiantes/subircertificadofinal', compact('est'));
    }

    public function updateCertificado(Request $request)
    {
        $datos = [
            'certificado_final_notas' => 'required|max:10000|mimes:pdf',
            'terminacion_materias' => 'required|max:10000|mimes:pdf'
        ];
        $Mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $datos, $Mensaje);
        $datos = request()->except(['_token', '_method', 'nombre', 'cedula', 'tipo_certificacion_id']);

        if ($request->hasFile('certificado_final_notas') && $request->hasFile('terminacion_materias')) {
            $est = DB::select('select * from estudiante_tipo_certificacion where id = ?', [$request->input('id')]);
            if ($est[0]->certificado_final_notas != null) {
                if (str_contains($est[0]->certificado_final_notas, "uploads/certificadofinal")) {
                    Storage::delete('public/' . $est[0]->certificado_final_notas);
                }
            }
            if ($est[0]->terminacion_materias != null) {
                if (str_contains($est[0]->terminacion_materias, "uploads/terminacionmaterias")) {
                    Storage::delete('public/' . $est[0]->terminacion_materias);
                }
            }


            $name = $request->file('certificado_final_notas')->getClientOriginalName();
            $certificado = $request->file('certificado_final_notas')->storeAs('uploads/certificadofinal', $name, 'public');
            $nombre = $request->file('terminacion_materias')->getClientOriginalName();
            $terminacion = $request->file('terminacion_materias')->storeAs('uploads/terminacionmaterias', $nombre, 'public');
        } else {
            $est = DB::select('select * from estudiante_tipo_certificacion where id = ?', [$request->input('id')]);
            if ($est[0]->certificado_final_notas != null) {
                if (str_contains($est[0]->certificado_final_notas, "uploads/certificadofinal")) {
                    Storage::delete('public/' . $est[0]->certificado_final_notas);
                }
            }
            if ($est[0]->terminacion_materias != null) {
                if (str_contains($est[0]->terminacion_materias, "uploads/terminacionmaterias")) {
                    Storage::delete('public/' . $est[0]->terminacion_materias);
                }
            }
            $certificado = $request->input('certificado_final_notas');
            $terminacion = $request->input('terminacion_materias');
        }

        //dump($certificado, $request->input('id'));
        //die();
        DB::update('update estudiante_tipo_certificacion set certificado_final_notas = ?, terminacion_materias = ? where id = ?', [$certificado, $terminacion, $request->input('id')]);
        return redirect()->action([EstudianteController::class, 'verNotasCertificacion'], ['est_cert' => $request->input('id')])->with('Mensaje', 'Documentos subidos con exito');
       // return $this->verNotasCertificacion($request->input('id'));
    }

    public function createNotaPrueba($id_cer_est)
    {
        $est_cer = DB::table('estudiante_tipo_certificacion')
            ->select('etc.nota_prueba', 'p.nombre as estudiante', 'tc.nombre as certificacion', 'etc.id', 'e.cod_estudiante')
            ->from('estudiante_tipo_certificacion as etc')
            ->join('estudiante as e', function ($join) {
                $join->on('etc.estudiante_id', '=', 'e.id');
            })
            ->join('persona as p', function ($join) {
                $join->on('e.cedula', '=', 'p.cedula');
            })
            ->join('tipo_certificacion as tc', function ($join) {
                $join->on('etc.tipo_certificacion_id', '=', 'tc.id');
            })
            ->where('etc.id', '=', $id_cer_est)->first();
        return view('estudiantes/subirnotaprueba', compact('est_cer'));
    }

    public function updateNotaPrueba(Request $request, $id_cer_est)
    {
        $dato = [
            'nota_prueba' => 'required|numeric|max:1000',
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $dato, $mensaje);

        $aux = DB::select('select * from estudiante_tipo_certificacion where id = ?', [$id_cer_est]);
        $estudiante = Estudiante::find($aux[0]->estudiante_id);
        $nota = $request->input('nota_prueba') / 10;
        if ($estudiante->cod_estudiante == null) {
            DB::update('update estudiante_tipo_certificacion set nota_prueba = ?, nota_sustentacion = ? where id = ?', [$nota, $nota, $id_cer_est]);
            return redirect()->action([EstudianteController::class, 'verNotasCertificacion'], ['est_cert' => $id_cer_est]);
        }

        if ($nota > 82.5) {
            DB::update('update estudiante_tipo_certificacion set nota_prueba = ?, nota_sustentacion = ? where id = ?', [$nota, $nota, $id_cer_est]);
        } else {
            DB::update('update estudiante_tipo_certificacion set nota_prueba = ?, nota_sustentacion = ? where id = ?', [$nota, 0, $id_cer_est]);
        }
        DB::update('update estudiante_tipo_certificacion set nota_prueba = ? where id = ?', [$request->input('nota_prueba'), $id_cer_est]);
        return redirect()->action([EstudianteController::class, 'verNotasCertificacion'], ['est_cert' => $id_cer_est]);
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


    public function verCursosAsignados($id)
    {
        $cursos = CursoEstudiante::select('m.nombre', 'tc.nombre as certificacion', 'm.url1', 'm.url2', 'c.id', 'ce.valor', 'ce.laboratorio', 'ce.certificado', 'ce.carta', 'e.cedula')
            ->from('curso_estudiante as ce')
            ->join('curso as c', function ($join) {
                $join->on('ce.id_curso', '=', 'c.id');
            })
            ->join('modulo as m', function ($join) {
                $join->on('c.id_modulo', '=', 'm.id');
            })
            ->join('tipo_certificacion as tc', function ($join) {
                $join->on('m.id_tipo_certificacion', '=', 'tc.id');
            })
            ->join('estudiante as e', function ($join) use ($id) {
                $join->on('ce.ced_estudiante', '=', 'e.cedula')
                    ->where('e.cedula', '=', $id);
            })->paginate(10)->sortBy('tc.id');

        return view('estudiantes/cursosasignados', compact('cursos'));
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
            'cedula' => 'required',
            'nombre' => 'required|max:50|string',
            'direccion' => 'required|max:50',
            'telcel' => 'required|max:20',
            'id_cisco' => 'required|unique:estudiante',
            'id_tipo_certificacion' => 'required',
            'cod_estudiante' => 'string',
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];
        $certificacion = $request->input('id_tipo_certificacion');
        if (Persona::where('cedula', $request->input('cedula'))->first() == null) {
            $this->validate($request, $datosPer, $mensaje);
            $datosPersona = request()->except(['_token', '_method', 'updated_at', 'cod_estudiante', 'id_cisco', 'id_tipo_certificacion']);
            Persona::insert($datosPersona);
        } else {
            $mensajep = ' esta persona ya existia en el sistema';
        }

        if (Estudiante::where('cedula', $request->input('cedula'))->first() != null) {
            $est = Estudiante::where('cedula', $request->input('cedula'))->first();
            $e = Estudiante::find($est->id);

            if ($e->hasCertificacion($certificacion)) {
                return redirect('estudiantes/create')->with('Mensaje', 'Este estudiante ya esta matriculado en esa certificacion, por favor verifique sus datos' . $est->hasCertificacion($certificacion)->nombre);
            } else {
                $e->certificaciones()->attach($certificacion);
                return redirect('estudiantes/listestudiantes')->with('Mensaje', 'Estudiante agregado con exito,'  . $mensajep);
            }
        } else {
            $this->validate($request, $datosPer, $mensaje);
            $datosEstudiante = request()->except(['_token', '_method', 'updated_at', 'nombre', 'direccion', 'telfijo', 'telcel', 'correo', 'id_tipo_certificacion']);
            Estudiante::insert($datosEstudiante);
            $est = Estudiante::where('cedula', $request->input('cedula'))->first();
            $e = Estudiante::find($est->id);
            $e->certificaciones()->attach($certificacion);
            User::insert(['cedula' => $request->input('cedula'), 'password' => Hash::make($request->input('cedula'))]);
            $user = User::where('cedula', $request->input('cedula'))->firstOrFail();
            $user->roles()->sync(Role::where('nombre', 'estudiante')->first());
            return redirect('estudiantes/listestudiantes')->with('Mensaje', 'Estudiante agregado con exito'  . $mensajep);
        }
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
        //Persona::where('cedula', $request->input('cedula'))->first()
        $estudiantes = Estudiante::where('cedula', $id)->first();
        $personas = Persona::where('cedula', $id)->first();
        $tipoCertificacion = TipoCertificacion::select('tc.id', 'tc.nombre')
            ->from('tipo_certificacion as tc')
            ->join('estudiante_tipo_certificacion as etc', function ($join) {
                $join->on('etc.tipo_certificacion_id', '=', 'tc.id');
            })
            ->join('estudiante as e', function ($join) use ($estudiantes) {
                $join->on('e.id', '=', 'etc.estudiante_id')
                    ->where('e.id', $estudiantes->id);
            })->first();
        return view('estudiantes/edit', compact(['estudiantes', 'personas', 'tipoCertificacion']));
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

        $mensajep = '';
        $datosPer = [
            'nombre' => 'required|max:50|string',
            'direccion' => 'required|max:50',
            'telcel' => 'required|max:20',
            'cedula' => 'required',
            'id_cisco' => 'required',
        ];
        $mensaje = ["required" => 'El :attribute es requerido'];

        $this->validate($request, $datosPer, $mensaje);
        $datosPersona = request()->except(['_token', '_method', 'updated_at', 'cod_estudiante', 'id_cisco', 'id_tipo_certificacion']);
        Persona::where('cedula', $id)->update($datosPersona);

        $this->validate($request, $datosPer, $mensaje);
        $datosEstudiante = request()->except(['_token', '_method', 'updated_at', 'nombre', 'direccion', 'telfijo', 'telcel', 'correo', 'id_cisco', 'id_tipo_certificacion']);
        Estudiante::where('cedula', $id)->update($datosEstudiante);
        return redirect('estudiantes/listestudiantes')->with('Mensaje', 'Estudiante editado con exito'  . $mensajep);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $estado = $request->input('estado');
        if ($estado == 0) {
            Estudiante::where('cedula', $id)->update(['estado' => $estado]);
            User::where('cedula', $id)->delete();
        } else {
            Estudiante::where('cedula', $id)->update(['estado' => $estado]);
            User::insert(['cedula' => $id, 'password' => Hash::make($id)]);
            $user = User::where('cedula', $id)->firstOrFail();
            $user->roles()->sync(Role::where('nombre', 'estudiante')->first());
        }

        $mensaje = ($estado == 0 ? ' Estudiante desactivado con exito' : ' Estudiante activado con exito');
        return redirect('estudiantes/listestudiantes')->with('Mensaje', $mensaje);
    }
}
