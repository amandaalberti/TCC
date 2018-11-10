<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Palavra extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'palavra', 'imagem', 'silabas', 'letra', 'professor_id'
    ];
}
