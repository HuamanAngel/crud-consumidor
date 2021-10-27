<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class VerifyTokenApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Si no tiene acces_token
        if (!session()->has('access_token')) {
            return redirect(route('login'));
        }
        
        ////////////////Validacion constante de token //////////////////////////////
        // $client = new Client([
        //     'base_uri' => 'http://localhost:8000',
        //     'timeout' => 5.0
        // ]); //Colocamos base de uri y tiempo de espera
        // $token = session('access_token');
        // $res = $client->request('GET', 'api/auth/user',
        //     ['headers'=>['Authorization'=>"Bearer {$token}"]]
        // );
        // $usuario = json_decode($res->getBody()->getContents()); // Decodifica y obtiene el contenido
        // if($usuario==null){
        //     return redirect(route('login'));
        // }
        ////////////////////////////////////////////////////////////
        return $next($request);
    }
}
