<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCertificacion extends Model
{
    //use HasFactory;
    protected $table = 'tipo_certificacion';
    public $timestamps = false;

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'estudiante_tipo_certificacion')
        ->withPivot('recibo_pago_inscripcion', 'recibo_pago_matricula', 'certificado_final_notas');
    }

    public function hasStudent($estudiante)
    {
        if ($this->estudiantes()->where('cedula', $estudiante)->first()) {
            return true;
        }
        return false;
    }
}
