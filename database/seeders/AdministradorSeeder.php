<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Administrador;
use Illuminate\Support\Facades\Hash;

class AdministradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administradores = Administrador::get();
        foreach ($administradores as $admin) {
            User::insert([
                'cedula' => $admin->cedula,
                'password' => Hash::make($admin->password)
            ]);
            $user = User::where('cedula', $admin->cedula,)->firstOrFail();
            $user->roles()->sync([1, 2, 3]);
        }
    }
}
