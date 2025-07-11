<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {

        $this->call([
            DashboardTableSeeder::class,
            TicketStatusSeeder::class,
            TicketCategorySeeder::class,
        ]);

        // Spatie roles and permissions
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $agentRole = Role::firstOrCreate(['name' => 'Agent']);
        $userRole = Role::firstOrCreate(['name' => 'User']);

        $permissions = [
            'manage tickets',
            'view tickets',
            'create tickets',
            'edit tickets',
            'delete tickets',
            'manage users',
            'manage roles',
            'view reports',
            'view audits',
            'manage permissions',
            'view ai',
            'manage ai',
        ];
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }
        $adminRole->givePermissionTo(Permission::all());
        $agentRole->givePermissionTo([
            'manage tickets', 'view tickets', 'create tickets', 'edit tickets', 'delete tickets', 'view ai'
        ]);
        $userRole->givePermissionTo(['view tickets', 'view ai']);

        // Create default admin user
        $admin = \App\Models\User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('12345678'),
            ]
        );
        $admin->assignRole('Admin');
    }
}
