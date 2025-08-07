<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;

class InvoicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::all();
        $products = Product::all();
        $users = User::all();

        if ($customers->isEmpty() || $products->isEmpty() || $users->isEmpty()) {
            $this->command->warn('No hay clientes, productos o usuarios. Por favor, ejecuta los seeders correspondientes primero.');
            return;
        }

        $statuses = ['paid', 'pending', 'overdue'];
        
        for ($i = 1; $i <= 15; $i++) {
            $customer = $customers->random();
            $user = $users->random();
            $status = $statuses[array_rand($statuses)];
            
            $subtotal = 0;
            $tax_rate = 0.18; // 18% IGV

            $invoice = Invoice::create([
                'customer_id' => $customer->id,
                'invoice_number' => 'FAC-' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'subtotal' => 0, // Se calculará después
                'tax_amount' => 0, // Se calculará después
                'total' => 0, // Se calculará después
                'status' => $status,
                'notes' => 'Factura generada automáticamente para pruebas',
                'issued_at' => now()->subDays(rand(0, 30)),
                'created_by' => $user->id,
            ]);

            // Agregar items a la factura
            $numItems = rand(1, 4);
            for ($j = 0; $j < $numItems; $j++) {
                $product = $products->random();
                $quantity = rand(1, 5);
                $unit_price = $product->sale_price ?? $product->price;
                $item_subtotal = $quantity * $unit_price;
                
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $product->id,
                    'description' => $product->name,
                    'quantity' => $quantity,
                    'unit_price' => $unit_price,
                    'subtotal' => $item_subtotal,
                ]);

                $subtotal += $item_subtotal;
            }

            // Calcular totales
            $tax_amount = $subtotal * $tax_rate;
            $total = $subtotal + $tax_amount;

            // Actualizar la factura con los totales
            $invoice->update([
                'subtotal' => $subtotal,
                'tax_amount' => $tax_amount,
                'total' => $total,
            ]);
        }

        $this->command->info('✓ Se han creado 15 facturas de ejemplo');
    }
}
