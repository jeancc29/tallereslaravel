<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use App\Http\Resources\ProductResource;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $datos = request()->validate([
        //     'token' => 'required'
        // ]);

        // try {
        //     $datos = \Helper::jwtDecode($datos["token"]);
        //     if(isset($datos["datosMovil"]))
        //         $datos = $datos["datosMovil"];
        // } catch (\Throwable $th) {
        //     //throw $th;
        //     return Response::json([
        //         'errores' => 1,
        //         'mensaje' => 'Token incorrecto',
        //         'token' => $datos
        //     ], 201);
        // }


        
        return Response::json([
            'errores' => 0,
            'mensaje' => 'Se ha eliminado correctamente',
            'productos' => ProductResource::collection(Product::all()),
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


        $producto = Product::whereId($datos["producto"]["id"])->first();
        if($producto != null){
            $producto->descripcion = $datos["producto"]["descripcion"];
            $producto->existencia = $datos["producto"]["existencia"];
            $producto->status = $datos["producto"]["status"];
            $producto->gastable = $datos["producto"]["gastable"];
           $producto->save();
        }
        else{
            $producto = Product::create([
                "descripcion" => $datos["producto"]["descripcion"],
                "existencia" => $datos["producto"]["existencia"],
                "status" => $datos["producto"]["status"],
                "gastable" => $datos["producto"]["gastable"],
            ]);
        }


        $producto->unidades()->detach();
        $unidades = collect($datos['producto']["unidades"])->map(function($s) use($producto){
            return ['idUnidad' => $s['id'], 'idProducto' => $producto->id, "pordefecto" => $s["pordefecto"]];
        });
        $producto->unidades()->attach($unidades);

        
        return Response::json([
            'errores' => 0,
            'mensaje' => 'Se ha eliminado correctamente',
            // 'unidades' => \App\Unit::whereStatus(1)->get(),
            'productos' => ProductResource::collection(Product::all()),
        ], 201);
    }
    public function search(Request $request)
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


        $productos = Product::where('descripcion', 'like', '%' . $datos["busqueda"] . '%')->get();
        
       


        
        
        return Response::json([
            'errores' => 0,
            'mensaje' => 'Se ha eliminado correctamente',
            // 'unidades' => \App\Unit::whereStatus(1)->get(),
            "productos" => $productos
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
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


        $producto = Product::whereId($datos["producto"]["id"])->first();
        if($producto != null){
            $producto->unidades()->detach();
            $producto->proyectos()->detach();
            

            Product::whereId($producto->id)->delete();
            return Response::json([
                'errores' => 0,
                'mensaje' => 'Se ha eliminado correctamente',
                "productos" => Product::all() 
            ], 201);
        }


        return Response::json([
            'errores' => 1,
            'mensaje' => 'El producto no existe'
        ], 201);
    }
}
