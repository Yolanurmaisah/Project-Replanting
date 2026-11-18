<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('riwayat_tahap', function (Blueprint $t) {
            $t->id();
            $t->foreignId('kebun_id')->constrained('kebun')->cascadeOnDelete();
            $t->foreignId('tahapan_id')->constrained('tahapan');
            $t->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $t->date('tanggal');
            $t->text('catatan')->nullable();
            $t->string('foto')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_tahap');
    }
};
