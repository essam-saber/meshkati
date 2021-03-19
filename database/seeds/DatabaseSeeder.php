<?php

namespace Database\Seeders;

use App\AgingAttribute;
use App\InventoryAttribute;
use App\Sale;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        $user = User::factory()->create(['email' => 'admin@meshkati.com', 'password' => bcrypt('123456')]);

    }
}
