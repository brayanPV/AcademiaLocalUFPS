<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role = new Role();
        $role->nombre = 'administrador';
        $role->descripcion = 'administrador';
        $role->save();        
        $role = new Role();
        $role->nombre = 'profesor';
        $role->descripcion = 'profesor';
        $role->save();
        $role = new Role();
        $role->nombre = 'estudiante';
        $role->descripcion = 'estudiante';
        $role->save();
    }
}
