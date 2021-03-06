<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function logout(){

        session()->flush();
        return  redirect(route('newHome'));
    }

    public function registerApi(Request $request){
        
        $client = new Client([
            'base_uri' => 'http://localhost:8000',
            'timeout' => 2.0
        ]); //Colocamos base de uri y tiempo de espera
        
        $res = $client->request('POST', 'api/auth/signup',[
            'form_params'=>$request->all()]
        ); //request, toma como base la URL
        
        $usuarioCreado = json_decode($res->getBody()->getContents()); // Decodifica y obtiene el contenido
        if($usuarioCreado==null){
            return back()->with('contractFailed',$usuarioCreado)->withInput();
        }
        return redirect(route('login'));
    }
    public function login(Request $request){
        $client = new Client([
            'base_uri' => 'http://localhost:8000',
            'timeout' => 5.0
        ]); //Colocamos base de uri y tiempo de espera
                
        $res = $client->request('POST', 'api/auth/login',[
            'form_params'=>$request->all()]
        ); //request, toma como base la URL
        $usuario = json_decode($res->getBody()->getContents()); // Decodifica y obtiene el contenido
        if($usuario==null){
            return back()->with('contractFailed',$usuario)->withInput();
        }

        session([
            'access_token'=>$usuario->{'access_token'},
            'token_type'=>$usuario->{'token_type'},
            'expires_at'=>$usuario->{'expires_at'}
        ]);
        $token = session('access_token');

        // Peticion para obtener al usuario
        $res2 = $client->request('GET', 'api/auth/user',
            ['headers'=>['Authorization'=>"Bearer {$token}"]]
        );
        $usuario = json_decode($res2->getBody()->getContents()); // Decodifica y obtiene el contenido

        session([
            'id'=>$usuario->{'id'},
            'name'=>$usuario->{'name'},
            'email'=>$usuario->{'email'}
        ]);
        return redirect(route('articles.index'));
    }    

}
