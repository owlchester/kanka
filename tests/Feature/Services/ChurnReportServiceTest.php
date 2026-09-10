<?php

use App\Services\Report\ChurnReportService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

beforeEach(function (): void {
    Schema::create('subscription_cancellations', function ($table): void {
        $table->id();
        $table->foreignId('user_id');
        $table->string('reason')->nullable();
        $table->string('secondary')->nullable();
        $table->text('custom')->nullable();
        $table->string('tier');
        $table->string('new_tier')->nullable();
        $table->unsignedInteger('duration');
        $table->boolean('is_flagged')->default(false);
        $table->timestamps();
    });
});

it('reports downgrades separately from cancellations', function (): void {
    DB::table('subscription_cancellations')->insert([
        'user_id' => 1,
        'reason' => 'financial',
        'tier' => 'Owlbear',
        'duration' => 20,
        'is_flagged' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    DB::table('subscription_cancellations')->insert([
        'user_id' => 1,
        'reason' => 'missing_features',
        'tier' => 'Wyvern',
        'new_tier' => 'Owlbear',
        'duration' => 30,
        'is_flagged' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $stats = (new ChurnReportService)->getStats(now()->subDay(), now()->addDay());

    expect($stats['total'])->toBe(1)
        ->and($stats['avg_duration'])->toBe(20)
        ->and($stats['by_tier']->all())->toBe(['Owlbear' => 1])
        ->and($stats['downgrades']['total'])->toBe(1)
        ->and($stats['downgrades']['avg_duration'])->toBe(30)
        ->and($stats['downgrades']['by_transition']->all())->toBe(['Wyvern -> Owlbear' => 1])
        ->and($stats['downgrades']['by_reason']->all())->toBe(['missing_features' => 1]);
});
