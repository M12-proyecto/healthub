<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;
    
    protected $table = 'mensajes';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'chat_id',
        'usuario1',
        'usuario2',
        'mensaje',
        'fecha',
        'hora'
    ];

    protected $hidden = [];

    protected $casts = [];

    public function paciente()
    {
        return $this->belongsTo(User::class, 'paciente_id');
    }

    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_id');
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }

    public static function formatTimestamp($timestamp) {
        return date("Y-m-d H:i:s", strtotime($timestamp));
    }

    public static function formatDate($date) {
        return date("Y-m-d", strtotime($date));
    }
}
