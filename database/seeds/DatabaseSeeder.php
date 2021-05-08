<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Federico Espinasse',
            'email' => 'fede.eer8@gmail.com',
            'password' => bcrypt('1234567890'),
            'rol' => 'administrador',
        ]);
    }
}
