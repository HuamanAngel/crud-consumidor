@extends('layouts.app')


@section('contenido_js')
    
@endsection

@section('contenido_cSS')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection


@section('content')
<!------ Include the above in your HEAD tag ---------->

        <section class="overview-wrap" id="overview">
            <div class="container">
                <div class="contenedor pt-2" >
                    {{-- <img src="{{ asset('images/bg1.jpg') }}" alt=""> --}}
                    <div >
                        <h2 class="title-overview wow fadeInUp">CRUD - Articulos</h2>
                        <p class="subtitle-overview wow fadeInUp">Crud para hacer articulos</p>    
                    </div>
                    <div class="d-flex justify-content-center">
                        <a class="btn btn-primary" href="{{ route('articles.index') }}">Ver mis articulos</a>
                    </div>

                  
                </div>
            </div>
        </section>



@endsection

@section('contenido_abajo_js')
    
@endsection