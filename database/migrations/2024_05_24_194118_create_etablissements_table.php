<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etablissements', function (Blueprint $table) {
            $table->id();
            $table->string('Etablissement');
            $table->string('Type');
            $table->string('Commune');
            $table->string('Departement')->nullable();
            $table->string('Region')->nullable();
            $table->string('Academie')->nullable();
            $table->string('Adresse')->nullable();
            $table->string('Secteur');
            $table->string('url')->nullable();
            $table->integer('Etudiants_inscrits_2022')->nullable();
            $table->integer('Etudiants_inscrits_2021')->nullable();
            $table->integer('Etudiants_inscrits_2020')->nullable();
            $table->integer('Etudiants_inscrits_2019')->nullable();
            $table->integer('Etudiants_inscrits_2018')->nullable();
            $table->integer('Personnels_non_enseignant')->nullable();
            $table->string('siret')->nullable();
            $table->string('date_creation')->nullable();
            $table->string('contact')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('Wikipedia')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('etablissements');
    }
};
