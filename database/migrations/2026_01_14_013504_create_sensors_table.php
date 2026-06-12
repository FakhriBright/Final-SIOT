<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('sensors', function (Blueprint $table) {
         $table->id();
             $table->string('nama_sensor');
             $table->string('lokasi');
             $table->integer('nilai');
             $table->boolean('status')->default(true);
             $table->timestamps();
    });

    }

    public function down(): void
    {
        Schema::dropIfExists('sensors');
    }
};
