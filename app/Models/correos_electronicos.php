<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class correos_electronicos extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'correos_electronicos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'usuario_id',
        'correo_electronico',
    ];
}
