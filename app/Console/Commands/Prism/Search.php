<?php

namespace App\Console\Commands\Prism;

use App\Models\Embedding;
use Illuminate\Console\Command;
use Prism\Prism\Prism;
use Prism\Prism\Enums\Provider;

class Search extends Command
{
    protected $signature = 'prism:search {prompt : The question to ask Bragi}';
    protected $description = 'Ask a question to Bragi based on previously indexed dummy data';

    public function handle()
    {
        $prompt = $this->argument('prompt');

        // Step 1: Embed the question
        $question = Prism::embeddings()
            ->using(Provider::OpenAI, 'text-embedding-3-small')
            ->fromInput($prompt)
            ->asEmbeddings();

        // Step 2: Fetch the top $neighbours nearest embeddings
        $neighbours = 1; //for test case since we only have 2
        $nearestVectors = Embedding::nearest($question->embeddings[0]->embedding, $neighbours)->get();
        
        //Should be code to fetch entities from the db using their ids on the embeddings in the future
        $path = __DIR__ . '/Dummy';
        if ($nearestVectors[0]->id == 2) {
            $text = file_get_contents("$path/Veronica.json");
        } else {
            $text = file_get_contents("$path/Thaelia.json");
        }

        // Process a document
        $response = Prism::text()
            ->using(Provider::OpenAI, 'gpt-5-mini')  //This might need to be turned into some variable for each model?
            ->withSystemPrompt('You are lore expert, that will answer questions based on this context: ' . $text)
            ->withPrompt(
                $prompt,
            )
            ->asText();

        $this->line("Answer:\n" . $response->text);
        return 0;
    }
}
