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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_number')->nullable();
            $table->text('title');
            $table->decimal('budget_sum', 20, 2)->nullable();
            $table->date('project_year');
            $table->unsignedBigInteger('user_id');
            $table->integer('status')->default(1);
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->date('deadline');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
