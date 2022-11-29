<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rol;

class RolController extends Controller
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
        $roles = Rol::all()->where('rol', "!=", "Cliente");
        return response()->json($roles);
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
            $rol = new Rol();
            $rol->clave_rol = $request->clave_rol;
            $rol->rol = $request->rol;

            $rol->save();
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Acceso denegado.'
            ], 401);
        }
    }
}
