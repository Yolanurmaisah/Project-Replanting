<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('petani', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->nullable()->unique()->constrained('users')->nullOnDelete();
            $t->string('nik', 16)->unique();
            $t->string('nama', 100);
            $t->string('no_hp', 20)->nullable();
            $t->text('alamat')->nullable();
            $t->string('desa', 100)->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('petani');
    }
};
