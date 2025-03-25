<?php

namespace App\Services\Abilities;

use App\Models\Ability;
use App\Models\EntityAbility;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use App\Traits\UserAware;

class ChargeService extends BaseAbilityService
{
    use CampaignAware;
    use EntityAware;
    use UserAware;

    protected EntityAbility $ability;

    public function ability(EntityAbility $ability): self
    {
        $this->ability = $ability;

        return $this;
    }

    /**
     * Set an ability's charge as used
     */
    public function use(int $used): bool
    {
        // Check that we are not above the parent
        if ($used > $this->parseCharges($this->ability->ability)) {
            return false;
        }

        $this->ability->charges = $used;
        $this->ability->saveQuietly();

        return true;
    }

    /**
     * Reset the ability charges on the entity
     */
    public function reset(): self
    {
        $usedAbilities = $this->entity->abilities()->where('charges', '>', 0)->get();
        /** @var Ability $ability */
        foreach ($usedAbilities as $ability) {
            $ability->charges = null;
            $ability->saveQuietly();
        }

        return $this;
    }
}
