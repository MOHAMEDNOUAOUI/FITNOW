<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('hips', 8, 2)->nullable();
            $table->decimal('chest', 8, 2)->nullable();
            $table->decimal('waist', 8, 2)->nullable();
            $table->json('performance')->nullable();
            $table->enum('status', ['Non terminé', 'Terminé'])->default('Non terminé');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('progress');
    }
};
