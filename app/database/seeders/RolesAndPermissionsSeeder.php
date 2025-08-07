<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos
        $permissions = [
            'manage_products',
            'view_products',
            'create_invoices',
            'view_invoices',
            'edit_invoices',
            'delete_invoices',
            'manage_customers',
            'view_customers',
            'manage_users',
            'view_users',
            'view_reports',
            'view_dashboard',
            'manage_payments',
            'view_payments',
            'approve_payments',
            'reject_payments',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Crear roles
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole = Role::create(['name' => 'Administrador']);

        $secretarioRole = Role::create(['name' => 'Secretario']);
        $bodegaRole = Role::create(['name' => 'Bodega']);
        $ventasRole = Role::create(['name' => 'Ventas']);
        $pagosRole = Role::create(['name' => 'Pagos']);

        // Asignar permisos a roles

        // Administrador: Todos los permisos
        $adminRole->givePermissionTo(Permission::all());

        // Secretario: Solo ver dashboard, reportes y clientes
        $secretarioRole->givePermissionTo([
            'view_dashboard',
            'view_reports',
            'view_customers',
            'manage_customers',
            'view_users',
        ]);

        // Bodega: Solo productos
        $bodegaRole->givePermissionTo([
            'view_dashboard',
            'manage_products',
            'view_products',
        ]);

        // Ventas: Solo facturación y clientes
        $ventasRole->givePermissionTo([
            'view_dashboard',
            'create_invoices',
            'view_invoices',
            'edit_invoices',
            'delete_invoices',
            'view_customers',
            'manage_customers',
            'view_products', // Necesario para crear facturas
        ]);

        // Pagos: Solo gestión de pagos
        $pagosRole->givePermissionTo([
            'view_dashboard',
            'manage_payments',
            'view_payments',
            'approve_payments',
            'reject_payments',
            'view_invoices',
            'view_customers',
        ]);
    }
}
