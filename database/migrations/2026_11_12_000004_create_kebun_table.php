<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kebun', function (Blueprint $t) {
            $t->id();
            $t->foreignId('petani_id')->constrained('petani')->cascadeOnDelete();
            $t->foreignId('tahapan_id')->constrained('tahapan');
            $t->string('nama_kebun', 100);
            $t->string('lokasi', 150);
            $t->decimal('luas_ha', 8, 2);
            $t->year('tahun_tanam');
            $t->date('tanggal_tanam_ulang')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kebun');
    }
};
