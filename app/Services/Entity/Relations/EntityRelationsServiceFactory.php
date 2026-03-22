<?php

namespace App\Services\Entity\Relations;

use App\Models\Entity;

class EntityRelationsServiceFactory
{
    public function __construct(
        protected CharacterRelationsService $characterRelationsService,
        protected FamilyRelationsService $familyRelationsService,
        protected ItemRelationsService $itemRelationsService,
        protected OrganisationRelationsService $organisationRelationsService,
        protected LocationRelationsService $locationRelationsService,
    ) {}

    public function for(Entity $entity): ?RelationsServiceInterface
    {
        return match ($entity->entityType?->code) {
            'character' => $this->characterRelationsService,
            'family' => $this->familyRelationsService,
            'item' => $this->itemRelationsService,
            'organisation' => $this->organisationRelationsService,
            'location' => $this->locationRelationsService,
            default => null,
        };
    }
}
