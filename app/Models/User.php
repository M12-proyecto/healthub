<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    protected $table = 'usuarios';

    /**
     * The access token model name.
     *
     * @var string
     */
    protected $tokens = SanctumPersonalAccessToken::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dni',
        'cip',
        'password',
        'nombre',
        'apellido1',
        'apellido2',
        'fecha_nacimiento',
        'sexo',
        'foto'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'contraseña' => 'hashed',
    ];

    /**
     * Get the authenticated user
     *
     * @return User
     */
    public static function getAuthenticatedUser() {
        $usuario = User::find(session()->get('user')->id);

        return $usuario;
    }

    /**
     * Get the authenticated user role
     *
     * @return Role
     */
    public static function getRole() {
        $usuario = User::getAuthenticatedUser();

        $rol = DB::table('roles')
            ->join('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('model_has_roles.model_type', '=', 'App\Models\User')
            ->where('model_has_roles.model_id', '=', $usuario->id)
            ->select('roles.*')
            ->first();

        return $rol->name;
    }

    /**
     * Get the authenticated user appointments
     *
     * @return Citas[]
     */
    public static function getCitas() {
        $usuario = User::getAuthenticatedUser();
        $rolUsuario = User::getRole();

        if($rolUsuario === 'Medico') {
            $citas = Cita::where('medico_id', $usuario->id)->orderBy('fecha')->orderBy('hora')->get();
        }else if($rolUsuario === 'Paciente') {
            $citas = Cita::where('paciente_id', $usuario->id)->orderBy('fecha')->orderBy('hora')->get();
        }else {
            $citas = Cita::orderBy('fecha')->orderBy('hora')->get();
        }

        return $citas;
    }

    /**
     * Get the authenticated user reports
     *
     * @return Informe[]
     */
    public static function getInformes() {
        $usuario = User::getAuthenticatedUser();
        $rolUsuario = User::getRole();

        if($rolUsuario === 'Medico') {
            $informes = Informe::where('medico_id', $usuario->id)->orderBy('created_at')->get();
        }else if($rolUsuario === 'Paciente') {
            $informes = Informe::where('paciente_id', $usuario->id)->orderBy('created_at')->get();
        }else {
            $informes = Informe::orderBy('created_at')->get();
        }

        return $informes;
    }

    /**
     * Get the authenticated user reports
     *
     * @return Resultado[]
     */
    public static function getResultados() {
        $usuario = User::getAuthenticatedUser();
        $rolUsuario = User::getRole();

        if($rolUsuario === 'Medico') {
            $resultados = Resultado::where('medico_id', $usuario->id)->orderBy('fecha')->get();
        }else if($rolUsuario === 'Paciente') {
            $resultados = Resultado::where('paciente_id', $usuario->id)->orderBy('fecha')->get();
        }else {
            $resultados = Resultado::orderBy('fecha')->get();
        }

        return $resultados;
    }

    /**
     * Get the authenticated user data
     */
    public function getDatosPaciente(User $usuario = null) {
        if(!$usuario) {
            $usuario = User::getAuthenticatedUser();
        }

        $datos = DB::table('pacientes')
            ->where('usuario_id', '=', $usuario->id)
            ->select('pacientes.*')
            ->first();

        return $datos;
    }

     /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id')
            ->where('model_type', User::class);
    }
}
