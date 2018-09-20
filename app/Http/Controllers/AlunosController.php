<?php

namespace App\Http\Controllers;

use App\Aluno;
use Auth;
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

		return redirect()->route('aluno.editar', $aluno->id);
	}

	public function edit($id){
		$aluno = Aluno::where('professor_id', '=', Auth::user()->id)->findOrFail($id);

		$aluno['data_nascimento'] = Carbon::createFromFormat('Y-m-d', $aluno['data_nascimento'])->format('d/m/Y');

		return view('professor.formAlunos')->with('create', false)->with('action', route('aluno.update', $id))->with('aluno', $aluno);
	}

	public function update(Request $request, $id){
		$validated = $request->validate([
	        'usuario' => 'required|string|max:50|unique:alunos',
			'nome' => 'required|string|max:100',
			'data_nascimento' => 'required|date_format:d/m/Y',
			'sexo' => 'required|in:Masculino,Feminino',
			'deficiencia' => 'required|string|max:50',
			'dificuldades' => 'required|string|max:500'
	    ]);

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

	    Aluno::where('id','=',$id)->where('professor_id', '=', Auth::user()->id)->update($validated);

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
}
