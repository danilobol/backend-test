<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([ 'name' => 'Admin', 'description' => 'Full system access']);
        DB::table('roles')->insert([ 'name' => 'User', 'description' => 'Access to user functions']);
    }
}
