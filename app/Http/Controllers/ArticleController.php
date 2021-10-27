<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    const ERRORREASON = "No se pudo ejecutar el contrato por las siguientes razones : ";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $client = new Client([
            'base_uri' => 'http://localhost:8000',
            'timeout' => 5.0
        ]); //Colocamos base de uri y tiempo de espera
        $token = session('access_token');
        $res = $client->request('GET', 'api/auth/articlesapi',
            ['headers'=>['Authorization'=>"Bearer {$token}"]]
        );
        

        $articleAll = json_decode($res->getBody()->getContents());
        return view('article.index',compact('articleAll'));
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

        $passValidation =  $this->validationArticle($request);

        if($passValidation->fails()){
            $errorRegisterFailed = self::ERRORREASON; 
            return back()->withErrors($passValidation,'contractProccessForm')->with('contractFailed',$errorRegisterFailed)->withInput();
        }        

        $client = new Client([
            'base_uri' => 'http://localhost:8000',
            'timeout' => 5.0
        ]); //Colocamos base de uri y tiempo de espera

        $token = session('access_token');
        $res = $client->request('POST', "api/auth/articlesapi",
            [
                'headers'=>['Authorization'=>"Bearer {$token}"],
                'form_params'=>$request->all()
            ]
        );
        $status = 'Articulo creado exitosamente';
        return redirect(route('articles.index'))->with('statusRegisterArticle',$status);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {

        $client = new Client([
            'base_uri' => 'http://localhost:8000',
            'timeout' => 5.0
        ]); //Colocamos base de uri y tiempo de espera
        $token = session('access_token');
        $res = $client->request('GET', "api/auth/articlesapi/{$code}",
            ['headers'=>['Authorization'=>"Bearer {$token}"]]
        );
        $article = json_decode($res->getBody()->getContents());
        return view('article.edit',compact('article'));        
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
     * | the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $code)
    {
        $client = new Client([
            'base_uri' => 'http://localhost:8000',
            'timeout' => 5.0
        ]); //Colocamos base de uri y tiempo de espera

        $token = session('access_token');
        $res = $client->request('GET', "api/auth/articlesapi/{$code}",
            ['headers'=>['Authorization'=>"Bearer {$token}"]]
        );
        $article = json_decode($res->getBody()->getContents());    
        $passValidation =  $this->validationArticleEdit($request);
        if($passValidation->fails()){
            $errorRegisterFailed = self::ERRORREASON; 
            return back()->withErrors($passValidation,'contractProccessForm')->with('contractFailed',$errorRegisterFailed)->withInput();
        }           
        $res = $client->request('PUT', "api/auth/articlesapi/{$code}",
            [
                'headers'=>['Authorization'=>"Bearer {$token}"],
                'form_params'=>$request->all()
            ]
        );        
        $status = 'Articulo actualizado exitosamente';
        return redirect(route('articles.show',$article->art_code))->with('updateArticle',$status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($code)
    {

        $client = new Client([
            'base_uri' => 'http://localhost:8000',
            'timeout' => 5.0
        ]); //Colocamos base de uri y tiempo de espera

        $token = session('access_token');
        $res = $client->request('GET', "api/auth/articlesapi/{$code}",
            ['headers'=>['Authorization'=>"Bearer {$token}"]]
        );
        $article = json_decode($res->getBody()->getContents());    
        $name = $article->{'art_name'};
        
        $res = $client->request("DELETE", "api/auth/articlesapi/{$code}",
            ['headers'=>['Authorization'=>"Bearer {$token}"]]
        );
        
        $status = 'Borrado exitosamente el articulo '.$name;
        return redirect(route('articles.index'))->with('statusRegisterArticle',$status);


        //
    }

    public function validationArticleEdit(Request $request){
        $fieldCreate= [
            'nameArticle'=>'required|string|min:0',
            'quantityArticle'=>'required|integer|between:0,1000',

        ];
        $messageError=[
            'required' =>'Este campo ":attribute" es obligatorio',
            'integer'=>'":attribute" Debe ser numero entero',
            'between:0,1000'=>'":attribute" Fuera del rango',
            'string'=>'":attribute" Debe ser texto',
        ];
        $validacion = Validator::make($request->all(),$fieldCreate,$messageError);
        return $validacion;        
    }    
    public function validationArticle(Request $request){
        $fieldCreate= [
            'codeArticle'=>'required|string|min:0',
            'nameArticle'=>'required|string|min:0',
            'quantityArticle'=>'required|integer|between:0,1000',

        ];
        $messageError=[
            'required' =>'Este campo ":attribute" es obligatorio',
            'integer'=>'":attribute" Debe ser numero entero',
            'between:0,1000'=>'":attribute" Fuera del rango',
            'string'=>'":attribute" Debe ser texto',
        ];
        $validacion = Validator::make($request->all(),$fieldCreate,$messageError);
        return $validacion;        
    }

}
