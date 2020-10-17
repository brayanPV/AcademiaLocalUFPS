<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anuncio;
use Illuminate\Support\Facades\Storage;

class AnuncioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $anuncios = Anuncio::get(); //->where('tipo', 0)->sortBy('id');
        return view('anuncios.carouselanuncios', compact('anuncios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('anuncios.create');
    }

    public function AnunciosPrincipales()
    {
        $anuncios = Anuncio::paginate(5);
        return view('anuncios.listanuncio', compact('anuncios'));
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
        $campos = [
            'tipo' => 'required',
            'nombre' => 'required|string|max:100',
            'url' => 'required|url|max:200',
            'img1' => 'required|max:10000|mimes:jpeg,png,jpg'
        ];

        $Mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $campos, $Mensaje);

        $datosAnuncio = request()->except('_token');
        if ($request->hasFile('img1')) {
            $datosAnuncio['img1'] = $request->file('img1')->store('uploads', 'public');
        }
        Anuncio::insert($datosAnuncio);
        return redirect('anuncios.listanuncio')->with('Mensaje', 'Anuncio agregado con exito');
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
        $anuncio = Anuncio::findOrFail($id);
        return view('anuncios.edit', compact('anuncio'));
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
        $campos = [
            'tipo' => 'required',
            'nombre' => 'required|string|max:100',
            'url' => 'required|url|max:200'
        ];
        if ($request->hasFile('img1')) {
            $campos +=['img1' => 'required|max:10000|mimes:jpeg,png,jpg'];
        }
        $Mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $campos, $Mensaje);

        $datosAnuncio = request()->except(['_token', '_method', 'updated_at']);
        if ($request->hasFile('img1')) {
            $anuncio = Anuncio::findOrFail($id);
            Storage::delete('public/' . $anuncio->img1);
            $datosAnuncio['img1'] = $request->file('img1')->store('uploads', 'public');
        }

        Anuncio::where('id', '=', $id)->update($datosAnuncio);
        //$anuncio = Anuncio::findOrFail($id);
        //return view('anuncios.edit', compact('anuncio'));
        return redirect('anuncios.listanuncios')->with('Mensaje', 'Anuncio editado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $anuncio = Anuncio::findOrFail($id);
        if (Storage::delete('public/' . $anuncio->img1)) {
            Anuncio::destroy($id);
        }
        return redirect('anuncios')->with('Mensaje', 'Anuncio eliminado con exito');
    }
}
