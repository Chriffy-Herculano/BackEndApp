<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autonomo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'autonomo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'id_cliente',
        'nome_completo',
        'idade',
        'profissao',
        'genero',
        'telefone',
        'estado',
        'cidade',
        'descricao',
        'foto',
    ];

    public function Customer()
    {
        return $this->belongsTo(Customer::class, 'id_cliente');
    }
}
