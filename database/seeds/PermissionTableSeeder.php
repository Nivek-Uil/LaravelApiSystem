<?php

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
        //初始化多级权限配置
        $permissions = [
            [
                'name' => 'system',
                'display_name' => '系统管理',
                'url' => '#',
                'type' => 1,
                'icon' => 'component',
                'children' => [
                    [
                        'name' => 'system.user',
                        'display_name' => '用户管理',
                        'url' => '/system/user/index',
                        'type' => 1,
                        'icon' => 'user',
                        'children' => [
                            ['name' => 'system.user.list', 'display_name' => '账号列表', 'url' => '/system/user/list', 'type' => 1, 'icon' => ''],
                            ['name' => 'system.user.create', 'display_name' => '添加用户', 'type' => 2],
                            ['name' => 'system.user.update', 'display_name' => '编辑用户', 'type' => 2],
                            ['name' => 'system.user.show', 'display_name' => '查看用户', 'url' => '/system/user/show', 'type' => 1],
                            ['name' => 'system.user.enable', 'display_name' => '账号启用', 'type' => 2],
                            ['name' => 'system.user.disable', 'display_name' => '账号禁用', 'type' => 2],
                            ['name' => 'system.user.destroy', 'display_name' => '删除用户', 'type' => 2],
                            ['name' => 'system.user.role', 'display_name' => '分配角色', 'type' => 2],
                            ['name' => 'system.user.permission', 'display_name' => '分配权限', 'type' => 2],
                        ]
                    ],
                    [
                        'name' => 'system.role',
                        'display_name' => '角色管理',
                        'url' => '/system/role',
                        'type' => 1,
                        'icon' => 'setting',
                        'children' => [
                            ['name' => 'system.role.list', 'display_name' => '角色列表', 'url' => 'system/role/list', 'type' => 1, 'icon' => ''],
                            ['name' => 'system.role.create', 'display_name' => '添加角色', 'type' => 2],
                            ['name' => 'system.role.edit', 'display_name' => '编辑角色', 'type' => 2],
                            ['name' => 'system.role.destroy', 'display_name' => '删除角色', 'type' => 2],
                            ['name' => 'system.role.permission', 'display_name' => '分配权限', 'type' => 2],
                        ]
                    ],
                    [
                        'name' => 'system.permission',
                        'display_name' => '权限管理',
                        'url' => '/system/permission/index',
                        'type' => 1,
                        'icon' => 'setting',
                        'children' => [
                            ['name' => 'system.permission.list', 'display_name' => '权限列表', 'url' => '/system/permission/list', 'type' => 1, 'icon' => ''],
                            ['name' => 'system.permission.create', 'display_name' => '添加权限',  'type' => 2],
                            ['name' => 'system.permission.edit', 'display_name' => '编辑权限',  'type' => 2],
                            ['name' => 'system.permission.destroy', 'display_name' => '删除权限',  'type' => 2],
                        ]
                    ],
                    [
                        'name' => 'system.log',
                        'display_name' => '日志管理',
                        'url' => '/system/log',
                        'type' => 1,
                        'icon' => 'setting',
                        'children' => [
                            [
                                'name' => 'system.log.login',
                                'display_name' => '登录日志',
                                'url' => '/system/log/login',
                                'type' => 1,
                                'icon' => 'setting',
                                'children' => [
                                    ['name' => 'system.log.login.list', 'display_name' => '登录日志列表', 'url' => 'system/log/list', 'type' => 1, 'icon' => ''],
                                    ['name' => 'system.log.login.delete', 'display_name' => '删除登录日志','type' => 2]
                                ]
                            ],
                            [
                                'name' => 'system.log.operate',
                                'display_name' => '操作日志',
                                'url' => '/system/log/operate',
                                'type' => 1,
                                'icon' => 'setting',
                                'children' => [
                                    ['name' => 'system.log.operate.list', 'display_name' => '操作日志列表', 'url' => 'system/operate/list', 'type' => 1, 'icon' => ''],
                                    ['name' => 'system.log.operate.delete', 'display_name' => '删除操作日志', 'type' => 2]
                                ]
                            ]
                        ]
                    ],
                ]
            ],
        ];

        // 递归生成权限
        $this->createPermission($permissions);

        // 为角色赋予权限
        $root = Role::where('name', 'root')->first();
        $admin = Role::where('name', 'admin')->first();

        $pms = Permission::all()->pluck('name')->toArray();
        $root->givePermissionTo($pms);
        $admin->givePermissionTo($pms);

        // 移除部分不属于管理员的权限
        $admin->revokePermissionTo([
            'system.log',
            'system.log.login',
            'system.log.login.list',
            'system.log.login.delete',
            'system.log.operate',
            'system.log.operate.list',
            'system.log.operate.delete',
        ]);
    }

    /**
     * 生成权限
     * @param array $permission 权限数组
     * @param int $pid 父级权限id
     * @return
     */
    protected function createPermission($permission, $pid = 0): bool
    {
        foreach ($permission as $item) {

            $data_arr = [
                'name' => $item['name'],
                'display_name' => $item['display_name'],
                'url' => $item['url'] ?? '',
                'type' => $item['type'] ?? 0,
                'icon' => $item['icon'] ?? '',
                'parent_id' => $pid,
                'guard_name' => 'web'
            ];

            $pm = Permission::create($data_arr);

            if (isset($item['children'])) {
                $this->createPermission($item['children'], $pm->id);
            }
        }

        return true;
    }
}
