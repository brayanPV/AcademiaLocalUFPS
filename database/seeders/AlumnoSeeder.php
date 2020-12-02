<?php

namespace Database\Seeders;

use App\Models\Estudiante;
use App\Models\Alumno;
use Illuminate\Database\Seeder;

class AlumnoSeeder extends Seeder
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
            Alumno::insert([
                'cedula' => $estudiante->cedula,
                'cod_estudiante' =>$estudiante->cod_estudiante,
                'id_cisco' => $estudiante->id_cisco,
                'id_tesis' => $estudiante->id_tesis,
                'recibo_pago_matricula' => $estudiante->recibo_pago_matricula,
                'recibo_pago_inscripcion' => $estudiante->recibo_pago_inscripcion,
                'certificado_final_notas' => $estudiante->certificado_final_notas,
                'password' => $estudiante->password,
                'id_tipo_certificacion' => $estudiante->id_tipo_certificacion
            ]);
        }
    }
}
