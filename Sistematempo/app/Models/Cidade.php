<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
        protected $table = 'cidades_da_tabela';
        
    protected $fillable=[
        'cidade',
        'estado',
        'pais',
    ];
}
