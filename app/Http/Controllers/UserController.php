<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Persona;

class UserController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api',  ['except' => ['validarAdmin', 'store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $usuarios = User::join('personas', 'usuarios.fk_clave_persona', '=', 'personas.clave_persona')
            ->join('ciudades', 'personas.fk_ciudad', '=', 'ciudades.clave_ciudad')
            ->join('roles', 'usuarios.fk_rol', '=', 'roles.clave_rol')
            ->select(
                'usuarios.fk_clave_persona',
                'personas.nombre',
                'ciudades.ciudad',
                'personas.fk_ciudad',
                'personas.telefono_movil',
                'usuarios.usuario',
                'usuarios.email',
                'roles.rol',
                'usuarios.fk_rol',
                'personas.estatus'
            )
            ->get();
            //->where('roles.rol', '!=', 'Cliente')

        return response()->json($usuarios);
    }

    public function validarActivo(Request $request)
    {
        //
        $usuarioEstatus = Persona::select(
            'personas.estatus'
        )->where('personas.clave_persona', '=', $request->clave_usuario)->get();

        return response()->json($usuarioEstatus);
    }

    public function validarAdmin(Request $request)
    {
        //
        if ($request->bearerToken() == config('app.app_id_key')) {
            $existeAdmin = User::where('fk_rol', '=', 1)->get();

            return response()->json($existeAdmin);
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
            $persona = new Persona();
            $persona->nombre = $request->nombre;
            $persona->fk_ciudad = $request->fk_ciudad;
            $persona->telefono_movil = $request->telefono_movil;
            $persona->estatus = $request->estatus;

            $persona->save();

            $obtener_idpersona = Persona::where('nombre', $request->nombre)
                ->where('fk_ciudad', $request->fk_ciudad)
                ->where('telefono_movil', $request->telefono_movil)
                ->where('estatus', $request->estatus)
                ->select('clave_persona')->get()->first();

            $idpersona = json_decode($obtener_idpersona);

            $usuario = new User();
            $usuario->fk_clave_persona = $idpersona->clave_persona;
            $usuario->usuario = $request->usuario;
            $usuario->email = $request->email;
            $usuario->fk_rol = $request->fk_rol;
            $usuario->password = $request->password;

            $usuario->save();
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
    public function update(Request $request)
    {
        //
        $persona = Persona::find($request->clave_persona, 'clave_persona');
        $persona->nombre = $request->nombre;
        $persona->fk_ciudad = $request->fk_ciudad;
        $persona->telefono_movil = $request->telefono_movil;
        $persona->estatus = $request->estatus;

        $persona->save();

        $usuario = User::find($request->clave_persona, 'fk_clave_persona');
        $usuario->usuario = $request->usuario;
        $usuario->email = $request->email;
        $usuario->fk_rol = $request->fk_rol;

        $psswd = trim($request->password);

        if ($psswd != null && strlen($psswd) >= 8) {
            $usuario->password = $request->password;
        }

        $usuario->save();
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
