@extends('layouts.app')
@section('content')
<table>
	<tbody>
		<tr>
			<td style="width: 100%;">
				<h1 class="page-header">Alunos</h1>
			</td>
			<td style="width: 1px;">
				<a href="{{ route('aluno.adicionar') }}" class="btn btn-success"><i class="fa fa-plus"></i><span class="d-none d-sm-inline-block">&nbsp;Adicionar</span></a>
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
					<th style="width: 1px;">Usuário</th>
					<th>Nome</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				@foreach($alunos as $aluno)
				<tr>
					<td>{{ $aluno['usuario'] }}</td>
					<td>{{ $aluno['nome'] }}</td>
					<td class="pull-right">
						<a href="{{ route('aluno.editar', $aluno['id']) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
						&nbsp;
						<button type="button" class="btn btn-danger" onClick="submitDelete({{ $aluno['id'] }})"><i class="fa fa-times"></i></button>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</form>
<hr>
{{ $alunos->links() }}
<script type="text/javascript">
	function submitDelete(id){
		if(confirm('Tem certeza que deseja excluir o aluno?')){
			$('#delete-id').val(id);
			$('#frmDelete').submit();
		}
	}
</script>
@endsection