<?php

namespace App\Livewire\Bragi;

use App\Models\AskLog;
use App\Models\Campaign;
use App\Models\Embedding;
use App\Models\Post;
use App\Models\QuestElement;
use App\Models\TimelineElement;
use App\Models\TimelineEra;
use App\Models\User;
use Avatar;
use CampaignCache;
use CampaignLocalization;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Prism\Prism\Prism;
use Prism\Prism\Enums\Provider;
use UserCache;

class Ask extends Component
{
    public $duplicates;

    public bool $isLoading = false;

    public bool $clickedBefore = false;

    public Campaign $campaign;

    public array $messages = [];
    
    #[Validate('required|min:5')]
    public string $query = '';

    public function mount(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    /*
    * Generates answer
    */
    public function submit()
    {
        $this->isLoading = true;

        $this->validate();

        $this->messages[] = ['message' => $this->query, 'author' => 'user' ];

        try {
            $message = $this->handle();
        } catch (\Exception $e) {
            $message = 'Something went wrong while connecting to the AI provider.';

            // Check the raw message
            $raw = $e->getMessage();

            if (str_contains($raw, 'Incorrect API key')) {
                $message = 'Your campaign\'s API Key is invalid. Please re-enter it and try again.';
            } elseif (str_contains($raw, '401')) {
                $message = 'Unauthorized: please verify your API credentials.';
            } elseif (str_contains($raw, '429')) {
                $message = 'Rate limit exceeded. Please wait a moment before trying again.';
            }

            $this->messages[] = ['message' => $message, 'author' => 'bragi' ];
            $this->isLoading = false;

            return;
        }

        $this->messages[] = ['message' => $message, 'author' => 'bragi' ];

        $this->query = '';
        $this->isLoading = false;

        return;
    }

    public function render()
    {
        /** @var User $user */
        $user = auth()->user();
        $canAsk = $this->campaign->askLogs()->recent(Carbon::now()->startOfDay())->count() < config('limits.ask');

        return view('livewire.bragi.ask', ['user' => $user, 'canAsk' => $canAsk]);
    }

    public function handle()
    {
        CampaignLocalization::forceCampaign($this->campaign);
        request()->route()->setParameter('campaign', $this->campaign);
        UserCache::campaign($this->campaign);
        Avatar::campaign($this->campaign);
        CampaignCache::campaign($this->campaign);
        $key = $this->campaign->apiKeys()->where('is_enabled', true)->first();

        // Step 1: Embed the question
        $question = Prism::embeddings()
            ->using(Provider::OpenAI, 'text-embedding-3-small')
            ->usingProviderConfig([
                'api_key' => $key->api_key
            ])
            ->fromInput($this->query)
            ->asEmbeddings();

        // Step 2: Fetch the top $neighbours nearest embeddings
        $neighbours = config('limits.neighbours');
        $nearestVectors = Embedding::where('campaign_id', $this->campaign->id)->nearest($question->embeddings[0]->embedding, $neighbours)->get()->groupBy('parent_type');

        $text = '';
        foreach ($nearestVectors as $class => $vectors) {

            $ids = $vectors->pluck('parent_id')->toArray();

            if ($class == 'App\Models\Entity' ) {
                $entities = $this->campaign->entities()->whereIn('id', $ids)->with(['campaign', 'entityType', 'relationships', 'relationships.target'])->get();
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
            } elseif ($class == 'App\Models\TimelineElement' ) {
                $elements = TimelineElement::whereIn('id', $ids)->with(['timeline', 'timeline.campaign'])->get();
                foreach ($elements as $element) {
                    $elementData = [
                        'name' => $element->name,
                        'entry' => $element->description,
                        'timeline' => $element->timeline->name,
                        'era' => $element->era->name,
                        'entity' => $element->entity->name ?? '',
                        'date' => $element->date,
                    ];
                    $text = $text . '' . json_encode($elementData);
                }
            } elseif ($class == 'App\Models\TimelineEra' ) {
                $eras = TimelineEra::whereIn('id', $ids)->with(['timeline', 'timeline.campaign'])->get();
            
                foreach ($eras as $era) {
                    $eraData = [
                        'name' => $era->name,
                        'entry' => $era->entry,
                        'timeline' => $era->timeline->name,
                        'start_year' => $era->start_year,
                        'end_year' => $era->end_year
                    ];

                    $text = $text . '' . json_encode($eraData);
                }

            } elseif ($class == 'App\Models\QuestElement' ) {
                $elements = QuestElement::whereIn('id', $ids)->with(['quest', 'quest.campaign'])->get();

                foreach ($elements as $element) {

                    $elementData = [
                        'name' => $element->name,
                        'entry' => $element->description,
                        'quest' => $element->quest->name,
                        'entity' => $element->entity->name ?? '',
                    ];

                    $text = $text . '' . json_encode($elementData);
                }
            } elseif ($class == 'App\Models\Post' ) {
                $posts = Post::whereIn('id', $ids)->with(['entity'])->get();

                foreach ($posts as $post) {
                    $postData = [
                        'name' => $post->name,
                        'entity' => $post->entity->name,
                        'entry' => $post->entry,
                        'tags' => $post->tags->pluck('name'),
                    ];
                }

                $text = $text . '' . json_encode($postData);
            }
        }

        // Process a document
        $response = Prism::text()
            ->using(Provider::OpenAI, 'gpt-5')  //This might need to be turned into some variable for each model?
            ->usingProviderConfig([
                'api_key' => $key->api_key
            ])
            ->withSystemPrompt(config('system-prompt.openai') . $text)
            ->withPrompt(
                $this->query,
            )
            ->asText();
        $this->log();
        return $response->text;
    }

    /**
     * Log usage
     *
     * @return void
     */
    protected function log()
    {
        $log = new AskLog;
        $log->user_id = auth()->user()->id;
        $log->campaign_id = $this->campaign->id;
        $log->save();
    }
}
