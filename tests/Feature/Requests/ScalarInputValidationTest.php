<?php

use App\Http\Requests\AddCalendarEvent;
use App\Http\Requests\API\StoreReminder;
use App\Http\Requests\Campaigns\GalleryImageFolderStore;
use App\Http\Requests\Campaigns\GalleryImageUpdate;
use App\Http\Requests\Campaigns\StoreCampaignApplication;
use App\Http\Requests\Entities\UpdateListingPreferenceRequest;
use App\Http\Requests\Front\StoreCommunityEventEntry;
use App\Http\Requests\Gallery\UploadUrl;
use App\Http\Requests\Onboarding\InitialRequest;
use App\Http\Requests\Onboarding\QuickCreateRequest;
use App\Http\Requests\Settings\UserAltSubscribeStore;
use App\Http\Requests\Spotlights\ApplyRequest;
use App\Http\Requests\StoreAbility;
use App\Http\Requests\StoreAttribute;
use App\Http\Requests\StoreAttributeTemplate;
use App\Http\Requests\StoreBillingSettings;
use App\Http\Requests\StoreBookmark;
use App\Http\Requests\StoreCalendar;
use App\Http\Requests\StoreCampaignDashboard;
use App\Http\Requests\StoreCampaignDashboardWidget;
use App\Http\Requests\StoreCampaignStyle;
use App\Http\Requests\StoreCharacter;
use App\Http\Requests\StoreConversation;
use App\Http\Requests\StoreCreature;
use App\Http\Requests\StoreCustomEntity;
use App\Http\Requests\StoreDiceRoll;
use App\Http\Requests\StoreEntityAsset;
use App\Http\Requests\StoreEntityAssets;
use App\Http\Requests\StoreEvent;
use App\Http\Requests\StoreFamily;
use App\Http\Requests\StoreItem;
use App\Http\Requests\StoreJournal;
use App\Http\Requests\StoreLocation;
use App\Http\Requests\StoreMap;
use App\Http\Requests\StoreMapGroup;
use App\Http\Requests\StoreMapLayer;
use App\Http\Requests\StoreMapMarker;
use App\Http\Requests\StoreNote;
use App\Http\Requests\StoreOrganisation;
use App\Http\Requests\StoreQuest;
use App\Http\Requests\StoreRace;
use App\Http\Requests\StoreRelation;
use App\Http\Requests\StoreSettingsAccount;
use App\Http\Requests\StoreSettingsAccountEmail;
use App\Http\Requests\StoreSettingsProfile;
use App\Http\Requests\StoreTag;
use App\Http\Requests\StoreTimeline;
use App\Http\Requests\StoreWhiteboard;
use App\Http\Requests\UpdateCalendarEvent;
use App\Http\Requests\UpdateEntityAsset;
use App\Http\Requests\UpdateRelation;
use App\Http\Requests\ValidateCoupon;

test('scalar request fields reject structured input', function () {
    $this->asUser();

    foreach (scalarRequestFields() as [$requestClass, $field]) {
        $rules = (new $requestClass)->rules();

        foreach ([['value'], ['value' => 'value']] as $value) {
            $data = [];
            data_set($data, $field, $value);

            $validator = validator($data, [$field => $rules[$field]]);

            expect($validator->fails(), "$requestClass $field must reject structured input")->toBeTrue()
                ->and($validator->errors()->has($field))->toBeTrue();
        }
    }
});

test('calendar quick creator text fields reject structured input', function () {
    request()->query->set('quick-creator', '1');
    $rules = (new StoreCalendar)->rules();

    foreach (['name', 'type'] as $field) {
        $validator = validator([$field => ['value']], [$field => $rules[$field]]);

        expect($validator->fails())->toBeTrue()
            ->and($validator->errors()->has($field))->toBeTrue();
    }
});

function scalarRequestFields(): array
{
    return [
        [AddCalendarEvent::class, 'recurring_periodicity'],
        [AddCalendarEvent::class, 'comment'],
        [StoreReminder::class, 'recurring_periodicity'],
        [StoreReminder::class, 'comment'],
        [GalleryImageFolderStore::class, 'name'],
        [GalleryImageUpdate::class, 'name'],
        [StoreCampaignApplication::class, 'time_start'],
        [StoreCampaignApplication::class, 'time_end'],
        [StoreCampaignApplication::class, 'external_link'],
        [UpdateListingPreferenceRequest::class, 'layout'],
        [StoreCommunityEventEntry::class, 'link'],
        [UploadUrl::class, 'url'],
        [InitialRequest::class, 'name'],
        [InitialRequest::class, 'type'],
        [QuickCreateRequest::class, 'type'],
        [UserAltSubscribeStore::class, 'method'],
        [UserAltSubscribeStore::class, 'period'],
        [ApplyRequest::class, 'action'],
        [StoreAbility::class, 'name'],
        [StoreAbility::class, 'charges'],
        [StoreAttribute::class, 'name'],
        [StoreAttributeTemplate::class, 'name'],
        [StoreBillingSettings::class, 'profile.billing'],
        [StoreBookmark::class, 'name'],
        [StoreBookmark::class, 'icon'],
        [StoreCalendar::class, 'name'],
        [StoreCalendar::class, 'type'],
        [StoreCalendar::class, 'format'],
        [StoreCampaignDashboard::class, 'name'],
        [StoreCampaignDashboardWidget::class, 'config.order'],
        [StoreCampaignStyle::class, 'content'],
        [StoreCharacter::class, 'name'],
        [StoreConversation::class, 'name'],
        [StoreCreature::class, 'name'],
        [StoreCustomEntity::class, 'name'],
        [StoreDiceRoll::class, 'name'],
        [StoreDiceRoll::class, 'parameters'],
        [StoreEntityAsset::class, 'name'],
        [StoreEntityAsset::class, 'metadata.icon'],
        [StoreEntityAssets::class, 'name'],
        [StoreEntityAssets::class, 'metadata.icon'],
        [StoreEvent::class, 'name'],
        [StoreEvent::class, 'date'],
        [StoreFamily::class, 'name'],
        [StoreItem::class, 'name'],
        [StoreJournal::class, 'name'],
        [StoreJournal::class, 'date'],
        [StoreLocation::class, 'name'],
        [StoreMap::class, 'name'],
        [StoreMapGroup::class, 'name'],
        [StoreMapLayer::class, 'name'],
        [StoreMapMarker::class, 'colour'],
        [StoreNote::class, 'name'],
        [StoreOrganisation::class, 'name'],
        [StoreQuest::class, 'name'],
        [StoreRace::class, 'name'],
        [StoreRelation::class, 'relation'],
        [StoreRelation::class, 'colour'],
        [StoreSettingsAccount::class, 'password_new'],
        [StoreSettingsAccountEmail::class, 'email'],
        [StoreSettingsProfile::class, 'link'],
        [StoreTag::class, 'name'],
        [StoreTag::class, 'colour'],
        [StoreTimeline::class, 'name'],
        [StoreTimeline::class, 'image_url'],
        [StoreWhiteboard::class, 'name'],
        [UpdateCalendarEvent::class, 'recurring_periodicity'],
        [UpdateCalendarEvent::class, 'comment'],
        [UpdateEntityAsset::class, 'name'],
        [UpdateEntityAsset::class, 'metadata.icon'],
        [UpdateRelation::class, 'relation'],
        [UpdateRelation::class, 'colour'],
        [ValidateCoupon::class, 'coupon'],
    ];
}
