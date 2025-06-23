<?php

namespace App\Listeners\Posts;

use App\Enums\UserAction;
use App\Events\Posts\PostCreated;
use App\Events\Posts\PostDeleted;
use App\Events\Posts\PostRestored;
use App\Events\Posts\PostUpdated;
use App\Facades\Identity;
use App\Models\EntityLog;
use App\Services\Entity\PostLoggerService;

class LogPost
{
    /**
     * Create the event listener.
     */
    public function __construct(protected PostLoggerService $postLoggerService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostCreated|PostUpdated|PostRestored|PostDeleted $event): void
    {
        $action = match (true) {
            $event instanceof PostCreated => 'created',
            $event instanceof PostUpdated => 'updated',
            $event instanceof PostDeleted => 'deleted',
            $event instanceof PostRestored => 'restored',
        };
        $actionId = match (true) {
            $event instanceof PostCreated => EntityLog::ACTION_CREATE_POST,
            $event instanceof PostUpdated => EntityLog::ACTION_UPDATE_POST,
            $event instanceof PostDeleted => EntityLog::ACTION_DELETE_POST,
            $event instanceof PostRestored => EntityLog::ACTION_RESTORE,
        };

        $log = new EntityLog;
        $log->entity_id = $event->post->entity->id;
        $log->created_by = $event->user->id;
        $log->post_id = $event->post->id;
        $log->impersonated_by = Identity::getImpersonatorId();
        $log->action = $actionId;
        $changes = $this->postLoggerService->post($event->post)->dirty();
        if ($event instanceof PostUpdated && ! empty($changes)) {
            $log->changes = $changes;
        }
        $log->save();

        // make a campaign admin log when restoring a post since it's an admin feature
        // not sure if this actually makes sense to have, since it's also available in the post logs
        //        if ($event instanceof PostRestored) {
        //            $event->user?->campaignLog(
        //                $event->post->entity->campaign_id,
        //                'recovery',
        //                'post',
        //                [
        //                    'name' => $event->post->name,
        //                    'id' => $event->post->id,
        //                ]
        //            );
        //        }

        $event->user->log(
            UserAction::post,
            [
                'action' => $action,
                'id' => $event->post->id,
            ]
        );
    }
}
