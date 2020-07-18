<?php

namespace App\Http\Controllers;

use App\Proyect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Resources\ProyectResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CustomerResource;

class ProyectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response::json([
            'errores' => 0,
            'mensaje' => 'Se ha eliminado correctamente',
            'proyectos' => ProyectResource::collection(Proyect::all()),
            'productos' => ProductResource::collection(\App\Product::all()),
            "clientes" => \App\Customer::all()
        ], 201);
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
        $datos = request()['datos'];
        try {
            $datos = \App\Classes\Helper::jwtDecode($datos);
            if(isset($datos["datosMovil"]))
                $datos = $datos["datosMovil"];
        } catch (\Throwable $th) {
            //throw $th;
            return Response::json([
                'errores' => 1,
                'mensaje' => 'Token incorrecto',
                'token' => $datos
            ], 201);
        }


        $proyecto = Proyect::whereId($datos["proyecto"]["id"])->first();
        if($proyecto != null){
            $proyecto->idCliente = $datos["proyecto"]["idCliente"];
            $proyecto->descripcion = $datos["proyecto"]["descripcion"];
            $proyecto->status = $datos["proyecto"]["status"];
           $proyecto->save();
        }
        else{
            $proyecto = Proyect::create([
                "idCliente" => $datos["proyecto"]["idCliente"],
                "descripcion" => $datos["proyecto"]["descripcion"],
                "status" => $datos["proyecto"]["status"],
            ]);
        }


        $proyecto->productos()->detach();
        $productos = collect($datos['proyecto']["productos"])->map(function($s) use($proyecto){
            return ['idProducto' => $s['id'], 'idProyecto' => $proyecto['id'], 'cantidad' => $s['cantidad'], 'cantidadEntregada' => $s['cantidadEntregada']];
        });
        $proyecto->productos()->attach($productos);

        
        return Response::json([
            'errores' => 0,
            'mensaje' => 'Se ha eliminado correctamente',
            "proyectos" => Proyect::all(),
            "clientes" => CustomerResource::collection(\App\Customer::all()) 
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Proyect  $proyect
     * @return \Illuminate\Http\Response
     */
    public function show(Proyect $proyect)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Proyect  $proyect
     * @return \Illuminate\Http\Response
     */
    public function edit(Proyect $proyect)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proyect  $proyect
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proyect $proyect)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Proyect  $proyect
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proyect $proyect)
    {
        $datos = request()['datos'];
        try {
            $datos = \App\Classes\Helper::jwtDecode($datos);
            if(isset($datos["datosMovil"]))
                $datos = $datos["datosMovil"];
        } catch (\Throwable $th) {
            //throw $th;
            return Response::json([
                'errores' => 1,
                'mensaje' => 'Token incorrecto',
                'token' => $datos
            ], 201);
        }


        $proyecto = Proyect::whereId($datos["proyecto"]["id"])->first();
        if($proyecto != null){
            $proyecto->productos()->detach();
            $productos = collect($datos['proyecto']["productos"])->map(function($s) use($proyecto){
                
                return ['idUnidad' => $s['id'], 'idproyecto' => $proyecto['id'] ];
            });

            Proyect::whereId($proyecto->id)->delete();
            return Response::json([
                'errores' => 0,
                'mensaje' => 'Se ha eliminado correctamente',
                "proyectos" => Proyect::all() 
            ], 201);
        }


        return Response::json([
            'errores' => 1,
            'mensaje' => 'El proyecto no existe'
        ], 201);
    }
}
