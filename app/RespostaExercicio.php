<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RespostaExercicio extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = 'data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo', 'aluno_id', 'acertou', 'letra'
    ];
}
