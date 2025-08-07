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
            $table->softDeletes();
            $table->string('soft_delete_reason')->nullable()->after('notes');
            $table->foreignId('soft_deleted_by')->nullable()->constrained('users')->after('soft_delete_reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn(['soft_delete_reason', 'soft_deleted_by']);
        });
    }
};
