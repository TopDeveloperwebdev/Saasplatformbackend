<?php
use App\Role;
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
                'id'         => 1,
                'role'      => 'Super administrator',
                'permissions' => '["order_access","ingredients_access","doctors_access","services_access","patients_access","medication_access","resources_access","emailtemplates_access","roles_access","permissions_access","pharmacies_access","instances_access","insurances_access"]'             
             
            ]
          
        ];

        Role::insert($roles);
    }
}
