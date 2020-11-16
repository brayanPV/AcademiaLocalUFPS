<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Estudiante;
use Illuminate\Support\Facades\Hash;

class EstudianteSeeder extends Seeder
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
            User::insert([
                'cedula' => $estudiante->cedula,
                'password' => Hash::make($estudiante->password)
            ]);
            $user = User::where('cedula', $estudiante->cedula,)->firstOrFail();
            $user->roles()->sync([3]);
        }
    }
}
