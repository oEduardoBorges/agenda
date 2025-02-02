<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendas extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'nome',
        'email',
        'endereco',
        'telefone'
    ];

    use HasFactory;
}
