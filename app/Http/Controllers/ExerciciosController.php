<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Palavra;
use App\RespostaExercicio;
use DB;
use Auth;
use Validator;

class ExerciciosController extends Controller
{
	public function index(){
		return view('aluno.exercicios');
	}

    public function geraDados($numeroErradas = 3){
    	if(!is_numeric($numeroErradas))
    		return response()->json(['mensagem' => 'Erro de validação.'], 400);

    	$letras = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
    	$letra = $letras[array_rand($letras)];

    	$certa = Palavra::where("letra", '=', $letra)->where("professor_id", "=", Auth::user()->professor_id)->limit(1)->orderBy(DB::raw('RAND()'))->get();
    	$erradas = Palavra::where("letra", '<>', $letra)->where("professor_id", "=", Auth::user()->professor_id)->limit($numeroErradas)->orderBy(DB::raw('RAND()'))->get();
    	$palavras = [
    		'letra' => $letra,
    		'resposta' => PalavrasController::preparaExibicaoPalavras($certa)[0] ?? null,
    		'outras' => PalavrasController::preparaExibicaoPalavras($erradas)
    	];
    	return response()->json($palavras, 200);
    }

    public function gravaResultado(Request $request){
        $validacao = Validator::make($request->all(), [
            'tipo' => 'required|integer',
            'letra' => 'required|in:A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z',
            'acertou' => 'required|boolean',
            'palavra' => 'required',
            'resposta_certa' => 'required',
            'resposta_selecionada' => 'required'
        ]);

        if($validacao->fails())
            return response()->json(['mensagem' => 'Erro de validação.'], 400);

        $dados = $request->only(['tipo', 'letra', 'acertou', 'palavra', 'resposta_certa', 'resposta_selecionada']);

        RespostaExercicio::create([
            'aluno_id' => Auth::user()->id,
            'tipo' => (int)$dados['tipo'],
            'letra' => $dados['letra'],
            'acertou' => (bool)$dados['acertou'],
            'palavra' => $dados['palavra'],
            'resposta_certa' => $dados['resposta_certa'],
            'resposta_selecionada' => $dados['resposta_selecionada']
        ]);

        return response()->json(['mensagem' => 'OK'], 201);
    }
}
