<?php

use App\Enums\CampaignVisibility;
use App\Enums\ConversationTarget;
use App\Enums\Permission;
use App\Http\Middleware\ReplicationSwitcher;
use App\Models\CampaignPermission;
use App\Models\Character;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\User;

beforeEach(function () {
    $this->asUser()->withCampaign(['visibility_id' => CampaignVisibility::public]);
    $this->conversation = Conversation::factory()->create([
        'campaign_id' => 1,
        'target_id' => ConversationTarget::users,
    ]);
    $this->page = route('entities.show', [1, $this->conversation->entity]);
    $this->thread = route('conversations.conversation_messages.index', [1, $this->conversation]);
});

it('lets guests and read-only members read but not post', function (bool $guest) {
    ConversationMessage::factory()->for($this->conversation)->for(User::firstOrFail(), 'participant')
        ->create(['message' => 'We meet at dawn.']);

    if ($guest) {
        auth()->forgetGuards();
        auth()->shouldUse('web');
        $this->withoutMiddleware(ReplicationSwitcher::class);
    } else {
        $this->asPlayer();
    }

    $this->get($this->page)->assertOk()
        ->assertSee('data-can-manage="0"', false)
        ->assertSee('data-send=""', false);
    $this->getJson($this->thread)->assertOk()
        ->assertJsonPath('data.messages.0.message', 'We meet at dawn.')
        ->assertJsonPath('data.messages.0.can_edit', false)
        ->assertJsonPath('data.messages.0.can_delete', false);
    $this->postJson($this->thread, ['message' => 'Hello'])->assertForbidden();
})->with([true, false]);

it('marks the conversation closed and rejects new messages', function () {
    $message = ConversationMessage::factory()->for($this->conversation)->for(User::firstOrFail(), 'participant')->create();
    $this->conversation->update(['is_closed' => true]);

    $this->get($this->page)->assertOk()
        ->assertSee('data-closed="1"', false)
        ->assertSee('data-send=""', false);
    $this->postJson($this->thread, ['message' => 'Hello'])->assertForbidden();
    $this->putJson($this->thread . '/' . $message->id, ['message' => 'Hello'])->assertForbidden();
});

it('offers registered entity speakers in participant order and only accepts those speakers', function () {
    $this->conversation->update(['target_id' => ConversationTarget::entities]);
    [$unlisted, $second, $first] = Character::factory()->count(3)->create(['campaign_id' => 1])->map->entity;

    $this->get($this->page)->assertOk()
        ->assertSee('data-can-manage="1"', false)
        ->assertSee('data-speakers="[]"', false);

    foreach ([$first, $second] as $speaker) {
        $this->conversation->participants()->create(['participant_id' => $speaker->id, 'participant_type' => $speaker->getMorphClass()]);
    }
    $this->get($this->page)->assertOk()
        ->assertSee('data-speakers="' . e(json_encode([
            ['id' => $first->id, 'name' => $first->name],
            ['id' => $second->id, 'name' => $second->name],
        ])) . '"', false);

    $this->postJson($this->thread, ['entity_id' => $unlisted->id, 'message' => 'Not a participant'])
        ->assertUnprocessable()->assertJsonValidationErrors('entity_id');
    $this->postJson($this->thread, ['entity_id' => $first->id, 'message' => "First line\nSecond line"])
        ->assertCreated()
        ->assertJsonPath('data.entity_id', $first->id)
        ->assertJsonPath('data.message', "First line\nSecond line");
});

it('does not let members speak as a listed entity they cannot edit', function () {
    $this->conversation->update(['target_id' => ConversationTarget::entities]);
    $speaker = Character::factory()->create(['campaign_id' => 1])->entity;
    $this->conversation->participants()->create(['participant_id' => $speaker->id, 'participant_type' => $speaker->getMorphClass()]);
    $player = $this->conversation->campaign->roles()->where('is_public', false)->where('is_admin', false)->firstOrFail();
    CampaignPermission::create([
        'campaign_role_id' => $player->id,
        'action' => Permission::Update->value,
        'entity_type_id' => $this->conversation->entity->type_id,
        'access' => true,
    ]);
    $this->asPlayer();

    $this->get($this->page)->assertOk()
        ->assertSee('data-can-manage="1"', false)
        ->assertSee('data-speakers="[]"', false);
    $this->postJson($this->thread, ['entity_id' => $speaker->id, 'message' => 'Not my character'])
        ->assertUnprocessable()->assertJsonValidationErrors('entity_id');
});

it('validates the composer message length', function () {
    $this->postJson($this->thread, ['message' => str_repeat('a', 1001)])
        ->assertUnprocessable()->assertJsonValidationErrors('message');
});

it('does not modify messages from another conversation', function () {
    $other = Conversation::factory()->create(['campaign_id' => 1, 'target_id' => ConversationTarget::users]);
    $message = ConversationMessage::factory()->for($other)->for(User::firstOrFail(), 'participant')->create();

    $this->putJson($this->thread . '/' . $message->id, ['message' => 'Changed'])->assertNotFound();
    $this->deleteJson($this->thread . '/' . $message->id)->assertNotFound();
});

it('reports earlier history only when another page exists', function (int $count) {
    $messages = ConversationMessage::factory()->count($count)->for($this->conversation)
        ->for(User::firstOrFail(), 'participant')->create();

    $this->getJson($this->thread)->assertOk()
        ->assertJsonCount(min($count, 20), 'data.messages')
        ->assertJsonPath('data.messages.*.id', $messages->pluck('id')->slice(-20)->values()->all())
        ->assertJsonPath('data.previous', $count > 20);

    if ($count > 20) {
        $this->getJson($this->thread . '?oldest=' . $messages[1]->id)->assertOk()
            ->assertJsonPath('data.messages.*.id', [$messages[0]->id])
            ->assertJsonPath('data.previous', false);
    }
})->with([0, 1, 20, 21]);

it('pages forward without skipping intervening replies or changing the history flag', function () {
    $messages = ConversationMessage::factory()->count(21)->for($this->conversation)
        ->for(User::firstOrFail(), 'participant')->create();
    $sent = $this->postJson($this->thread, ['message' => 'Just sent'])->assertCreated()
        ->assertJsonPath('data.message', 'Just sent')->json('data.id');

    $this->getJson($this->thread . '?newest=0')->assertOk()
        ->assertJsonPath('data.messages.*.id', $messages->pluck('id')->take(20)->all())
        ->assertJsonPath('data.more_newer', true)
        ->assertJsonMissingPath('data.previous');

    $this->getJson($this->thread . '?newest=' . $messages[19]->id)->assertOk()
        ->assertJsonPath('data.messages.*.id', [$messages[20]->id, $sent])
        ->assertJsonPath('data.more_newer', false)
        ->assertJsonMissingPath('data.previous');
});

it('edits only the text and returns the edited message', function () {
    $author = User::firstOrFail();
    $message = ConversationMessage::factory()->for($this->conversation)->for($author, 'participant')->create();
    $other = User::factory()->create();
    $this->travel(1)->minutes();

    $this->putJson($this->thread . '/' . $message->id, ['user_id' => $other->id, 'message' => 'Revised'])
        ->assertOk()
        ->assertJsonPath('data.id', $message->id)
        ->assertJsonPath('data.from_id', $author->id)
        ->assertJsonPath('data.message', 'Revised')
        ->assertJsonPath('data.is_updated', true);
});
