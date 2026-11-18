<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('panduan', function (Blueprint $t) {
            $t->id();
            $t->foreignId('tahapan_id')->constrained('tahapan')->cascadeOnDelete();
            $t->string('judul', 150);
            $t->text('isi');
            $t->string('sumber');
            $t->unsignedInteger('urutan')->default(1);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('panduan');
    }
};
