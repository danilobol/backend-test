<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = new Permission();
        $permission->fill([
            'name' => 'index.user',
            'description' => 'Listar usuários'
        ])->save();

        Role::where('name', 'Admin')->first()->addPermission($permission);

        $permission = new Permission();
        $permission->fill([
            'name' => 'create.groups',
            'description' => 'Criar grupo'
        ])->save();
        Role::where('name', 'Admin')->first()->addPermission($permission);

        $permission = new Permission();
        $permission->fill([
            'name' => 'update.groups',
            'description' => 'Update'
        ])->save();

        Role::where('name', 'Admin')->first()->addPermission($permission);


        $permission = new Permission();
        $permission->fill([
            'name' => 'delete.group',
            'description' => 'Delete'
        ])->save();

        Role::where('name', 'Admin')->first()->addPermission($permission);
    }
}
