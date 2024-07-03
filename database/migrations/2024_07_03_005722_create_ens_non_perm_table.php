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
        Schema::create('ensnonperm', function (Blueprint $table) {
            $table->id();
            $table->string('univ_id');
            $table->integer('Effectif')->nullable();
            $table->integer('Effectif_H')->nullable();
            $table->integer('Effectif_F')->nullable();
            $table->timestamps();

            $table->foreign('univ_id')->references('id')->on('etablissements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ensnonperm');
    }
};
