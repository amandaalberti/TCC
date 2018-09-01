@extends('layouts.app')
@section('content')
<div class="row">
	<input type="hidden" value="{{ $letra }}" id="letra" />
	<div class="col-12 col-sm-4 text-center opcao" id="assistir-video">
		<img src="{{ asset('svg/tv.svg') }}" class="col-12 col-sm-6" aria-hidden="true" />
		<span style="display: block;" class="text-center label-opcao">Assistir Vídeo Animado</span>
	</div>
	<div class="col-12 col-sm-4 text-center opcao" id="metodo-boquinhas">
		<img src="{{ asset('svg/boca.svg') }}" class="col-12 col-sm-6" aria-hidden="true" />
		<span style="display: block;" class="text-center label-opcao">Método das Boquinhas</span>
	</div>
	<div class="col-12 col-sm-4 text-center opcao">
		<img src="{{ asset('svg/lapis.svg') }}" class="col-12 col-sm-6" aria-hidden="true" />
		<span style="display: block;" class="text-center label-opcao">Exercícios</span>
	</div>
	@include('voltar')
</div>
@endsection