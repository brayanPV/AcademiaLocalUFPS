<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\CursoEstudiante;
use App\Models\Nota;
use App\Models\TipoNota;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class NotasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //llenar la tabla curso_estudiante con sus correspondientes notas
        $notas = Nota::select(
            'n.ced_estudiante',
            'n.valor',
            'n.fecha',
            'n.certificado',
            't.id',
            't.nombre',
            't.id_tipo_certificacion'
        )->from('nota as n')
            ->join('notas as t', function ($join) {
                $join->on('n.id_tiponota', '=', 't.id');
            })->get()->sortBy('n.ced_estudiante');
        $tipoNotas = TipoNota::get();
        //$cursito = [];
        $cont = 0;
        foreach ($notas as $nota) {
            foreach ($tipoNotas as $noticas) {
                if ($nota->nombre == $noticas->nombre) {
                    $cont++;
                    //var_dump($nota->nombre. "==" .$noticas->nombre . " cedula " . $nota->ced_estudiante);
                    // var_dump($cont);
                    //var_dump($nota);
                    //ultima letra del nombre de la nota ejemplo NOTA FINAL MODULO 1 rta = 1
                    $ultimo = $nota->nombre[strlen($nota->nombre) - 1];
                    //id de la nota con el nombre de arriba
                    $certificacion = $nota->id_tipo_certificacion;

                    $notica_id = TipoNota::where('nombre', '=', $noticas->nombre)->first();

                    $cursito = Curso::select('c.id', 'c.id_modulo', 'c.ced_profesor')
                        ->from('curso as c')
                        ->join('modulo as m', function ($join) use ($ultimo, $certificacion) {
                            $join->on('c.id_modulo', '=', 'm.id')
                                ->where('m.numero', '=', $ultimo)
                                ->where('m.id_tipo_certificacion', '=', $certificacion);
                        })->first();
                    //dd($cursito->id);    
                    CursoEstudiante::where([['ced_estudiante', $nota->ced_estudiante], ['id_curso', '=', $cursito->id]])
                        ->update([
                            'valor' => $nota->valor, 'tipo_nota_id' => $notica_id->id,
                            'certificado' => $nota->certificado, 'fecha' => $nota->fecha
                        ]);
                }
                // var_dump("voy a meter la nota " . $nota->valor . " del curso " .$cursito->id . " al estudiante " . $nota->ced_estudiante . " modulo " .$notica_id->nombre . " certificcion " . $nota->id_tipo_certificacion);
            }
            //dd($cursito);
            //var_dump("voy a meter la nota " . $nota->valor . " del curso " .$cursito->id . " al estudiante " . $nota->ced_estudiante . " modulo " .$notica_id->nombre . " certificcion " . $nota->id_tipo_certificacion);
            /*  CursoEstudiante::where([['ced_estudiante', $nota->ced_estudiante], ['id_curso', '=', $cursito->id]])
                        ->update([
                            'valor' => $nota->valor, 'tipo_nota_id' => $notica_id->id,
                            'certificado' => $nota->certificado, 'fecha' => $nota->fecha
                        ]);*/
        }
        var_dump("al final realice " . $cont . " inserciones");
        /*$ce = CursoEstudiante::get();
        foreach ($ce as $c) {
            CursoEstudiante::where('ced_estudiante', $c->ced_estudiante)
                ->update([
                    'valor' => null, 'tipo_nota_id' => null,
                    'certificado' => null, 'fecha' => null, 'fecha' => null
                ]);
        }*/
    }
}
