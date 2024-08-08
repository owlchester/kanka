<?php

namespace App\Console\Commands\Cleanup;

use App\Models\Entity;
use App\Models\Post;
use App\Services\Entity\PurgeService;
use App\Services\Posts\PurgeService as PostPurgeService;
use App\Traits\HasJobLog;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupTrashed extends Command
{
    use HasJobLog;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:trashed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old trashed entities';

    /**
     * The recovery service
     *
     */
    protected PurgeService $service;
    protected PostPurgeService $postService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PurgeService $service, PostPurgeService $postService)
    {
        parent::__construct();
        $this->service = $service;
        $this->postService = $postService;
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $delay = Carbon::now()->subDays(config('entities.hard_delete'))->toDateString();
        $log = '';
        $this->info('Looking to purge entities and posts deleted since ' . $delay);

        DB::beginTransaction();
        try {
            Entity::onlyTrashed()
                ->where('deleted_at', '<=', $delay)
                ->allCampaigns()
                ->with('campaign')
                ->chunkById(1000, function ($entities): void {
                    $this->info('Chunk deleting ' . count($entities) . ' entities.');
                    foreach ($entities as $entity) {
                        //dump($entity->name . ' (' . $entity->type() . ')');
                        $this->service->trash($entity);
                    }
                });
            Post::onlyTrashed()
                ->where('deleted_at', '<=', $delay)
                ->chunkById(1000, function ($posts): void {
                    $this->info('Chunk deleting ' . count($posts) . ' posts.');
                    /** @var Post $post */
                    foreach ($posts as $post) {
                        $this->postService->trash($post);
                    }
                });
            DB::commit();
        } catch (Exception $e) {
            $this->error($e->getMessage());
            $log .= '<br />' . $e->getMessage();
            DB::rollBack();
        }

        $this->info('');
        $this->info('Deleted ' . $this->service->count() . ' trashed entities.');
        $log .= '<br />' . 'Deleted ' . $this->service->count() . ' trashed entities.';

        $this->info('Deleted ' . $this->postService->count() . ' trashed posts.');
        $log .= '<br />' . 'Deleted ' . $this->postService->count() . ' trashed posts.';
        $this->log($log);

        return 0;
    }
}
