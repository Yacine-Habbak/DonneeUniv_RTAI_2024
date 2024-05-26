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
            $table->unsignedBigInteger('univ_id');
            $table->integer('rentree');
            $table->string('Type_personnel');
            $table->string('Corps');
            $table->string('Classe_Age')->nullable();
            $table->integer('Effectif');
            $table->integer('Effectif_H');
            $table->integer('Effectif_F');
            $table->timestamps();

            $table->foreign('univ_id')->references('id')->on('etablissements')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personnels');
    }
};
