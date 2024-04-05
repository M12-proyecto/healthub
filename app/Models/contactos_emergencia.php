<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contactos_emergencia extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'contactos_emergencia';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'paciente_id',
        'nombre',
        'numero_telefono',
        'correo_electronico',
    ];
}
