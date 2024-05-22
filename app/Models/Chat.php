<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    
    protected $table = 'chats';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'usuario1',
        'usuario2',
        'fecha'
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

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class, 'chat_id');
    }

    public static function formatTimestamp($timestamp) {
        return date("d-m-Y H:i:s", strtotime($timestamp));
    }

    public static function formatDate($date) {
        return date("d-m-Y", strtotime($date));
    }
}
