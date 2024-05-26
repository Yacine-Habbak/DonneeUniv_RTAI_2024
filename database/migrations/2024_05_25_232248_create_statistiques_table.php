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
        Schema::create('statistiques', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('univ_id');
            $table->integer('rentree');
            $table->integer('Etudiants_inscrits');
            $table->integer('Etudiants_inscrits_H');
            $table->integer('Etudiants_inscrits_F');
            $table->integer('Bac_Gen')->nullable();
            $table->integer('Bac_STMG')->nullable();
            $table->integer('Bac_Autre')->nullable();
            $table->integer('Bac_PRO')->nullable();
            $table->integer('Bac_Dispense')->nullable();
            $table->integer('Etudiants_mobilite')->nullable();
            $table->integer('Bac4')->nullable();
            $table->integer('Bac5')->nullable();

            $table->timestamps();

            $table->foreign('univ_id')->references('id')->on('etablissements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistiques');
    }
};
