<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notifikasi', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $t->foreignId('kebun_id')->nullable()->constrained('kebun')->cascadeOnDelete();
            $t->string('judul', 150);
            $t->text('pesan');
            $t->enum('jenis', ['mendekati', 'siap', 'tahap']);
            $t->boolean('sudah_dibaca')->default(false);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
