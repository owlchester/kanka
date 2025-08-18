<?php

namespace App\Console\Commands\Prism;

use App\Models\Embedding;
use App\Models\Entity;
use Illuminate\Console\Command;
use Prism\Prism\Prism;
use Prism\Prism\Enums\Provider;

class Reindex extends Command
{
    protected $signature = 'prism:reindex {--path= : Path to dummy files}';
    protected $description = 'Load dummy data into memory/index for later searching';

    public function handle()
    {
        $path = __DIR__ . '/Dummy';

        if (!is_dir($path)) {
            $this->error("Path '{$path}' not found.");
            return 1;
        }

        $data = [];
        foreach (scandir($path) as $file) {
            if (in_array($file, ['.', '..'])) continue;
            $content = file_get_contents("$path/$file");
            $data[] = $content;
        }

        //Get vectors
        $response = Prism::embeddings()
            ->using(Provider::OpenAI, 'text-embedding-3-small')
            ->fromArray($data)
            ->asEmbeddings();

        // Store vectors into db
        $embeddings = $response->embeddings;
        $count = 1;
        foreach ($embeddings as $embedding) {
            //Thaelia id = 1
            Embedding::create([
                'parent_id'   => $count, //Dummy for now, in the future should be the entity/post ID
                'campaign_id' => '1', //Same as above
                'parent_type' => Entity::class, //You get it
                'embedding'   => $embedding->embedding, //The actual vector.
            ]);
            $count++;
        }

        $this->info("Reindexed " . count($data) . " dummy files.");
        return 0;
    }
}
