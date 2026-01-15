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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('contract_number')->nullable();
            $table->string('title');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('application_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->integer('status');
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->decimal('budget_sum', 20, 2);
            $table->date('deadline');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
