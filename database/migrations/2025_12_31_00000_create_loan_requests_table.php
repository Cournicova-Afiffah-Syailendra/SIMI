<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_requests', function (Blueprint $table) {
            $table->id();
            $table->string('borrower_name');
            $table->string('organization')->nullable();
            $table->foreignId('inventory_id')->constrained('inventories')->cascadeOnDelete();
            $table->unsignedInteger('duration_days');
            $table->string('surat_link')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_requests');
    }
};