<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disciplines', function (Blueprint $table) {
            $table->id();
            $table->string('Discipline');
            $table->string('Etablissement');
            $table->string('Academie');
            $table->string('Region');
            $table->string('Type_diplome');
            $table->string('Nom_diplome');
            $table->string('Nbr_poursuivants')->nullable();
            $table->string('Nbr_sortants')->nullable();
            $table->string('Taux_emploi_salarié', 5, 2)->nullable();
            $table->string('Date_insertion')->nullable();
            $table->string('Taux_reussite')->nullable();
            $table->string('Taux_insertion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disciplines');
    }
};
