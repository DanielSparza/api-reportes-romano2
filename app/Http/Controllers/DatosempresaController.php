<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Datosempresa;

class DatosempresaController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->bearerToken() == config('app.app_id_key')) {
            $datos = Datosempresa::all();
            return response()->json($datos);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Acceso denegado.'
            ], 401);
        }
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
            $empresa = new Datosempresa();
            $empresa->nombre = $request->nombre;
            $empresa->logo = $request->logo;
            $empresa->imagen_fondo = $request->imagen_fondo;
            $empresa->sobre_nosotros = $request->sobre_nosotros;
            $empresa->direccion = $request->direccion;
            $empresa->ciudad = $request->ciudad;
            $empresa->telefono = $request->telefono;

            $empresa->save();
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Acceso denegado.'
            ], 401);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateCabecera(Request $request)
    {
        //
        $cabecera = Datosempresa::find($request->clave_empresa, 'clave_empresa');
        $cabecera->nombre = $request->nombre;
        $cabecera->eslogan = $request->eslogan;

        $imagen = trim($request->imagen_fondo);
        if ($imagen != null && strlen($imagen) > 0) {
            $cabecera->imagen_fondo = $request->imagen_fondo;
        }

        $cabecera->save();
    }

    public function updateNosotros(Request $request)
    {
        //
        $nosotros = Datosempresa::find($request->clave_empresa, 'clave_empresa');
        $nosotros->sobre_nosotros = $request->sobre_nosotros;

        $nosotros->save();
    }

    public function updateContacto(Request $request)
    {
        //
        $contacto = Datosempresa::find($request->clave_empresa, 'clave_empresa');
        $contacto->direccion = $request->direccion;
        $contacto->ciudad = $request->ciudad;
        $contacto->telefono = $request->telefono;
        $contacto->correo = $request->correo;
        $contacto->facebook = $request->facebook;
        $contacto->whatsapp = $request->whatsapp;

        $contacto->save();
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
