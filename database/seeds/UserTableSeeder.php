<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        User::create([
            'username'  => 'Admin',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'image' => 'profiles/admin',
            'password' => bcrypt('admin')
        ]);
        User::create([
            'username'  => 'Director',
            'email' => 'director@director.com',
            'role' => 'director',
            'image' => 'profiles/director',
            'password' => bcrypt('director')
        ]);
        User::create([
            'username'  => 'Investigador',
            'email' => 'investigador@investigador.com',
            'role' => 'investigador',
            'image' => 'profiles/investigador',
            'password' => bcrypt('investigador')
        ]);
        User::create([
            'username'  => 'Becario',
            'email' => 'becario@becario.com',
            'image' => 'profiles/default',
            'password' => bcrypt('becario')
        ]);
        factory(User::class, 10)->create();

    }
}
