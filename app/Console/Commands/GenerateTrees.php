<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;

class GenerateTrees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trees {models=all,timeline,journal}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the trees';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->out('Start fixing trees');
        $models = explode(',', $this->argument('models'));

        if ($this->argument('models') === 'all') {
            $this->fixAll();
            $this->info('Finished');
            return 1;
        }

        $classes = config('entities.classes');
        foreach ($models as $model) {
            $class = new $classes[$model]();
            if ($class === false || !method_exists($class, 'recalculateTreeBounds')) {
                $this->warn('Skipping ' . $model);
                continue;
            }
            $start = Carbon::now();
            $this->out("Model {$model}");
            $class::fixTree();
            $end = Carbon::now();
            $this->out('Fixed in ' . $start->diffInMinutes($end) . ' minutes');
        }
        $this->out('Finished fixing trees');
    }

    /**
     *
     */
    protected function fixAll(): void
    {
        $models = config('entities.classes');
        foreach ($models as $model => $class) {
            $new = new $class();
            try {
                $this->info("Fixing {$model}");
                $class::fixTree();
            } catch (Exception $e) {
                $this->warn('Skipping ' . $model);
            }
        }
    }

    protected function out(string $text): self
    {
        $now = Carbon::now();
        $this->info($now->format('H:i:s') . ': ' . $text);
        return $this;
    }
}
