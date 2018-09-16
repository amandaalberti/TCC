@extends('layouts.app')
@section('content')
<table>
	<tbody>
		<tr>
			<td style="width: 100%;">
				<h1 class="page-header">Alunos -> {{ $create ? 'Adicionar' : 'Editar' }}</h1>
			</td>
			<td style="width: 1px;">
				@include('voltar')
			</td>
		</tr>
	</tbody>
</table>
<form method="POST" enctype="multipart/form-data" action="{{ $action }}">
    @csrf

    @if(!$create)
    {{ method_field('PATCH') }}
    @endif

	<div class="form-group row">
        <label for="usuario" class="col-md-4 col-form-label text-md-right">Nome de Usuário (Login)</label>

        <div class="col-md-6">
            <input id="usuario" type="usuario" class="form-control{{ $errors->has('usuario') ? ' is-invalid' : '' }}" name="usuario" value="{{ old('usuario') ?? ($aluno['usuario'] ?? '') }}" required>

            @if ($errors->has('usuario'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('usuario') }}</strong>
                </span>
            @endif
        </div>
    </div>
	<div class="form-group row">
        <label for="nome" class="col-md-4 col-form-label text-md-right">Nome</label>

        <div class="col-md-6">
            <input id="nome" type="nome" class="form-control{{ $errors->has('nome') ? ' is-invalid' : '' }}" name="nome" value="{{ old('nome') ?? ($aluno['nome'] ?? '') }}" required>

            @if ($errors->has('nome'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('nome') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="senha" class="col-md-4 col-form-label text-md-right">Senha</label>

        <div class="col-md-6">
            <input id="senha" type="password" class="form-control{{ $errors->has('senha') ? ' is-invalid' : '' }}" name="senha" {{$create ? 'required' : ''}}>

            @if ($errors->has('senha'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('senha') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="senha-confirm" class="col-md-4 col-form-label text-md-right">Confirmar Senha</label>

        <div class="col-md-6">
            <input id="senha-confirm" type="password" class="form-control" name="senha_confirmation" {{$create ? 'required' : ''}}>
        </div>
    </div>

    <div class="form-group row">
        <label for="data-nascimento" class="col-md-4 col-form-label text-md-right">Data de Nascimento</label>

        <div class="col-md-6">
            <date-picker id="data-nascimento" :config="{locale:'pt-br', useStrict:true, format:'DD/MM/YYYY', useCurrent: false, defaultDate: ''}" name="data_nascimento" value="{{ old('data_nascimento') ?? ($aluno['data_nascimento'] ?? '') }}"></date-picker>
        </div>
    </div>

    <div class="form-group row">
        <label for="sexo" class="col-md-4 col-form-label text-md-right">Sexo</label>

        <div class="col-md-6">
            <select class="form-control" name="sexo" required>
            	<option value=""></option>
            	<option value="Masculino"{{ (old('sexo') ?? ($aluno['sexo'] ?? '')) == 'Masculino' ? ' selected="selected"' : '' }}>Masculino</option>
            	<option value="Feminino"{{ (old('sexo') ?? ($aluno['sexo'] ?? '')) == 'Feminino' ? ' selected="selected"' : '' }}>Feminino</option>
            </select>
        </div>
    </div>

	<div class="form-group row">
        <label for="deficiencia" class="col-md-4 col-form-label text-md-right">Deficiência</label>

        <div class="col-md-6">
            <input id="deficiencia" type="deficiencia" class="form-control{{ $errors->has('deficiencia') ? ' is-invalid' : '' }}" name="deficiencia" value="{{ old('deficiencia') ?? ($aluno['deficiencia'] ?? '') }}" required>

            @if ($errors->has('deficiencia'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('deficiencia') }}</strong>
                </span>
            @endif
        </div>
    </div>

	<div class="form-group row">
        <label for="dificuldades" class="col-md-4 col-form-label text-md-right">Dificuldades</label>

        <div class="col-md-6">
            <textarea id="dificuldades" class="form-control{{ $errors->has('dificuldades') ? ' is-invalid' : '' }}" name="dificuldades" required>{{ old('dificuldades') ?? ($aluno['dificuldades'] ?? '') }}</textarea>

            @if ($errors->has('dificuldades'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('dificuldades') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary pull-right">
                Enviar
            </button>
        </div>
    </div>
</form>
@endsection