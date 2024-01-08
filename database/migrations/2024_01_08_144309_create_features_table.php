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
        Schema::dropIfExists('feature_categories');
        Schema::create('feature_categories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 45)->unique();
        });

        Schema::dropIfExists('feature_statuses');
        Schema::create('feature_statuses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 45)->unique();
        });

        Schema::dropIfExists('features');
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();
            $table->string('name', 90);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->unsignedInteger('upvote_count')->default(0);

            $table->foreign('status_id')->references('id')->on('feature_statuses')->cascadeOnDelete();
            $table->foreign('category_id')->references('id')->on('feature_categories')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();

            $table->index(['name']);
        });

        Schema::create('feature_upvotes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedInteger('user_id');
            $table->unsignedBigInteger('feature_id');
            $table->unique(['user_id', 'feature_id']);

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('feature_id')->references('id')->on('features')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feature_upvotes');
        Schema::dropIfExists('features');
        Schema::dropIfExists('feature_categories');
        Schema::dropIfExists('feature_statuses');
    }
};
