<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loan_requests', function (Blueprint $table) {
            // URL file di Google Drive (bukan upload lokal)
            $table->string('bukti_transfer_url')->nullable()->after('surat_link');
            $table->string('surat_file_url')->nullable()->after('bukti_transfer_url');

            // Tambah user_id agar peminjam terhubung ke akun user
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('loan_requests', function (Blueprint $table) {
            $table->dropColumn(['bukti_transfer_url', 'surat_file_url']);
            $table->dropForeignIdFor(\App\Models\User::class);
        });
    }
};
