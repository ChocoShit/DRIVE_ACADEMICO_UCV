<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carpeta extends Model
{
    use HasFactory;
    protected $table = 'carpetas';
    protected $primaryKey = 'id_carpeta';

    protected $fillable = [
        'id_alumno',
        'nombre_carpeta',
        'porcentaje_completado',
        'estado'
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'id_alumno');
    }
    public function documentos()
    {
        return $this->hasMany(Archivo::class, 'id_carpeta');
    }
}
