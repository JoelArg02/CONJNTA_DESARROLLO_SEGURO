<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersWithRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Administrador - Acceso completo
        $admin = User::create([
            'name' => 'Administrador Principal',
            'email' => 'admin@empresa.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        $admin->assignRole('Administrador');

        // Secretario - Gestión de clientes y reportes
        $secretario = User::create([
            'name' => 'María Secretaria',
            'email' => 'secretario@empresa.com',
            'password' => Hash::make('secre123'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        $secretario->assignRole('Secretario');

        // Bodega - Gestión de productos
        $bodega = User::create([
            'name' => 'Carlos Bodeguero',
            'email' => 'bodega@empresa.com',
            'password' => Hash::make('bodega123'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        $bodega->assignRole('Bodega');

        // Ventas - Creación de facturas
        $ventas = User::create([
            'name' => 'Ana Vendedora',
            'email' => 'ventas@empresa.com',
            'password' => Hash::make('ventas123'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        $ventas->assignRole('Ventas');

        // Usuario con múltiples roles - Bodega y Ventas
        $multiRol = User::create([
            'name' => 'Luis Supervisor',
            'email' => 'supervisor@empresa.com',
            'password' => Hash::make('super123'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        $multiRol->assignRole(['Bodega', 'Ventas']);

        // Otro Administrador
        $admin2 = User::create([
            'name' => 'Juan Admin',
            'email' => 'juan.admin@empresa.com',
            'password' => Hash::make('admin456'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        $admin2->assignRole('Administrador');

        $this->command->info('✓ Usuarios con roles creados correctamente');
        $this->command->table(
            ['Usuario', 'Email', 'Roles', 'Contraseña'],
            [
                ['Administrador Principal', 'admin@empresa.com', 'Administrador', 'admin123'],
                ['María Secretaria', 'secretario@empresa.com', 'Secretario', 'secre123'],
                ['Carlos Bodeguero', 'bodega@empresa.com', 'Bodega', 'bodega123'],
                ['Ana Vendedora', 'ventas@empresa.com', 'Ventas', 'ventas123'],
                ['Luis Supervisor', 'supervisor@empresa.com', 'Bodega, Ventas', 'super123'],
                ['Juan Admin', 'juan.admin@empresa.com', 'Administrador', 'admin456'],
            ]
        );
    }
}
