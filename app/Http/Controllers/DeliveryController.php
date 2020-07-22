<?php

namespace App\Http\Controllers;

use App\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Resources\ProyectResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\DeliveryResource;

class DeliveryController extends Controller
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
            'mensaje' => 'Datos correctos',
            'entregas' => DeliveryResource::collection(\App\Delivery::orderBy("id", "desc")->get()),
            'clientes' => CustomerResource::collection(\App\Customer::all()),
            'productos' => ProductResource::collection(\App\Product::all()),
            'empleados' => \App\Employee::all(),
            "unidades" => \App\Unit::all()
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

        $arrayIdEntrega = [];
        foreach ($datos["entregas"] as $dato) {
            $entrega = Delivery::whereId($dato["id"])->first();
            if($entrega != null){
                $entrega->idCliente = $dato["idCliente"];
                $entrega->idProyecto = $dato["idProyecto"];
                $entrega->idEmpleado = $dato["idEmpleado"];
                $entrega->status = 1;
                $entrega->save();
            }
            else{
                $entrega = Delivery::create([
                    "idCliente" => $dato["idCliente"],
                    "idProyecto" => $dato["idProyecto"],
                    "idEmpleado" => $dato["idEmpleado"],
                    "status" => 1,
                ]);
            }

            \App\Deliverydetail::whereId($entrega["id"])->delete();
            
            foreach($dato["entregadetalles"] as $d){
                $producto = \App\Product::whereId($d["idProducto"])->first();
                if($producto->gastable == 1){
                    if($producto->existencia > 0){
                        $producto->existencia -= $d["cantidad"];
                        $producto->save();
                    }
                }
                \App\Deliverydetail::create([
                    "idEntrega" => $entrega["id"],
                    "idProducto" => $d["idProducto"],
                    "idUnidad" => $d["idUnidad"],
                    "cantidad" => $d["cantidad"],
                    "detalles" => "",
                ]);
            }

            array_push($arrayIdEntrega, $entrega->id);
        }
        


        
        return Response::json([
            'errores' => 0,
            'mensaje' => 'Se ha eliminado correctamente',
            // 'unidades' => \App\Unit::whereStatus(1)->get(),
            "entregas" => DeliveryResource::collection(Delivery::whereIn("id", $arrayIdEntrega)->get())
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function show(Delivery $delivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function edit(Delivery $delivery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Delivery $delivery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delivery $delivery)
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


        $entrega = Delivery::whereId($datos["entrega"]["id"])->first();
        if($entrega != null){
            $entrega->status = 0;
            $entrega->save();
            foreach($entrega->detalles as $d){
                $producto = \App\Product::whereId($d->idProducto)->first();
                if($producto != null){
                    $producto->existencia += $d->cantidad;
                    $producto->save();
                }
            }
            return Response::json([
                'errores' => 0,
                'mensaje' => 'Se ha eliminado correctamente',
            ], 201);
        }


        return Response::json([
            'errores' => 1,
            'mensaje' => 'La entrega no existe'
        ], 201);
    }
}
