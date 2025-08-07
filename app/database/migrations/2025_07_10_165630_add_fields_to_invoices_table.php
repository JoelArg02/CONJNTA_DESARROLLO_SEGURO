<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('invoice_number')->unique()->after('id');
            $table->decimal('subtotal', 10, 2)->default(0)->after('customer_id');
            $table->decimal('tax_amount', 10, 2)->default(0)->after('subtotal');
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending')->after('total');
            $table->text('notes')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['invoice_number', 'subtotal', 'tax_amount', 'status', 'notes']);
        });
    }
};
