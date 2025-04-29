<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Department::truncate();
		$tbl_data = array(
		  array('name' => 'Intake team','created_at' => '2025-04-29 08:26:04','updated_at' => '2025-04-29 08:26:04'),
		  array('name' => 'On call team','created_at' => '2025-04-29 08:26:04','updated_at' => '2025-04-29 08:26:04'),
		  array('name' => 'Care team','created_at' => '2025-04-29 08:26:04','updated_at' => '2025-04-29 08:26:04')
		);
		\App\Models\Department::insert($tbl_data);
    }
}
