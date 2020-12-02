<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;
    protected $table = 'estudiante';
    public $timestamps = false;
    public $incrementing = false;

    public function certificaciones()
    {
        return $this->belongsToMany(TipoCertificacion::class, 'estudiante_tipo_certificacion')
        ->withPivot('recibo_pago_inscripcion', 'recibo_pago_matricula', 'certificado_final_notas');
    }

    public function hasCertificacion($certificacion)
    {
        if ($this->certificaciones()->where('tipo_certificacion_id', $certificacion)->first()) {
            return true;
        }
        return false;
    }

    public function hasAnyCertificacion($certificaciones)
    {
        if (is_array($certificaciones)) {
            foreach ($certificaciones as $certificacion) {
                if ($this->hasCertificacion($certificacion)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($certificaciones)) {
                return true;
            }
        }
        return false;
    }
}
