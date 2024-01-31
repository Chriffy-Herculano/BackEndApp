<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Avaliacao extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'avaliacao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'id_cliente',
        'id_autonomo',
        'avaliacao',
        'comentario',
    ];

}
