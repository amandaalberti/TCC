@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-white" style="background-color: rgb(255, 193, 133);"><strong>Login</strong></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" aria-label="Login" id="frmLogin">
                        @csrf

                        <div class="form-group row">
                            <label for="usuario" class="col-sm-4 col-form-label text-md-right">Nome de usuário</label>

                            <div class="col-md-6">
                                <input id="usuario" type="usuario" class="form-control{{ $errors->has('usuario') ? ' is-invalid' : '' }}" name="usuario" value="{{ old('usuario') }}" required autofocus>

                                @if ($errors->has('usuario'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('usuario') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Senha</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <input type="hidden" name="tipo" id="tipo" value="" />
                                <button type="button" onClick="$('#tipo').val('professor'); $('#frmLogin').submit();" class="btn btn-cinza-claro">
                                    Sou Professor
                                </button>
                                <button type="button" onClick="$('#tipo').val('aluno'); $('#frmLogin').submit();" class="btn btn-cinza-claro">
                                    Sou Aluno
                                </button>

                                <br />

                                <div style="position: relative;left: -12px;">
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Esqueceu sua senha?
                                </a>
                                <a class="btn btn-link" href="{{ route('register') }}">Cadastrar Professor</a></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
