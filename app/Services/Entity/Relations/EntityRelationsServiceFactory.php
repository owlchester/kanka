<?php

namespace App\Services\Entity\Relations;

use App\Models\Entity;

class EntityRelationsServiceFactory
{
    public function __construct(
        protected CharacterRelationsService $characterRelationsService,
        protected CreatureRelationsService $creatureRelationsService,
        protected EventRelationsService $eventRelationsService,
        protected FamilyRelationsService $familyRelationsService,
        protected ItemRelationsService $itemRelationsService,
        protected JournalRelationsService $journalRelationsService,
        protected OrganisationRelationsService $organisationRelationsService,
        protected LocationRelationsService $locationRelationsService,
        protected QuestRelationsService $questRelationsService,
        protected RaceRelationsService $raceRelationsService,
    ) {}

    public function for(Entity $entity): ?RelationsServiceInterface
    {
        return match ($entity->entityType->code) {
            'character' => $this->characterRelationsService,
            'creature' => $this->creatureRelationsService,
            'event' => $this->eventRelationsService,
            'family' => $this->familyRelationsService,
            'item' => $this->itemRelationsService,
            'journal' => $this->journalRelationsService,
            'organisation' => $this->organisationRelationsService,
            'location' => $this->locationRelationsService,
            'race' => $this->raceRelationsService,
            'quest' => $this->questRelationsService,
            default => null,
        };
    }
}
