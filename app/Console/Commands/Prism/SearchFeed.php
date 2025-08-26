<?php

namespace App\Console\Commands\Prism;

use App\Facades\Module;
use App\Models\Embedding;
use App\Models\Entity;
use Illuminate\Console\Command;
use Prism\Prism\Prism;
use Prism\Prism\Enums\Provider;

class Search extends Command
{
    protected $signature = 'prism:searchFeed {prompt : The question to ask Bragi} {id : The id of the campaign where the search is performed}';
    protected $description = 'Ask a question to Bragi based on previously indexed data';

    public function handle()
    {
        $prompt = $this->argument('prompt');

        $campaignId = $this->argument('id');


        // Step 1: Embed the question
        $question = Prism::embeddings()
            ->using(Provider::OpenAI, 'text-embedding-3-small')
            ->fromInput($prompt)
            ->asEmbeddings();

        // Step 2: Fetch the top $neighbours nearest embeddings
        $neighbours = 3; //for test case since we only have 2
        $nearestVectors = Embedding::where('campaign_id', $campaignId)->nearest($question->embeddings[0]->embedding, $neighbours)->get();
    
        $text = '';

        $ids = $nearestVectors->pluck('parent_id')->toArray();

        $entities = Entity::whereIn('id', $ids)->with(['campaign', 'entityType', 'relationships', 'relationships.target'])->get();
        Module::campaign($entities[1]->campaign);

        foreach ($entities as $entity) {
            $relations = $entity->relationships->map(function ($relationship) {
                return [
                    'name'     => $relationship->target->name ?? null,
                    'relation' => $relationship->relation,
                    'attitude' => $relationship->attitude,
                ];
            })->toArray();

            $entityData = [
                'name' => $entity->name,
                'entry' => $entity->entry,
                'type' => $entity->entityType->name(),
                'relations' => $relations,
                'tags' => $entity->tags->pluck('name'),
            ];

            $text = $text . '' . json_encode($entityData);
        }

        // Process a document
        $response = Prism::text()
            ->using(Provider::OpenAI, 'gpt-5-mini')  //This might need to be turned into some variable for each model?
            ->withSystemPrompt('You are Bragi, a lore expert that will answer questions based on this context: ' . $text)
            ->withPrompt(
                $prompt,
            )
            ->asText();

        $this->line("Answer:\n" . $response->text);
        return 0;
    }
}
