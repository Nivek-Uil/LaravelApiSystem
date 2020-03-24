<?php

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
        $roles = [
            [
                'name' => 'root',
                'display_name' => '开发人员',
                'guard_name' => 'web',
                'created_at' => now()
            ],
            [
                'name' => 'admin',
                'display_name' => '管理员',
                'guard_name' => 'web',
                'created_at' => now()
            ],
            [
                'name' => 'user',
                'display_name' => '用户',
                'guard_name' => 'web',
                'created_at' => now()
            ],
        ];


        Role::insert($roles);
    }
}
