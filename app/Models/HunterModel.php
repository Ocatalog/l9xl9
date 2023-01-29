<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HunterModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "hunters";
    protected $primaryKey = 'id';
    const CREATED_AT = 'data_cadastro';
    const UPDATED_AT = 'data_atualizacao';
    protected $fillable = [
        'nome_hunter',
        'idade_hunter',
        'altura_hunter',
        'peso_hunter',
        'tipo_hunter',
        'tipo_nen',
        'tipo_sangue',
        'imagem_hunter',
        'serial',
    ];
}
