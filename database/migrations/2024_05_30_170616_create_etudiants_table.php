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
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('univ_id');
            $table->integer('Effectif_2022')->nullable();
            $table->integer('Effectif_2021')->nullable();
            $table->integer('Effectif_2020')->nullable();
            $table->integer('Effectif_2019')->nullable();
            $table->integer('Effectif_2018')->nullable();
            $table->integer('Effectif_2017')->nullable();
            $table->integer('Effectif_2016')->nullable();
            $table->integer('Effectif_2015')->nullable();
            $table->integer('Effectif_2014')->nullable();
            $table->integer('Effectif_2013')->nullable();

            $table->timestamps();

            $table->foreign('univ_id')->references('id')->on('etablissements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};
