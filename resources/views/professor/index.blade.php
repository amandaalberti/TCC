@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
	<div class="col-12 col-sm-4 text-center opcao">
		<a href="{{ route('alunos.index') }}"><img src="{{ asset('png/pessoas.png') }}" class="col-12 col-sm-6" aria-hidden="true" /></a>
		<span style="display: block;" class="text-center label-opcao">Alunos</span>
	</div>
	<div class="col-12 col-sm-4 text-center opcao">
		<a href="{{ route('palavras.index') }}"><img src="{{ asset('png/dicionario.png') }}" class="col-12 col-sm-6" aria-hidden="true" /></a>
		<span style="display: block;" class="text-center label-opcao">Palavras</span>
	</div>
</div>
@endsection