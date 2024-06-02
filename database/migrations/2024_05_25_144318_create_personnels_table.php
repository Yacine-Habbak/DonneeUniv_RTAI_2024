<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personnels', function (Blueprint $table) {
            $table->id();
            $table->string('univ_id');
            $table->string('Type');
            $table->integer('Effectif')->nullable();
            $table->integer('Effectif_H')->nullable();
            $table->integer('Effectif_F')->nullable();
            $table->timestamps();

            $table->foreign('univ_id')->references('id')->on('etablissements')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personnels');
    }
};
