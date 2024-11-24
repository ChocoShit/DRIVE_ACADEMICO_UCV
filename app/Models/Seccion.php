<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    use HasFactory;
    protected $table = 'secciones';
    protected $primaryKey = 'id_seccion';

    protected $fillable = [
        'nombre_seccion',
        'id_curso',
        'estado'
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso');
    }

    public function alumnos()
    {
        return $this->hasMany(Alumno::class, 'id_seccion');
    }
}
