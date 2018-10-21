@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
	<div class="col-12 col-sm-4 text-center opcao">
		<a href="{{ route('alfabeto') }}"><img src="{{ asset('svg/alfabeto.svg') }}" class="col-12 col-sm-6" aria-hidden="true" /></a>
		<span style="display: block;" class="text-center label-opcao">Alfabeto</span>
	</div>
	<div class="col-12 col-sm-4 text-center opcao">
		<a href="{{ route('exercicios') }}"><img src="{{ asset('svg/lapis.svg') }}" class="col-12 col-sm-6" aria-hidden="true" /></a>
		<span style="display: block;" class="text-center label-opcao">Exercícios</span>
	</div>
</div>
@endsection