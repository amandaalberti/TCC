@extends('layouts.app')
@section('content')
<grafico id-aluno="{{ $aluno->id }}" nome-aluno="{{ $aluno->nome }}"></grafico>
@endsection