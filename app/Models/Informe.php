<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Informe extends Model
{
    use HasFactory;

    protected $table = 'informes';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'paciente_id',
        'medico_id',
        'centro',
        'especialidad',
        'motivo_consulta',
        'enfermedad_actual',
        'diagnostico',
        'procedimiento',
        'tratamiento',
        'fecha_alta'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        
    ];

    public function paciente()
    {
        return $this->belongsTo(User::class, 'paciente_id');
    }

    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_id');
    }

    public static function formatTimestamp($timestamp) {
        // Convertir el timestamp al nuevo formato "d-m-Y H:i:s"
        $newTimestamp = date("d-m-Y H:i:s", strtotime($timestamp));

        return $newTimestamp;
    }

    public static function formatDate($date) {
        // Convertir la fecha al nuevo formato "d-m-Y"
        $newDate = date("d-m-Y", strtotime($date));

        return $newDate;
    }
}
