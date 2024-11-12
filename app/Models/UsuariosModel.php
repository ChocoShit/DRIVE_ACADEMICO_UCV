<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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

}
