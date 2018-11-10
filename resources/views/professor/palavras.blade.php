@extends('layouts.app')
@section('content')
@if($exibeAviso)
<strong style="color:red">Aviso: É necessário o cadastro pelo menos uma palavra por letra do alfabeto para o funcionamento correto dos exercícios!</strong>
@endif
<table style="width:100%">
	<tbody>
		<tr>
			<td>
				<h1 class="page-header">Palavras</h1>
			</td>
			<td class="text-right">
				<a href="{{ route('palavra.adicionar') }}" class="btn btn-success"><i class="fa fa-plus"></i><span class="d-none d-sm-inline-block">&nbsp;Adicionar</span></a>
				<button class="btn btn-tomato" type="button" onClick="history.back();"><i class="fa fa-arrow-left"></i><span class="d-none d-sm-inline-block">&nbsp;Voltar</span></button>
			</td>
		</tr>
	</tbody>
</table>
<form method="POST" enctype="multipart/form-data" action="{{ $action }}" id="frmDelete">
	@csrf

	<input type="hidden" name="delete_id" id="delete-id" value="0">

	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th style="width: 1px;">&nbsp;</th>
					<th>Palavra</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				@foreach($palavras as $palavra)
				<tr>
					<td><img src="{{ $palavra['imagem'] }}" width="45" alt="{{ $palavra['palavra'] }}"></td>
					<td>{{ $palavra['palavra'] }}</td>
					<td class="pull-right">
						<a href="{{ route('palavra.editar', $palavra['id']) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
						&nbsp;
						<button type="button" class="btn btn-danger" onClick="submitDelete({{ $palavra['id'] }})"><i class="fa fa-times"></i></button>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</form>
<hr>
{{ $palavras->links() }}
<script type="text/javascript">
	function submitDelete(id){
		if(confirm('Tem certeza que deseja excluir a palavra?')){
			$('#delete-id').val(id);
			$('#frmDelete').submit();
		}
	}
</script>
@endsection