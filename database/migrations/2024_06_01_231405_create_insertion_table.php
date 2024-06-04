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
        Schema::create('insertions', function (Blueprint $table) {
            $table->id();
            $table->string('univ_id');
            $table->decimal('inser_Licence',5,2)->nullable();
            $table->decimal('inser_Master_LMD',5,2)->nullable();
            $table->decimal('inser_Master_MEEF',5,2)->nullable();
            $table->timestamps();

            $table->foreign('univ_id')->references('id')->on('etablissements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insertion');
    }
};
