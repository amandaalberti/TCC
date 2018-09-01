@extends('layouts.app')
@section('content')
<div class="row justify-content-center align-items-center">
	@if($tipo == 'boquinha')
	<div class="col-2 text-center">
		<span class="letra-video">{{ strtoupper($letra) }}</span>
	</div>
	@endif
	
	<div class="col-12 col-sm-8">
		<video src="{{ $url }}" controls="" preload=""></video>
	</div>

	@if($tipo == 'boquinha')
	<div class="col-2 text-center">
		<span class="letra-video letra-video-cursiva">{{ strtolower($letra) }}</span>
	</div>
	@endif

	@include('voltar')
</div>
@endsection