<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Tickets
            'createTicket', 'viewAllTicket', 'editTicket', 'deleteTicket', 'destroyTicket',
            // Messages
            'createMessage', 'editMessage', 'deleteMessage', 'destroyMessage',
            // Users
            'createUser', 'viewAllUser', 'editUser', 'deleteUser', 'destroyUser',
            // Priorities
            'viewAllPriority', 'createPriority', 'editPriority', 'deletePriority',
            // Statuses
            'viewAllStatus', 'createStatus',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $supportRole = Role::firstOrCreate(['name' => 'Support']);
        $userRole = Role::firstOrCreate(['name' => 'User']);

        $adminRole->syncPermissions(Permission::all());

        $supportRole->syncPermissions([
            'viewAllTicket', 'editTicket',
            'createMessage',
            'viewAllUser',
        ]);

        $userRole->syncPermissions([
            'createTicket',
            'createMessage',
            'viewAllPriority',
        ]);
    }
}
