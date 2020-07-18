<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Resources\CustomerResource;

class CustomerController extends Controller
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
            'clientes' => Customer::all(),
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


        $cliente = Customer::whereId($datos["cliente"]["id"])->first();
        if($cliente != null){
            $cliente->nombre = $datos["cliente"]["nombre"];
            $cliente->status = $datos["cliente"]["status"];
           $cliente->save();
        }
        else{
            $cliente = Customer::create([
                "nombre" => $datos["cliente"]["nombre"],
                "status" => $datos["cliente"]["status"],
            ]);
        }

        return Response::json([
            'errores' => 0,
            'mensaje' => 'Se ha eliminado correctamente',
            "clientes" => CustomerResource::collection(Customer::all()) 
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
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


        $cliente = Customer::whereId($datos["cliente"]["id"])->first();
        if($cliente != null){
            Customer::whereId($cliente->id)->delete();
            return Response::json([
                'errores' => 0,
                'mensaje' => 'Se ha eliminado correctamente',
                "clientes" => Customer::all() 
            ], 201);
        }


        return Response::json([
            'errores' => 1,
            'mensaje' => 'El cliente no existe'
        ], 201);
    }
}
