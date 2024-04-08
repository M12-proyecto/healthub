<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class numeros_telefono extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'numeros_telefono';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'usuario_id',
        'numero_telefono',
    ];
}
