<?php

namespace App\Models;

class Customer extends \Illuminate\Database\Eloquent\Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customers';

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
    ];



}
