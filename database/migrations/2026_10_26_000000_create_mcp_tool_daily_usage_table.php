<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mcp_tool_daily_usage', function (Blueprint $table) {
            $table->id();
            $table->date('usage_date');
            $table->string('tool', 64);
            $table->unsignedBigInteger('calls')->default(0);
            $table->timestamps();
            $table->unique(['usage_date', 'tool']);
            $table->index('usage_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mcp_tool_daily_usage');
    }
};
