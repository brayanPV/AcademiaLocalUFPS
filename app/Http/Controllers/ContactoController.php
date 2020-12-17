<?php

namespace App\Http\Controllers;

use App\Mail\MessageReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    //
    public function viewContacto(){
        return view('contacto/contac');
    }

    public function store(){
         $mensaje = request()->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email',
            'comentario' => 'required',
        ],[
            'nombre.required' => __('Necesito tu nombre'),
            
        ]);
        Mail::to('ciscoal@ufps.edu.co')->queue(new MessageReceived($mensaje));

        return redirect('contacto/contac')->with('Mensaje', 'Mensaje enviado con exito');
    }
}
