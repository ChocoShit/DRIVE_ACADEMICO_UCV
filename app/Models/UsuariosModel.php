<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
class UsuariosModel extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuario';

    protected $primaryKey  = 'id_usuario';

    protected $fillable = [
        'username',
        'password',
        'id_tipo_usuario',
    ];

    CONST CREATED_AT = 'fecha_creacion';
    CONST UPDATED_AT = 'fecha_actualizacion';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function getAuthIdentifier()
    {
        return $this->username; // Valor actual del campo NombreUsuario
    }

    public function datosPersona()
    {
        return $this->hasOne(DatosPersona::class, 'id_usuario');
    }

    public function secciones()
    {
        return $this->belongsToMany(Seccion::class, 'docente_seccion', 'id_usuario', 'id_seccion');
    }

    public function carpetas()
    {
        return $this->hasMany(Carpeta::class, 'id_usuario');
    }
}
