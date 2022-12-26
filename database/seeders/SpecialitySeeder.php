<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Speciality;

class SpecialitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Speciality::create(array('name' => 'Хирург'));
        Speciality::create(array('name' => 'Терапевт'));
        Speciality::create(array('name' => 'Отоларинголог'));
        Speciality::create(array('name' => 'Дерматолог'));
        Speciality::create(array('name' => 'Педиатр'));
    }
}
