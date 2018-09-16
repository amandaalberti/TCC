<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Aluno extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'usuario', 'senha', 'data_nascimento', 'sexo', 'deficiencia', 'dificuldades', 'professor_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'senha'
    ];

    public function getAuthPassword()
	{
	    return $this->senha;
	}
}
