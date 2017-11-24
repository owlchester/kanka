<?php

namespace App\Providers;

use App\Campaign;
use App\CampaignUser;
use App\Character;
use App\Policies\CampaignPolicy;
use App\Policies\CampaignUserPolicy;
use App\Policies\CharacterPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        CampaignUser::class => CampaignUserPolicy::class,
        Campaign::class => CampaignPolicy::class,
        'App\Models\CampaignInvite' => 'App\Policies\CampaignInvitePolicy',
        'App\Character' => 'App\Policies\CharacterPolicy',
        'App\Models\CharacterRelation' => 'App\Policies\CharacterRelationPolicy',
        'App\Models\CharacterAttribute' => 'App\Policies\CharacterAttributePolicy',
        'App\Models\Event' => 'App\Policies\EventPolicy',
        'App\Family' => 'App\Policies\FamilyPolicy',
        'App\Models\FamilyRelation' => 'App\Policies\FamilyRelationPolicy',
        'App\Item' => 'App\Policies\ItemPolicy',
        'App\Journal' => 'App\Policies\JournalPolicy',
        'App\Location' => 'App\Policies\LocationPolicy',
        'App\Models\LocationRelation' => 'App\Policies\LocationRelationPolicy',
        'App\Models\LocationAttribute' => 'App\Policies\LocationAttributePolicy',
        'App\Note' => 'App\Policies\NotePolicy',
        'App\Organisation' => 'App\Policies\OrganisationPolicy',
        'App\Models\OrganisationMember' => 'App\Policies\OrganisationMemberPolicy',
        'App\Models\OrganisationRelation' => 'App\Policies\OrganisationRelationPolicy',
        'App\Models\Quest' => 'App\Policies\QuestPolicy',
        'App\Models\QuestCharacter' => 'App\Policies\QuestCharacterPolicy',
        'App\Models\QuestLocation' => 'App\Policies\QuestLocationPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //
    }
}
