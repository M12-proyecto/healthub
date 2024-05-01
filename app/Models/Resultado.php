<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Resultado extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "resultados";

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'paciente_id',
        'medico_id',
        'centro',
        'prueba',
        'resultado',
        'fecha',
        'unidades',
        'valores_normalidad',
        'observaciones'
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

    public static function formatDate($date) {
        // Convertir la fecha al nuevo formato "d-m-Y"
        $newDate = date("d-m-Y", strtotime($date));

        return $newDate;
    }

    public function paciente()
    {
        return $this->belongsTo(User::class, 'paciente_id');
    }

    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_id');
    }
}
