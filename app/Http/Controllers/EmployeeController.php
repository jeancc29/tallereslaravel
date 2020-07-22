<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class EmployeeController extends Controller
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
            'empleados' => Employee::orderBy("nombre", "asc")->get(),
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


        $empleado = Employee::whereId($datos["empleado"]["id"])->first();
        if($empleado != null){
            $empleado->nombre = $datos["empleado"]["nombre"];
            $empleado->status = $datos["empleado"]["status"];
           $empleado->save();
        }
        else{
            $empleado = Employee::create([
                "nombre" => $datos["empleado"]["nombre"],
                "status" => $datos["empleado"]["status"],
            ]);
        }

        return Response::json([
            'errores' => 0,
            'mensaje' => 'Se ha guardado correctamente',
            "empleados" => Employee::all() 
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
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


        $empleado = Employee::whereId($datos["empleado"]["id"])->first();
        if($empleado != null){
            Employee::whereId($empleado->id)->delete();
            return Response::json([
                'errores' => 0,
                'mensaje' => 'Se ha eliminado correctamente',
                "empleados" => Employee::all() 
            ], 201);
        }


        return Response::json([
            'errores' => 1,
            'mensaje' => 'El cliente no existe'
        ], 201);
    }
}
