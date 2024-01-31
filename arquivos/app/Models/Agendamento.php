<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agendamento extends Model
{

    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'agendamento';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'id_cliente',
        'id_autonomo',
        'data',
        'horario',
        'descricao',
        'status',
        'servico_finalizado',
        'deleted_at',
        'updated_at',
        'created_at'
    ];

    public function Customer()
    {
        return $this->belongsTo(Customer::class, 'id');
    }
}
