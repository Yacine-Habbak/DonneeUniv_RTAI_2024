<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etablissements', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('Etablissement');
            $table->string('Type');
            $table->string('Commune');
            $table->string('Departement')->nullable();
            $table->string('Region')->nullable();
            $table->string('Academie')->nullable();
            $table->string('Adresse')->nullable();
            $table->decimal('lat', 10, 8);
            $table->decimal('lon', 11, 8);
            $table->string('Secteur');
            $table->string('url')->nullable();
            $table->integer('Personnels_non_enseignant')->nullable();
            $table->integer('Personnels_non_enseignant_H')->nullable();
            $table->integer('Personnels_non_enseignant_F')->nullable();
            $table->integer('Enseignants')->nullable();
            $table->integer('EnsNonPerm')->nullable();
            $table->decimal('TE_enseignants', 8, 2)->nullable();
            $table->decimal('TE_Total', 8, 2)->nullable();
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
