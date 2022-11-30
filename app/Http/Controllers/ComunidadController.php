<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Comunidad;

class ComunidadController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $comunidades = Comunidad::join('ciudades', 'comunidades.fk_ciudad', '=', 'ciudades.clave_ciudad')
            ->select('comunidades.clave_comunidad', 'comunidades.comunidad', 'comunidades.fk_ciudad', 'ciudades.ciudad')->get();

        return response()->json($comunidades);
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
        $comunidad = new Comunidad();
        $comunidad->comunidad = $request->comunidad;
        $comunidad->fk_ciudad = $request->fk_ciudad;

        $comunidad->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($clave_ciudad)
    {
        //
        $comunidadesCiudad = Comunidad::where('comunidades.fk_ciudad', '=', $clave_ciudad)->get();
        return response()->json($comunidadesCiudad);
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
    public function update(Request $request)
    {
        //
        $comunidad = Comunidad::find($request->clave_comunidad, 'clave_comunidad');
        $comunidad->comunidad = $request->comunidad;
        $comunidad->fk_ciudad = $request->fk_ciudad;

        $comunidad->save();
        return $comunidad;
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
