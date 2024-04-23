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
     * Get the authenticated user reports
     *
     * @return Informe[]
     */
    public function getInformes() {
        $user = User::getAuthenticatedUser();
        $userRole = User::getRole();

        if($userRole === 'Medico') {
            $informes = Informe::where('medico_id', $user->id)->get();
        }elseif ($userRole === 'Paciente') {
            $informes = Informe::where('paciente_id', $user->id)->get();
        }else {
            $informes = Informe::all();
        }

        return $informes;
    }

    /**
     * Get the authenticated user data
     */
    public function getDatosPaciente() {
        $usuario = User::getAuthenticatedUser();

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
