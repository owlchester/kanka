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
        'App\Character' => 'App\Policies\CharacterPolicy',
        'App\CharacterRelation' => 'App\Policies\CharacterRelationPolicy',
        'App\Family' => 'App\Policies\FamilyPolicy',
        'App\FamilyRelation' => 'App\Policies\FamilyRelationPolicy',
        'App\Item' => 'App\Policies\ItemPolicy',
        'App\Journal' => 'App\Policies\JournalPolicy',
        'App\Location' => 'App\Policies\LocationPolicy',
        'App\Note' => 'App\Policies\NotePolicy',
        'App\Organisation' => 'App\Policies\OrganisationPolicy',
        'App\OrganisationMember' => 'App\Policies\OrganisationMemberPolicy',
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
