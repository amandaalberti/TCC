<?php

namespace App\Http\Controllers;

use App\Aluno;
use App\RespostaExercicio;
use Auth;
use DB;
use Validator;
use Hash;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AlunosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:professor');
    }

    public function index(){
    	$alunos = Aluno::where('professor_id', '=', Auth::user()->id)->orderBy('id','asc')->paginate(50);

		return view('professor.alunos')->with('alunos', $alunos)->with('action', route('aluno.delete'));
	}

	public function create(){
		return view('professor.formAlunos')->with('create', true)->with('action', route('aluno.store'));
	}

	public function store(Request $request){
		$validated = $request->validate([
	        'usuario' => 'required|string|max:50|unique:alunos',
			'nome' => 'required|string|max:100',
			'senha' => 'required|confirmed|string|min:6',
			'data_nascimento' => 'required|date_format:d/m/Y',
			'sexo' => 'required|in:Masculino,Feminino',
			'deficiencia' => 'required|string|max:50',
			'dificuldades' => 'required|string|max:500'
	    ]);

	    $validated['professor_id'] = Auth::user()->id;

	    $validated['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $validated['data_nascimento']);

	    $validated['senha'] = Hash::make($validated['senha']);

		$aluno = Aluno::create($validated);

	    session()->flash('alert-class', 'alert-success');
	    session()->flash('message', 'Aluno criado com sucesso!');

		return redirect()->route('alunos.index');
	}

	public function edit($id){
		$aluno = Aluno::where('professor_id', '=', Auth::user()->id)->findOrFail($id);

		$aluno['data_nascimento'] = Carbon::createFromFormat('Y-m-d', $aluno['data_nascimento'])->format('d/m/Y');

		return view('professor.formAlunos')->with('create', false)->with('action', route('aluno.update', $id))->with('aluno', $aluno);
	}

	public function update(Request $request, $id){
		$aluno = Aluno::where('professor_id', '=', Auth::user()->id)->findOrFail($id);

		$validacao = [
			'nome' => 'required|string|max:100',
			'data_nascimento' => 'required|date_format:d/m/Y',
			'sexo' => 'required|in:Masculino,Feminino',
			'deficiencia' => 'required|string|max:50',
			'dificuldades' => 'required|string|max:500'
	    ];

		if($aluno->usuario != $request->input('usuario'))
	        $validacao['usuario'] = 'required|string|max:50|unique:alunos';

		$validated = $request->validate($validacao);

	    $validated['senha'] = $request->input('senha');
	    $validated['senha_confirmation'] = $request->input('senha_confirmation');

		if(isset($validated['senha']) && $validated['senha']){
		    $validator = Validator::make($validated, [
				'senha' => 'required|confirmed|string|min:6'
		    ]);

		    if($validator->fails())
		    	return redirect()->route('aluno.editar', $id)
                        ->withErrors($validator)
                        ->withInput();
		}
		else
			unset($validated['senha']);

		unset($validated['senha_confirmation']);

		if(isset($validated['senha']))
			$validated['senha'] = Hash::make($validated['senha']);

	    $validated['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $validated['data_nascimento']);

	    $aluno->update($validated);

	    session()->flash('alert-class', 'alert-success');
	    session()->flash('message', 'Aluno editado com sucesso!');

	    return redirect()->route('alunos.index');
	}

	public function delete(){
		$id = request()->input('delete_id');

		if($id){
			Aluno::where('id','=',$id)->where('professor_id', '=', Auth::user()->id)->delete();

			session()->flash('alert-class', 'alert-success');
			session()->flash('message', 'Aluno excluído com sucesso!');
		}

		return redirect()->route('alunos.index');
	}

	public function verGraficos($id){
		$aluno = Aluno::where('professor_id', '=', Auth::user()->id)->findOrFail($id);

		return view('professor.graficosAluno')->with('aluno', $aluno);
	}

	public function dadosGraficos($id){
		$aluno = Aluno::where('professor_id', '=', Auth::user()->id)->findOrFail($id);

		$filtros = request()->only('dataInicial', 'dataFinal', 'tipo');

		try {
			$dataInicial = Carbon::createFromFormat('d/m/Y', $filtros['dataInicial']);
			$dataFinal = Carbon::createFromFormat('d/m/Y', $filtros['dataFinal']);
		} catch (\Exception $e){
			$dataInicial = Carbon::today()->addDays(-30);
			$dataFinal = Carbon::today();
		}

		$query = RespostaExercicio::whereBetween(DB::raw('DATE(data)'), [$dataInicial->format('Y-m-d'), $dataFinal->format('Y-m-d')])->where('aluno_id', $id);

		if(isset($filtros['tipo']) && in_array($filtros['tipo'], [1, 2, 3]))
			$query->where('tipo', $filtros['tipo']);

		$resultados = $query->get();

		$series = $this->processaGrafico($resultados);

		return response()->json($series, 200);
	}

	private function processaGrafico($dados){
		$series = [
			[
				'name' => 'Acertos',
				'showInLegend' => false,
				'data' => [
					0 => 0,
					1 => 0,
					2 => 0,
					3 => 0,
					4 => 0,
					5 => 0,
					6 => 0,
					7 => 0,
					8 => 0,
					9 => 0,
					10 => 0,
					11 => 0,
					12 => 0,
					13 => 0,
					14 => 0,
					15 => 0,
					16 => 0,
					17 => 0,
					18 => 0,
					19 => 0,
					20 => 0,
					21 => 0,
					22 => 0,
					23 => 0,
					24 => 0,
					25 => 0
				]
			],
			[
				'name' => 'Erros',
				'showInLegend' => false,
				'data' => [
					0 => 0,
					1 => 0,
					2 => 0,
					3 => 0,
					4 => 0,
					5 => 0,
					6 => 0,
					7 => 0,
					8 => 0,
					9 => 0,
					10 => 0,
					11 => 0,
					12 => 0,
					13 => 0,
					14 => 0,
					15 => 0,
					16 => 0,
					17 => 0,
					18 => 0,
					19 => 0,
					20 => 0,
					21 => 0,
					22 => 0,
					23 => 0,
					24 => 0,
					25 => 0
				]
			]
		];

		$letras = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];

		foreach($dados as $d)
			if($d['acertou'])
				$series[0]['data'][array_search($d['letra'], $letras)]++;
			else
				$series[1]['data'][array_search($d['letra'], $letras)]++;

		return $series;
	}
}
