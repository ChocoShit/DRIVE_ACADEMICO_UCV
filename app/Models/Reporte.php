<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    use HasFactory;
    protected $table = 'reportes';
    protected $primaryKey = 'id_reporte';

    protected $fillable = [
        'id_alumno',
        'tipo_reporte', // 'individual' o 'seccion'
        'id_curso',
        'id_seccion',
        'porcentaje_progreso',
        'fecha_generacion',
        'ruta_archivo'
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'id_alumno');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso');
    }

    public function seccion()
    {
        return $this->belongsTo(Seccion::class, 'id_seccion');
    }
}
