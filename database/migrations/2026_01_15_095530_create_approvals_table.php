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
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->string('approvable_type');
            $table->unsignedBigInteger('approvable_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('approval_order')->default(1);
            $table->boolean('approved')->default(false);
            $table->text('reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->index(['approvable_type', 'approvable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};
