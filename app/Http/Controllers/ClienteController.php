<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Persona;
use App\Models\Servicio;

class ClienteController extends Controller
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
        $clientes = Cliente::join('personas', 'clientes.fk_clave_persona', '=', 'personas.clave_persona')
            ->join('ciudades', 'personas.fk_ciudad', '=', 'ciudades.clave_ciudad')
            ->join('comunidades', 'clientes.fk_comunidad', '=', 'comunidades.clave_comunidad')
            ->join('servicios', 'clientes.fk_clave_persona', '=', 'servicios.fk_cliente')
            ->join('paquetesinternet', 'servicios.fk_paquete', '=', 'paquetesinternet.clave_paquete')
            ->select(
                'clientes.fk_clave_persona',
                'personas.nombre',
                'clientes.direccion',
                'clientes.nexterior',
                'clientes.ninterior',
                'clientes.colonia',
                'clientes.fk_comunidad',
                'comunidades.comunidad',
                'ciudades.ciudad',
                'personas.fk_ciudad',
                'clientes.estado',
                'clientes.telefono_fijo',
                'personas.telefono_movil',
                'personas.estatus',
                'paquetesinternet.velocidad',
                'servicios.clave_servicio',
                'servicios.fk_paquete',
                'servicios.latitud',
                'servicios.longitud',
                'servicios.foto_fachada',
            )->get();

        return response()->json($clientes);
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

        $cliente = new Cliente();
        $cliente->fk_clave_persona = $idpersona->clave_persona;
        $cliente->direccion = $request->direccion;
        $cliente->nexterior = $request->nexterior;
        $cliente->ninterior = $request->ninterior;
        $cliente->colonia = $request->colonia;
        $cliente->fk_comunidad = $request->fk_comunidad;
        $cliente->estado = $request->estado;
        $cliente->telefono_fijo = $request->telefono_fijo;

        $cliente->save();

        $servicio = new Servicio();
        $servicio->fk_paquete = $request->fk_paquete;
        $servicio->fk_cliente = $idpersona->clave_persona;
        $servicio->latitud = $request->latitud;
        $servicio->longitud = $request->longitud;
        $servicio->foto_fachada = $request->foto_fachada;

        $servicio->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showMiCuenta($clave_cliente)
    {
        //
        $miCuenta = Cliente::join('personas', 'clientes.fk_clave_persona', '=', 'personas.clave_persona')
            ->join('ciudades', 'personas.fk_ciudad', '=', 'ciudades.clave_ciudad')
            ->join('comunidades', 'clientes.fk_comunidad', '=', 'comunidades.clave_comunidad')
            ->join('servicios', 'clientes.fk_clave_persona', '=', 'servicios.fk_cliente')
            ->join('paquetesinternet', 'servicios.fk_paquete', '=', 'paquetesinternet.clave_paquete')
            ->select(
                'clientes.fk_clave_persona',
                'personas.nombre',
                'clientes.direccion',
                'clientes.nexterior',
                'clientes.colonia',
                'comunidades.comunidad',
                'ciudades.ciudad',
                'clientes.estado',
                'personas.estatus',
                'paquetesinternet.velocidad',
                'paquetesinternet.costo',
                'paquetesinternet.periodo',
                'servicios.clave_servicio'
            )->where('clientes.fk_clave_persona', '=', $clave_cliente)->get();

        return response()->json($miCuenta);
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

        $cliente = Cliente::find($request->clave_persona, 'fk_clave_persona');
        $cliente->direccion = $request->direccion;
        $cliente->nexterior = $request->nexterior;
        $cliente->ninterior = $request->ninterior;
        $cliente->colonia = $request->colonia;
        $cliente->fk_comunidad = $request->fk_comunidad;
        $cliente->estado = $request->estado;
        $cliente->telefono_fijo = $request->telefono_fijo;

        $cliente->save();

        $servicio = Servicio::find($request->clave_servicio, 'clave_servicio');
        $servicio->fk_paquete = $request->fk_paquete;
        $servicio->fk_cliente = $request->clave_persona;
        $servicio->latitud = $request->latitud;
        $servicio->longitud = $request->longitud;

        $foto = trim($request->foto_fachada);
        if ($foto != null && strlen($foto) > 0) {
            $servicio->foto_fachada = $request->foto_fachada; 
        }

        $servicio->save();
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
