<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    // Currently only web guard will be used
    private const WEB_GUARD_NAME = 'web';

    // Roles
    private const SUPER_ADMIN_ROLE_NAME = 'Super Admin';
    private const ADMIN_ROLE_NAME = 'Admin';
    private const EDITOR_ROLE_NAME = 'Editor';
    private const VIEWER_ROLE_NAME = 'Viewer';

    // Permissions
    private const VIEW_USER = 'view-user';
    private const EDIT_USER = 'edit-user';
    private const VIEW_ROLE = 'view-role';
    private const EDIT_ROLE = 'edit-role';
    private const VIEW_PERMISSION = 'view-permission';
    private const EDIT_PERMISSION = 'edit-permission';
    private const VIEW_AD_PERMISSION_NAME = 'view-ad';
    private const EDIT_AD_PERMISSION_NAME = 'edit-ad';
    private const VIEW_AD_TEMPLATE_NAME = 'view-ad-template';
    private const EDIT_AD_TEMPLATE_NAME = 'edit-ad-template';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define permissions
        $permissions = [
            self::VIEW_USER => self::VIEW_USER,
            self::EDIT_USER => self::EDIT_USER,
            self::VIEW_ROLE => self::VIEW_ROLE,
            self::EDIT_ROLE => self::EDIT_ROLE,
            self::VIEW_PERMISSION => self::VIEW_PERMISSION,
            self::EDIT_PERMISSION => self::EDIT_PERMISSION,
            self::VIEW_AD_PERMISSION_NAME => self::VIEW_AD_PERMISSION_NAME,
            self::EDIT_AD_PERMISSION_NAME => self::EDIT_AD_PERMISSION_NAME,
            self::VIEW_AD_TEMPLATE_NAME => self::VIEW_AD_TEMPLATE_NAME,
            self::EDIT_AD_TEMPLATE_NAME => self::EDIT_AD_TEMPLATE_NAME,
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => self::WEB_GUARD_NAME]);
        }

        // Define roles and assign permissions
        $roles = [
            self::SUPER_ADMIN_ROLE_NAME => array_values($permissions),
            self::ADMIN_ROLE_NAME => [
                self::VIEW_USER,
                self::VIEW_ROLE,
                self::VIEW_PERMISSION,
                self::VIEW_AD_PERMISSION_NAME,
                self::EDIT_AD_PERMISSION_NAME,
                self::VIEW_AD_TEMPLATE_NAME,
//                self::EDIT_AD_TEMPLATE_NAME,
            ],
            self::EDITOR_ROLE_NAME => [
                self::VIEW_AD_PERMISSION_NAME,
                self::EDIT_AD_PERMISSION_NAME,
                self::VIEW_AD_TEMPLATE_NAME,
                self::EDIT_AD_TEMPLATE_NAME,
            ],
            self::VIEWER_ROLE_NAME => [
                self::VIEW_AD_PERMISSION_NAME,
                self::VIEW_AD_TEMPLATE_NAME,
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => self::WEB_GUARD_NAME]);
            $role->syncPermissions($rolePermissions); // Assign permissions to the role
        }

        $this->command->info('Roles and permissions seeded successfully!');
    }
}
