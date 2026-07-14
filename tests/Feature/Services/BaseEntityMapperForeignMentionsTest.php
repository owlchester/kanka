<?php

use App\Facades\ImportIdMapper;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityMention;
use App\Models\Post;
use App\Services\Campaign\Import\Mappers\BaseEntityMapper;

test('foreignMentions() creates a Post-owned EntityMention using mentionable_type/mentionable_id', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $entity = Character::find(1)->entity;
    $target = Character::find(2)->entity;
    $post = Post::factory()->create(['entity_id' => $entity->id]);

    ImportIdMapper::putEntity(999, $target->id);
    ImportIdMapper::putPost(888, $post->id);

    $mapper = new class
    {
        use BaseEntityMapper;

        public Entity $entity;

        public Campaign $campaign;

        public array $data;

        public function run(): void
        {
            $this->foreignMentions();
        }
    };
    $mapper->entity = $entity;
    $mapper->campaign = Campaign::find(1);
    $mapper->data = [
        'entity' => [
            'mentions' => [
                ['target_id' => 999, 'post_id' => 888],
            ],
        ],
    ];

    $method = new ReflectionMethod($mapper, 'foreignMentions');
    $method->setAccessible(true);
    $method->invoke($mapper);

    $mention = EntityMention::where('target_id', $target->id)->first();
    expect($mention)->not->toBeNull();
    expect($mention->mentionable_type)->toBe(Post::class);
    expect($mention->mentionable_id)->toBe($post->id);
});
