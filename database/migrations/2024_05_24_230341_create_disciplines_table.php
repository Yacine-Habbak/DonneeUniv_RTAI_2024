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
            $table->unsignedBigInteger('univ_id');
            $table->string('Discipline');
            $table->string('Type_diplome');
            $table->string('Nom_diplome');
            $table->string('Nbr_poursuivants')->nullable();
            $table->string('Nbr_sortants')->nullable();
            $table->string('Taux_emploi_salarié', 5, 2)->nullable();
            $table->string('Date_insertion')->nullable();
            $table->string('Taux_reussite')->nullable();
            $table->string('Taux_insertion')->nullable();

            $table->foreign('univ_id')->references('id')->on('etablissements')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disciplines');
    }
};
