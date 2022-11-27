<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Artisan::command('user', function () {
    \App\Models\User::create([
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('1234567890@!')
    ]);
})->describe('Crear admin user');

Artisan::command('categorias', function () {
    $categorias = ['Home','Medicina','Deporte','Tecnología'];
    foreach($categorias as $categoria){
        \App\Models\Categorias::create([
            'nombre' => $categoria,
        ]);
    }
})->describe('Crear categorias');