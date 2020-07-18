<?php
namespace App\Classes;

class Helper{

    public static function jwtDecode($token)
    {
        $stdClass = \Firebase\JWT\JWT::decode($token, \config('data.apiKey'), array('HS256'));
        $datos = Helper::stdClassToArray($stdClass);
        return $datos;
    }

    public static function jwtEncodeServidor($servidor, $usuario)
    {
        $time = time();
        $key = \config('data.apiKey');

        $token = array(
            'iat' => $time, // Tiempo que inició el token
            'exp' => $time + (60*60), // Tiempo que expirará el token (+1 hora)
            'data' => [ // información del usuario
                'usuario' => $usuario,
                'servidor' => $servidor
            ]
        );

        return \Firebase\JWT\JWT::encode($token, $key);
    }

    public static function stdClassToArray($stdClass)
    {
        return json_decode(json_encode($stdClass), true);
    }

}