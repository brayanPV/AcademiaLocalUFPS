<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class ProfesorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::insert([
            'cedula' => '19322620',
            'password' => Hash::make('Cepg2483')
        ]);
        $user = User::where('cedula', '19322620')->firstOrFail();
        $user->roles()->sync([2,3]);

        User::insert([
            'cedula' => '123456',
            'password' => Hash::make('123456')
        ]);
        $user = User::where('cedula', '123456')->firstOrFail();
        $user->roles()->sync([2,3]);
    }
}
