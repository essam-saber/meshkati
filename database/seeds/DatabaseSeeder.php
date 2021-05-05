<?php

namespace Database\Seeders;

use App\AgingAttribute;
use App\InventoryAttribute;
use App\Sale;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->createModulesPermissions();

        $this->seedInventoryAttributes();
            $this->createAdminAccount();
    }

    private function seedInventoryAttributes()
    {
        /**
         * inventory_provision
         * inventory_provision
         */
        DB::table('aging_attributes')->truncate();
        $agingAttributes = [
            '0-90 Days',
            '91-180 Days',
            '181-360 Days',
            '12-18 Months',
            '18-24 Months',
            'More Than 24 Months',
            'Less Credit',
            'A/R Provision'
        ];
        foreach($agingAttributes as $attribute) {
            AgingAttribute::create(['name' => $attribute, 'slug' => Str::slug($attribute)]);
        }
    }

    private function createAdminAccount()
    {
        DB::table('users')->truncate();
        $user = User::factory()->create(['email' => 'admin@meshkati.com', 'password' =>Hash::make(123456)]);
        $user->assignRole('super_admin');
    }

    private function createModulesPermissions()
    {
        $modules = config('modules');
        $permissionsCollection  = [];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('permissions')->truncate();

        foreach($modules as $key => $permissions) {
           foreach($permissions as $permission) {
               $permissionsCollection[] = ['name' =>  $permission.'_'.$key, 'guard_name' => 'web'];
           }
        }
        $role = Role::create(['name' => 'super_admin', 'guard_name' => 'web']);
        DB::table('permissions')->insert($permissionsCollection);
        $permissions = Permission::all();
        $role->syncPermissions($permissions);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }

    private function mergeModulesPermissions($permissions, &$permissionsCollection)
    {
        foreach($permissions as $key => $value) {
           if(is_array($value)) {
               $this->mergeModulesPermissions($value, $permissionsCollection);
           } else {
               $permissionsCollection[] = strtolower( "{$value} {$key}");
           }
        }
    }
}
