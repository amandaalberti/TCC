<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideosController extends Controller
{
    public function index($tipo, $letra){
    	if(!in_array($tipo, ['boquinha', 'historia']) ||
    	   !in_array(strtolower($letra), ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z']))
    		abort(404);

		return view('aluno.video')
		->with('url', url('/videos/' . ($tipo == 'historia' ? 'videosAnimados' : 'videosBoquinhas')) . '/' . strtoupper($letra) . '.mp4')
		->with('tipo', $tipo)
		->with('letra', $letra);
	}
}
