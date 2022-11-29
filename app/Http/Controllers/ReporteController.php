<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reporte;
use App\Models\Persona;

class ReporteController extends Controller
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
        $reportes = Reporte::join('servicios', 'reportes.fk_servicio', '=', 'servicios.clave_servicio')
            ->join('clientes', 'servicios.fk_cliente', '=', 'clientes.fk_clave_persona')
            ->join('comunidades', 'clientes.fk_comunidad', '=', 'comunidades.clave_comunidad')
            ->join('ciudades as ciudad_cliente', 'comunidades.fk_ciudad', '=', 'ciudad_cliente.clave_ciudad')
            ->join('personas as nombre_cliente', 'clientes.fk_clave_persona', '=', 'nombre_cliente.clave_persona')
            ->select(
                'reportes.clave_reporte',
                'reportes.problema',
                'reportes.veces_reportado',
                'reportes.fecha_reporte',
                'comunidades.comunidad',
                'ciudad_cliente.ciudad'
            )->where('reportes.estatus', '=', 'Pendiente')
            ->orderBy('reportes.veces_reportado', 'DESC')
            ->orderBy('reportes.fecha_reporte', 'ASC')
            ->get();

        return response()->json($reportes);
    }

    public function misReportes($claveUsuario)
    {
        //
        $reportes = Reporte::join('servicios', 'reportes.fk_servicio', '=', 'servicios.clave_servicio')
            ->join('clientes', 'servicios.fk_cliente', '=', 'clientes.fk_clave_persona')
            ->join('comunidades', 'clientes.fk_comunidad', '=', 'comunidades.clave_comunidad')
            ->join('ciudades as ciudad_cliente', 'comunidades.fk_ciudad', '=', 'ciudad_cliente.clave_ciudad')
            ->join('personas as nombre_cliente', 'clientes.fk_clave_persona', '=', 'nombre_cliente.clave_persona')
            ->select(
                'reportes.clave_reporte',
                'reportes.problema',
                'reportes.estatus',
                'reportes.fecha_reporte',
                'reportes.fecha_finalizacion',
                'comunidades.comunidad',
                'ciudad_cliente.ciudad'
            )->where('reportes.fk_tecnico', '=', $claveUsuario)
            ->orderBy('reportes.fecha_reporte', 'DESC')
            ->get();

        return response()->json($reportes);
    }

    public function misReportesFilter($claveUsuario, $estatus, $comunidad, $fechaFiltro)
    {
        //
        $reportes = Reporte::join('servicios', 'reportes.fk_servicio', '=', 'servicios.clave_servicio')
            ->join('clientes', 'servicios.fk_cliente', '=', 'clientes.fk_clave_persona')
            ->join('comunidades', 'clientes.fk_comunidad', '=', 'comunidades.clave_comunidad')
            ->join('ciudades as ciudad_cliente', 'comunidades.fk_ciudad', '=', 'ciudad_cliente.clave_ciudad')
            ->join('personas as nombre_cliente', 'clientes.fk_clave_persona', '=', 'nombre_cliente.clave_persona')
            ->select(
                'reportes.clave_reporte',
                'reportes.problema',
                'reportes.estatus',
                'reportes.fecha_reporte',
                'reportes.fecha_finalizacion',
                'comunidades.comunidad',
                'ciudad_cliente.ciudad'
            )->where('reportes.fk_tecnico', '=', $claveUsuario)
            ->where('reportes.estatus', 'LIKE', '%' . $estatus . '%')
            ->where('comunidades.clave_comunidad', '=', $comunidad)
            ->where('reportes.fecha_reporte', '=', $fechaFiltro)
            ->orderBy('reportes.fecha_reporte', 'DESC')
            ->get();

        return response()->json($reportes);
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
        $obtener_nombrePersona = Persona::where('clave_persona', $request->reporto)
            ->select('nombre')->get()->first();

        $nombrePersona = json_decode($obtener_nombrePersona);

        $reporte = new Reporte();
        $reporte->fk_servicio = $request->fk_servicio;
        $reporte->problema = $request->problema;
        $reporte->veces_reportado = $request->veces_reportado;
        $reporte->reporto = $nombrePersona->nombre;
        $reporte->fecha_reporte = $request->fecha_reporte;
        $reporte->hora_reporte = $request->hora_reporte;
        $reporte->estatus = $request->estatus;

        $reporte->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($fecha_filtro, $estatus)
    {
        //
        $reportes = Reporte::join('servicios', 'reportes.fk_servicio', '=', 'servicios.clave_servicio')
            ->join('clientes', 'servicios.fk_cliente', '=', 'clientes.fk_clave_persona')
            ->join('comunidades', 'clientes.fk_comunidad', '=', 'comunidades.clave_comunidad')
            ->join('ciudades as ciudad_cliente', 'comunidades.fk_ciudad', '=', 'ciudad_cliente.clave_ciudad')
            ->join('personas as nombre_cliente', 'clientes.fk_clave_persona', '=', 'nombre_cliente.clave_persona')
            ->leftjoin('personas as tecnico', 'reportes.fk_tecnico', '=', 'tecnico.clave_persona')
            ->select(
                'reportes.clave_reporte',
                'reportes.problema',
                'reportes.veces_reportado',
                'reportes.reporto',
                'reportes.fecha_reporte',
                'reportes.hora_reporte',
                'reportes.estatus',
                'reportes.fecha_finalizacion',
                'reportes.hora_finalizacion',
                'reportes.observaciones',
                'nombre_cliente.nombre as cliente',
                'comunidades.comunidad',
                'ciudad_cliente.ciudad',
                'clientes.direccion',
                'clientes.nexterior',
                'tecnico.nombre as tecnico'
            )->where('reportes.fecha_reporte', '=', $fecha_filtro)
            ->where('reportes.estatus', 'LIKE', '%' . $estatus . '%')
            ->get();

        return response()->json($reportes);
    }

    public function showPendientes($ciudad, $comunidad)
    {
        //
        $reportes = Reporte::join('servicios', 'reportes.fk_servicio', '=', 'servicios.clave_servicio')
            ->join('clientes', 'servicios.fk_cliente', '=', 'clientes.fk_clave_persona')
            ->join('comunidades', 'clientes.fk_comunidad', '=', 'comunidades.clave_comunidad')
            ->join('ciudades as ciudad_cliente', 'comunidades.fk_ciudad', '=', 'ciudad_cliente.clave_ciudad')
            ->join('personas as nombre_cliente', 'clientes.fk_clave_persona', '=', 'nombre_cliente.clave_persona')
            ->select(
                'reportes.clave_reporte',
                'reportes.problema',
                'reportes.veces_reportado',
                'reportes.fecha_reporte',
                'comunidades.comunidad',
                'ciudad_cliente.ciudad'
            )->where('reportes.estatus', '=', 'Pendiente')
            ->where('ciudad_cliente.clave_ciudad', '=', $ciudad)
            ->where('comunidades.clave_comunidad', '=', $comunidad)
            ->orderBy('reportes.veces_reportado', 'DESC')
            ->orderBy('reportes.fecha_reporte', 'ASC')
            ->get();

        return response()->json($reportes);
    }

    public function showDetalle($reporte, $tecnico)
    {
        //
        $obtenerReporte = Reporte::where('clave_reporte', $reporte)
            ->select('fk_tecnico', 'estatus')->get()->first();
        $rp = json_decode($obtenerReporte);

        if ($rp->fk_tecnico == $tecnico && $rp->estatus == 'En proceso') {
            $detalle = Reporte::join('servicios', 'reportes.fk_servicio', '=', 'servicios.clave_servicio')
                ->join('clientes', 'servicios.fk_cliente', '=', 'clientes.fk_clave_persona')
                ->join('comunidades', 'clientes.fk_comunidad', '=', 'comunidades.clave_comunidad')
                ->join('ciudades as ciudad_cliente', 'comunidades.fk_ciudad', '=', 'ciudad_cliente.clave_ciudad')
                ->join('personas as nombre_cliente', 'clientes.fk_clave_persona', '=', 'nombre_cliente.clave_persona')
                ->select(
                    'reportes.clave_reporte',
                    'reportes.problema',
                    'reportes.veces_reportado',
                    'reportes.reporto',
                    'reportes.fecha_reporte',
                    'reportes.hora_reporte',
                    'nombre_cliente.nombre as cliente',
                    'nombre_cliente.telefono_movil',
                    'comunidades.comunidad',
                    'ciudad_cliente.ciudad',
                    'clientes.direccion',
                    'clientes.nexterior',
                    'servicios.latitud',
                    'servicios.longitud',
                    'servicios.foto_fachada'
                )->where('reportes.clave_reporte', '=', $reporte)
                ->get();

            return response()->json($detalle);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'No tienes acceso a este reporte o ya no se encuentra disponible.'
            ], 404);
        }
    }

    public function showEstadisticasComunidad($ciudad, $fechaInicio, $fechaFin)
    {
        //
        $totalReportes = Reporte::join('servicios', 'reportes.fk_servicio', '=', 'servicios.clave_servicio')
            ->join('clientes', 'servicios.fk_cliente', '=', 'clientes.fk_clave_persona')
            ->join('comunidades', 'clientes.fk_comunidad', '=', 'comunidades.clave_comunidad')
            ->join('ciudades as ciudad_cliente', 'comunidades.fk_ciudad', '=', 'ciudad_cliente.clave_ciudad')
            ->join('personas as nombre_cliente', 'clientes.fk_clave_persona', '=', 'nombre_cliente.clave_persona')
            ->selectRaw('comunidades.comunidad, count(*) as total')
            ->where('comunidades.fk_ciudad', '=', $ciudad)
            ->whereBetween('reportes.fecha_reporte', [$fechaInicio, $fechaFin])
            ->groupBy('comunidades.comunidad')->get();

        return response()->json($totalReportes);
    }

    public function showEstadisticasEstatus($ciudad, $fechaInicio, $fechaFin)
    {
        //
        $totalReportes = Reporte::join('servicios', 'reportes.fk_servicio', '=', 'servicios.clave_servicio')
            ->join('clientes', 'servicios.fk_cliente', '=', 'clientes.fk_clave_persona')
            ->join('comunidades', 'clientes.fk_comunidad', '=', 'comunidades.clave_comunidad')
            ->join('ciudades as ciudad_cliente', 'comunidades.fk_ciudad', '=', 'ciudad_cliente.clave_ciudad')
            ->join('personas as nombre_cliente', 'clientes.fk_clave_persona', '=', 'nombre_cliente.clave_persona')
            ->selectRaw('reportes.estatus, count(*) as total')
            ->where('comunidades.fk_ciudad', '=', $ciudad)
            ->whereBetween('reportes.fecha_reporte', [$fechaInicio, $fechaFin])
            ->groupBy('reportes.estatus')->get();

        return response()->json($totalReportes);
    }

    public function showActivos($clave_cliente)
    {
        //
        $activos = Reporte::join('servicios', 'reportes.fk_servicio', '=', 'servicios.clave_servicio')
            ->join('clientes', 'servicios.fk_cliente', '=', 'clientes.fk_clave_persona')
            ->select(
                'reportes.problema',
                'reportes.estatus',
                'reportes.fecha_reporte'
            )->where('clientes.fk_clave_persona', '=', $clave_cliente)
            ->where('reportes.estatus', '!=', 'Finalizado')
            ->get();

        return response()->json($activos);
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
    public function updateProblema(Request $request)
    {
        //
        $reporte = Reporte::find($request->clave_reporte, 'clave_reporte');
        $reporte->problema = $request->problema;

        $reporte->save();
        return $reporte;
    }

    public function updateVeces(Request $request)
    {
        //
        $obtenerVeces = Reporte::where('clave_reporte', $request->clave_reporte)
            ->select('veces_reportado')->get()->first();
        $veces = json_decode($obtenerVeces);

        $reporte = Reporte::find($request->clave_reporte, 'clave_reporte');
        $reporte->veces_reportado = ($veces->veces_reportado + 1);

        $reporte->save();
        return $reporte;
    }

    public function updateEstatus(Request $request)
    {
        //
        $obtenerReporte = Reporte::where('clave_reporte', $request->clave_reporte)
            ->select('fk_tecnico', 'estatus')->get()->first();
        $rp = json_decode($obtenerReporte);

        $reporte = Reporte::find($request->clave_reporte, 'clave_reporte');

        if ($rp->fk_tecnico != null && $rp->estatus != 'Pendiente') {
            return response()->json([
                'success' => false,
                'error' => 'Este reporte ya ha sido atendido o no se encuentra disponible.'
            ], 404);
        } else {
            $reporte->fk_tecnico = $request->fk_tecnico;
            $reporte->estatus = 2;
            $reporte->save();
            return response()->json([
                'success' => true
            ], 200);
        }
    }

    public function updateEstatusFinalizar(Request $request)
    {
        //
        $obtenerReporte = Reporte::where('clave_reporte', $request->clave_reporte)
            ->select('fk_tecnico', 'estatus')->get()->first();
        $rp = json_decode($obtenerReporte);

        $reporte = Reporte::find($request->clave_reporte, 'clave_reporte');

        if ($rp->fk_tecnico == $request->clave_tecnico && $rp->estatus == 'En proceso') {
            $reporte->estatus = 3;
            $reporte->observaciones = $request->observaciones;
            $reporte->fecha_finalizacion = $request->fecha_finalizacion;
            $reporte->hora_finalizacion = $request->hora_finalizacion;
            $reporte->save();
            return response()->json([
                'success' => true
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Este reporte ya ha sido finalizado o no tienes permiso para hacerlo.'
            ], 404);
        }
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
