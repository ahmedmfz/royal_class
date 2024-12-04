<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
    */
    public function run(): void
    {
        DB::table('roles')->delete();
        DB::table('model_has_roles')->delete();
        DB::table('model_has_permissions')->delete();

        app()['cache']->forget('spatie.permission.cache');

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $adminRole   =  Role::create(['name' => 'admin']);
        $userRole    =  Role::create(['name' => 'user']);
        $viewerRole  =  Role::create(['name' => 'viewer']);

        $adminPermissions = [
            // documents
            'documents.access',
            'documents.create',
            'documents.delete',
        ];

        foreach ($adminPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        $adminRole->givePermissionTo($adminPermissions);
        $admin = User::find(1); //as dummy data
        if($admin){
            $admin->assignRole('admin');
        }
    }
}
