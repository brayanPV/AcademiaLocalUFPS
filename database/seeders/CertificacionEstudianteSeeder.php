<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Estudiante;
use App\Models\TipoCertificacion;

class CertificacionEstudianteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $estudiantes = Estudiante::get();
        foreach ($estudiantes as $estudiante) {
            $certificacion = $estudiante->id_tipo_certificacion;
           TipoCertificacion::find($certificacion)->estudiantes()->attach($estudiante->id,
            ['recibo_pago_inscripcion' => $estudiante->recibo_pago_inscripcion,
            'recibo_pago_matricula' => $estudiante->recibo_pago_matricula,
            'certificado_final_notas' => $estudiante->certificado_final_notas]);
            /*Estudiante::find($estudiante->id)->certificaciones()->attach($certificacion,
            ['recibo_pago_inscripcion' => $estudiante->recibo_pago_inscripcion,
            'recibo_pago_matricula' => $estudiante->recibo_pago_matricula,
            'certificado_final_notas' => $estudiante->certificado_final_notas]);*/
            //$est =  Estudiante::where('cedula',$estudiante->cedula)->first();
           //$est->certificaciones()->attach([$estudiante->cedula, $certificacion]); 'recibo_pago_inscripcion', 'recibo_pago_matricula', 'certificado_final_notas'
        }
    }
}
