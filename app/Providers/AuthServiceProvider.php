<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        if (!app()->runningInConsole() || $this->shouldLoadPolicies()) {
            $this->registerPolicies();
        }
        if (!app()->runningInConsole()) {
            Passport::routes(null, [
                'prefix' => LaravelLocalization::setLocale() . '/oauth',
            ]);
            Passport::enableImplicitGrant();
        }
    }

    /**
     * The policy mappings for the application.
     * Laravel auto-discoveres policies if the Model is named \App\Models\XYZ and the police is \App\Policies\XYZPolicy
     */
    protected $policies = [
        //'App\Model' => 'App\Policies\ModelPolicy',
        //'App\Models\CampaignPermission' => 'App\Policies\CampaignPermission',
        /*CampaignUser::class => CampaignUserPolicy::class,
        Campaign::class => CampaignPolicy::class,
        CampaignBoost::class => CampaignBoostPolicy::class,
        'App\Models\Ability' => 'App\Policies\AbilityPolicy',
        'App\Models\AttributeTemplate' => 'App\Policies\AttributeTemplatePolicy',
        'App\Models\Calendar' => 'App\Policies\CalendarPolicy',
        'App\Models\CampaignInvite' => 'App\Policies\CampaignInvitePolicy',
        'App\Models\CampaignRole' => 'App\Policies\CampaignRolePolicy',
        'App\Models\CampaignRoleUser' => 'App\Policies\CampaignRoleUserPolicy',
        'App\Models\CommunityVote' => 'App\Policies\CommunityVotePolicy',
        'App\Models\Character' => 'App\Policies\CharacterPolicy',
        'App\Models\Conversation' => 'App\Policies\ConversationPolicy',
        'App\Models\ConversationMessage' => 'App\Policies\ConversationMessagePolicy',
        'App\Models\DiceRoll' => 'App\Policies\DiceRollPolicy',
        'App\Models\DiceRollResult' => 'App\Policies\DiceRollResultPolicy',
        'App\Models\Event' => 'App\Policies\EventPolicy',
        'App\Models\Entity' => 'App\Policies\EntityPolicy',
        'App\Models\Family' => 'App\Policies\FamilyPolicy',
        'App\Models\Item' => 'App\Policies\ItemPolicy',
        'App\Models\Journal' => 'App\Policies\JournalPolicy',
        'App\Models\Location' => 'App\Policies\LocationPolicy',
        'App\Models\Map' => 'App\Policies\MapPolicy',
        'App\Models\MapPoint' => 'App\Policies\LocationMapPointPolicy',
        'App\Models\MenuLink' => 'App\Policies\MenuLinkPolicy',
        'App\Models\Note' => 'App\Policies\NotePolicy',
        'App\Models\Organisation' => 'App\Policies\OrganisationPolicy',
        'App\Models\OrganisationMember' => 'App\Policies\OrganisationMemberPolicy',
        'App\Models\Plugin' => 'App\Policies\PluginPolicy',
        'App\Models\Quest' => 'App\Policies\QuestPolicy',
        'App\Models\Race' => 'App\Policies\RacePolicy',
        'App\Models\Tag' => 'App\Policies\TagPolicy',
        'App\Models\Timeline' => 'App\Policies\TimelinePolicy',
        'App\Models\Relation' => 'App\Policies\RelationPolicy',*/

        // Front
        //'App\Models\CommunityEventEntry' => 'App\Policies\CommunityEventEntryPolicy',
    ];

    /**
     * @return bool
     */
    private function shouldLoadPolicies(): bool
    {
        return strtolower(config('app.env')) !== 'testing';
    }
}
