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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poster_id')->constrained('users');
            $table->string('position');
            $table->text('location');
            $table->text('about');
            $table->text('responsibilities');
            $table->text('requirements');
            $table->text('benefits')->nullable();
            $table->date('deadline');
            $table->enum('status',['Active', 'Inactive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
