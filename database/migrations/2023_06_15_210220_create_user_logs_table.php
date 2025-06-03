<?php

use App\Enums\UserAction;
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
        if (! config('logging.enabled')) {
            return;
        }
        if (Schema::connection('logs')->hasTable('user_logs')) {
            return;
        }
        Schema::connection('logs')->create('user_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->unsignedTinyInteger('type_id')
                ->default(UserAction::login->value);
            $table->string('ip', 255)->nullable();
            $table->char('country', 6)->nullable();
            $table->timestamps();
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! config('logging.enabled')) {
            return;
        }
        Schema::dropIfExists('user_logs');
    }
};
