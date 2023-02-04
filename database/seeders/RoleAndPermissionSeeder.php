<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Product Permissions
        Permission::create(['name'=>'create-product']);
        Permission::create(['name'=>'edit-product']);
        Permission::create(['name'=>'delete-product']);
        // Cart Permissions
        Permission::create(['name'=>'create-cart']);
        Permission::create(['name'=>'view-cart']);
        Permission::create(['name'=>'edit-cart']);
        Permission::create(['name'=>'delete-cart']);
        //QR Permissions
        Permission::create(['name' => 'create-qr']);
        Permission::create(['name'=>'read-qr']);
        // Category Permissions
        Permission::create(['name'=>'create-category']);
        Permission::create(['name'=>'edit-category']);
        Permission::create(['name'=>'delete-category']);
        //Roles
        $sellerRole = Role::create(['guard_name'=>'api','name'=>'Seller']);
        $customerRole = Role::create(['guard_name'=>'api','name'=>'Customer']);


        $sellerRole->givePermissionTo([
            'create-product',
            'edit-product',
            'delete-product',

            'create-cart',
            'view-cart',
            'edit-cart',
            'delete-cart',

            'create-qr',
            'read-qr',

            'create-category',
            'edit-category',
            'delete-category',
        ]);

        $customerRole->givePermissionTo([
            'create-cart',
            'view-cart',
            'edit-cart',
            'delete-cart',

            'create-qr',
        ]);
    }
}
