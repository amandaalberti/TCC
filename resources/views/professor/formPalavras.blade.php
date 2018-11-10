@extends('layouts.app')
@section('content')
<table>
	<tbody>
		<tr>
			<td style="width: 100%;">
				<h1 class="page-header">Palavras <i class="fa fa-angle-double-right"></i> {{ $create ? 'Adicionar' : 'Editar' }}</h1>
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
    @method('PATCH')
    @endif

    <div class="form-group row">
        <label for="palavra" class="col-md-4 col-form-label text-md-right">Palavra</label>

        <div class="col-md-6">
            <input id="palavra" type="text" class="form-control{{ $errors->has('palavra') ? ' is-invalid' : '' }}" maxlength="46" name="palavra" value="{{ old('palavra') ?? ($palavra['palavra'] ?? '') }}" required>

            @if ($errors->has('palavra'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('palavra') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="silabas" class="col-md-4 col-form-label text-md-right">Nº de Sílabas</label>

        <div class="col-md-6">
            <input id="silabas" type="number" min="0" max="100" class="form-control{{ $errors->has('silabas') ? ' is-invalid' : '' }}" name="silabas" value="{{ old('silabas') ?? ($palavra['silabas'] ?? '') }}" required>

            @if ($errors->has('silabas'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('silabas') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="letra" class="col-md-4 col-form-label text-md-right">Letra associada</label>

        <div class="col-md-6">
            <select class="form-control" name="letra" required>
                <option value=""></option>
                <option value="A"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'A' ? ' selected="selected"' : '' }}>A</option>
                <option value="B"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'B' ? ' selected="selected"' : '' }}>B</option>
                <option value="C"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'C' ? ' selected="selected"' : '' }}>C</option>
                <option value="D"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'D' ? ' selected="selected"' : '' }}>D</option>
                <option value="E"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'E' ? ' selected="selected"' : '' }}>E</option>
                <option value="F"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'F' ? ' selected="selected"' : '' }}>F</option>
                <option value="G"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'G' ? ' selected="selected"' : '' }}>G</option>
                <option value="H"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'H' ? ' selected="selected"' : '' }}>H</option>
                <option value="I"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'I' ? ' selected="selected"' : '' }}>I</option>
                <option value="J"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'J' ? ' selected="selected"' : '' }}>J</option>
                <option value="K"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'K' ? ' selected="selected"' : '' }}>K</option>
                <option value="L"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'L' ? ' selected="selected"' : '' }}>L</option>
                <option value="M"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'M' ? ' selected="selected"' : '' }}>M</option>
                <option value="N"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'N' ? ' selected="selected"' : '' }}>N</option>
                <option value="O"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'O' ? ' selected="selected"' : '' }}>O</option>
                <option value="P"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'P' ? ' selected="selected"' : '' }}>P</option>
                <option value="Q"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'Q' ? ' selected="selected"' : '' }}>Q</option>
                <option value="R"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'R' ? ' selected="selected"' : '' }}>R</option>
                <option value="S"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'S' ? ' selected="selected"' : '' }}>S</option>
                <option value="T"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'T' ? ' selected="selected"' : '' }}>T</option>
                <option value="U"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'U' ? ' selected="selected"' : '' }}>U</option>
                <option value="V"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'V' ? ' selected="selected"' : '' }}>V</option>
                <option value="W"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'W' ? ' selected="selected"' : '' }}>W</option>
                <option value="X"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'X' ? ' selected="selected"' : '' }}>X</option>
                <option value="Y"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'Y' ? ' selected="selected"' : '' }}>Y</option>
                <option value="Z"{{ (old('letra') ?? ($palavra['letra'] ?? '')) == 'Z' ? ' selected="selected"' : '' }}>Z</option>
            </select>

            @if ($errors->has('letra'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('letra') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="imagem" class="col-md-4 col-form-label text-md-right">Imagem</label>

        <div class="col-md-6">
            <table>
                <tbody>
                    <tr>
                        <td>
                            <img src="{{ $palavra->imagem ?? 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==' }}" width="45" alt="{{ $palavra->palavra ?? '' }}">
                        </td>
                        <td style="width: 100%;">
                            <input id="imagem" type="file" class="{{ $errors->has('imagem') ? 'is-invalid' : '' }}" style="width:100%" name="imagem" 
                            @if($create)
                            required
                            @endif
                            >
                        </td>
                    </tr>
                </tbody>
            </table>

            @if ($errors->has('imagem'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('imagem') }}</strong>
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