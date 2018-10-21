@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
	<div class="col-12 col-sm-4 text-center opcao">
		<a href="{{ route('video', ['historia', $letra]) }}"><img src="{{ asset('svg/tv.svg') }}" class="col-12 col-sm-6" aria-hidden="true" /></a>
		<span style="display: block;" class="text-center label-opcao">Assistir Vídeo Animado</span>
	</div>
	<div class="col-12 col-sm-4 text-center opcao">
		<a href="{{ route('video', ['boquinha', $letra]) }}"><img src="{{ asset('svg/boca.svg') }}" class="col-12 col-sm-6" aria-hidden="true" /></a>
		<span style="display: block;" class="text-center label-opcao">Método das Boquinhas</span>
	</div>
	@include('voltar')
</div>
@endsection