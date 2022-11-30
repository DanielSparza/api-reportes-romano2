<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ciudad;
use App\Models\Comunidad;

class CiudadController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ciudades = Ciudad::all();
        return response()->json($ciudades);
    }

    public function indexComunidades(){
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
        //
        if ($request->bearerToken() == config('app.app_id_key')) {
            $ciudad = new Ciudad();
            $ciudad->ciudad = $request->ciudad;

            $ciudad->save();
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Acceso denegado.'
            ], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeComunidad(Request $request)
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
    public function showComunidades($clave_ciudad)
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
        $ciudad = Ciudad::find($request->clave_ciudad, 'clave_ciudad');
        $ciudad->ciudad = $request->ciudad;

        $ciudad->save();
        return $ciudad;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateComunidad(Request $request)
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
