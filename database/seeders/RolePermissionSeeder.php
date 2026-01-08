<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** LIST PERMISSION **/
        Permission::firstOrCreate(['name' => 'create-seller']);
        Permission::firstOrCreate(['name' => 'read-seller']);
        Permission::firstOrCreate(['name' => 'update-seller']);
        Permission::firstOrCreate(['name' => 'delete-seller']);

        Permission::firstOrCreate(['name' => 'create-customer']);
        Permission::firstOrCreate(['name' => 'read-customer']);
        Permission::firstOrCreate(['name' => 'update-customer']);
        Permission::firstOrCreate(['name' => 'delete-customer']);
    
        Permission::firstOrCreate(['name' => 'create-menu']);
        Permission::firstOrCreate(['name' => 'read-menu']);
        Permission::firstOrCreate(['name' => 'update-menu']);
        Permission::firstOrCreate(['name' => 'delete-menu']);
    
        Permission::firstOrCreate(['name' => 'create-order']);
        Permission::firstOrCreate(['name' => 'read-order']);
        Permission::firstOrCreate(['name' => 'update-order']);
        Permission::firstOrCreate(['name' => 'delete-order']);
    
        Permission::firstOrCreate(['name' => 'create-delivery']);
        Permission::firstOrCreate(['name' => 'read-delivery']);
        Permission::firstOrCreate(['name' => 'update-delivery']);
        Permission::firstOrCreate(['name' => 'delete-delivery']);

        Permission::firstOrCreate(['name' => 'create-tracking']);
        Permission::firstOrCreate(['name' => 'read-tracking']);
        Permission::firstOrCreate(['name' => 'update-tracking']);
        Permission::firstOrCreate(['name' => 'delete-tracking']);

        /** Delivery Services Permissions (Provider Module) **/
        Permission::firstOrCreate(['name' => 'manage_delivery_services']);

        /** LIST ROLE **/
        Role::create(['name'=>'admin']);
        Role::create(['name'=>'seller']);
        Role::create(['name'=>'customer']);

        /** PERMISSION FOR ADMIN **/
        $roleAdmin = Role::findByName('admin');
        $roleAdmin->givePermissionTo('create-seller');
        $roleAdmin->givePermissionTo('read-seller');
        $roleAdmin->givePermissionTo('update-seller');
        $roleAdmin->givePermissionTo('delete-seller');

        $roleAdmin->givePermissionTo('create-customer');
        $roleAdmin->givePermissionTo('read-customer');
        $roleAdmin->givePermissionTo('update-customer');
        $roleAdmin->givePermissionTo('delete-customer');

        $roleAdmin->givePermissionTo('create-menu');
        $roleAdmin->givePermissionTo('read-menu');
        $roleAdmin->givePermissionTo('update-menu');
        $roleAdmin->givePermissionTo('delete-menu');
        
        $roleAdmin->givePermissionTo('create-order');
        $roleAdmin->givePermissionTo('read-order');
        $roleAdmin->givePermissionTo('update-order');
        $roleAdmin->givePermissionTo('delete-order');
        
        $roleAdmin->givePermissionTo('create-delivery');
        $roleAdmin->givePermissionTo('read-delivery');
        $roleAdmin->givePermissionTo('update-delivery');
        $roleAdmin->givePermissionTo('delete-delivery');

        $roleAdmin->givePermissionTo('create-tracking');
        $roleAdmin->givePermissionTo('read-tracking');
        $roleAdmin->givePermissionTo('update-tracking');
        $roleAdmin->givePermissionTo('delete-tracking');

        $roleAdmin->givePermissionTo('manage_delivery_services');

        /** PERMISSION FOR SELLER **/
        $roleSeller = Role::findByName('seller');
        $roleSeller->givePermissionTo('create-menu');
        $roleSeller->givePermissionTo('read-menu');
        $roleSeller->givePermissionTo('update-menu');
        $roleSeller->givePermissionTo('delete-menu');

        $roleSeller->givePermissionTo('create-order');
        $roleSeller->givePermissionTo('read-order');
        $roleSeller->givePermissionTo('update-order');
        $roleSeller->givePermissionTo('delete-order');
        
        $roleSeller->givePermissionTo('create-delivery');
        $roleSeller->givePermissionTo('read-delivery');
        $roleSeller->givePermissionTo('update-delivery');
        $roleSeller->givePermissionTo('delete-delivery');

        $roleSeller->givePermissionTo('create-tracking');
        $roleSeller->givePermissionTo('read-tracking');
        $roleSeller->givePermissionTo('update-tracking');
        $roleSeller->givePermissionTo('delete-tracking');

        /** PERMISSION FOR CUSTOMER **/
        $roleCustomer = Role::findByName('customer');
        $roleCustomer->givePermissionTo('create-customer');
        $roleCustomer->givePermissionTo('read-menu');
        $roleCustomer->givePermissionTo('create-order');
        $roleCustomer->givePermissionTo('read-order');
        $roleCustomer->givePermissionTo('read-tracking');
    }
}
