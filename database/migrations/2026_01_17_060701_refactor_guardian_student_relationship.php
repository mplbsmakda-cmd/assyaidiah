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
        // Hapus foreign key dan kolom student_id dari tabel guardians
        Schema::table('guardians', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropColumn('student_id');
        });

        // Tambahkan kolom guardian_id ke tabel students
        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('guardian_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tambahkan kembali kolom student_id ke tabel guardians
        Schema::table('guardians', function (Blueprint $table) {
            $table->foreignId('student_id')->nullable()->constrained()->onDelete('cascade');
        });

        // Hapus foreign key dan kolom guardian_id dari tabel students
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['guardian_id']);
            $table->dropColumn('guardian_id');
        });
    }
};
