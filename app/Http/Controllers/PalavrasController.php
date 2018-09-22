<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Palavra;

class PalavrasController extends Controller
{
    public function __construct(){
    	$this->middleware('auth:professor');
    }

    public function index(){
    	$palavras = Palavra::orderBy('palavra', 'asc')->paginate(50);

    	foreach($palavras as $palavra)
    		if($palavra->imagem){
    			$f = finfo_open();
				$mime_type = finfo_buffer($f, $palavra->imagem, FILEINFO_MIME_TYPE);
				$palavra->imagem = "data:$mime_type;base64," . base64_encode($palavra->imagem);
    		}
            else
                $palavra->imagem = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';

    	return view('professor.palavras')->with('palavras', $palavras)->with('action', route('palavra.delete'));
    }

    public function create(){
    	return view('professor.formPalavras')->with('create', true)->with('action', route('palavra.store'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'palavra' => 'required|string|max:46',
            'imagem' => 'required|image|max:16000',
            'silabas' => 'required|integer|min:0|max:100',
            'letra' => 'required|in:A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z'
        ]);

        $validated['imagem'] = $validated['imagem']->openFile()->fread($validated['imagem']->getSize());

        $palavra = Palavra::create($validated);

        session()->flash('alert-class', 'alert-success');
        session()->flash('message', 'Palavra cadastrada com sucesso!');

        return redirect()->route('palavra.editar', $palavra->id);
    }

    public function edit($id){
        $palavra = Palavra::findOrFail($id);

        if($palavra->imagem){
            $f = finfo_open();
            $mime_type = finfo_buffer($f, $palavra->imagem, FILEINFO_MIME_TYPE);
            $palavra->imagem = "data:$mime_type;base64," . base64_encode($palavra->imagem);
        }
        else
            $palavra->imagem = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';

        return view('professor.formPalavras')->with('create', false)->with('action', route('palavra.update', $id))->with('palavra', $palavra);
    }

    public function update(Request $request, $id){
        $palavra = Palavra::findOrFail($id);

        $validacao = [
            'palavra' => 'required|string|max:46',
            'silabas' => 'required|integer|min:0|max:100',
            'letra' => 'required|in:A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z'
        ];

        if($request->file('imagem'))
            $validacao['imagem'] = 'required|image|max:16000';

    	$validated = $request->validate($validacao);

        if(isset($validated['imagem']))
            $validated['imagem'] = $validated['imagem']->openFile()->fread($validated['imagem']->getSize());

        $palavra->update($validated);

        session()->flash('alert-class', 'alert-success');
        session()->flash('message', 'Palavra editada com sucesso!');

        return redirect()->route('palavras.index');
    }

    public function delete(){
    	$id = request()->input('delete_id');

        if($id){
            Palavra::where('id','=',$id)->delete();

            session()->flash('alert-class', 'alert-success');
            session()->flash('message', 'Palavra excluída com sucesso!');
        }

        return redirect()->route('palavras.index');
    }
}
