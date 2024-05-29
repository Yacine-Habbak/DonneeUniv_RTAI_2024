<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enseignants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('univ_id');
            $table->string('Type_enseignant');
            $table->string('Grande_discipline');
            $table->string('Sexe');
            $table->string('Temps')->nullable();
            $table->integer('Effectif')->nullable();
            $table->timestamps();

            $table->foreign('univ_id')->references('id')->on('etablissements')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enseignants');
    }
};
