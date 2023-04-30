<?php

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('users')->insert([
            ['email' => '123@mail.ru', 'password' => Hash::make('123')],
            ['email' => 'test@inbox.ru', 'password' => Hash::make('test')],
            ['email' => 'test@yandex.ru', 'password' => Hash::make('test')],
            ['email' => 'sail@gmail.com', 'password' => Hash::make('sail')],
        ]);
    }
}