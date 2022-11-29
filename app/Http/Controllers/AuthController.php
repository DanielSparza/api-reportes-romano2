<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Persona;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh', 'clientRegister']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $username = request(['usuario']);

        if ($this->isEmail($username)) {
            $password = request(['password']);
            $credentials = ['email' => $username['usuario'], 'password' => $password['password']];
        } else {
            $credentials = request(['usuario', 'password']);
        }

        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'error' => 'Credenciales incorrectas, verifique sus datos de acceso.',
                'success' => false
            ], 401);
        }

        //return json_encode($token, $)
        return $this->respondWithToken($token);
    }

    public function isEmail($value)
    {
        $validator = Validator::make($value, [
            'usuario' => ['email:rfc,dns']
        ]);

        if ($validator->fails()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function clientRegister(Request $request)
    {
        if ($request->bearerToken() == config('app.app_id_key')) {
            $validator = Validator::make($request->all(), [
                'numero_de_cliente' => ['required', 'numeric', 'integer', 'exists:clientes,fk_clave_persona', 'unique:App\Models\User,fk_clave_persona'],
                'nombre_del_titular' => [
                    'required', 'max:100',
                    Rule::exists('personas', 'nombre')
                        ->where('clave_persona', $request->numero_de_cliente),
                ],
                'nombre_de_usuario' => ['required', 'min:5', 'max:20', 'unique:App\Models\User,usuario,'],
                'email' => ['required', 'email:rfc,dns', 'unique:App\Models\User,email,'],
                'password' => ['required', 'min:8', 'max:100', 'confirmed']
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $usuarioEstatus = Persona::select(
                'personas.estatus'
            )->where('personas.clave_persona', '=', $request->numero_de_cliente)->get();
    
            if ($usuarioEstatus[0]->estatus == 0){
                return response()->json([
                    'error' => ['Cliente inactivo. No fue posible realizar el registro, comuniquese a atención al cliente.']
                ], 400);
            }

            $usuario = new User();
            $usuario->fk_clave_persona = $request->numero_de_cliente;
            $usuario->usuario = $request->nombre_de_usuario;
            $usuario->email = $request->email;
            $usuario->fk_rol = $request->fk_rol;
            $usuario->password = bcrypt($request->password);

            $usuario->save();

            return response()->json([
                'message' => 'Te has registrado correctamente. Inicia sesión con tus datos de usuario.'
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Acceso denegado.'
            ], 401);
        }
    }
}
