<?php

namespace App\Services;

use App\Campaign;
use App\Models\Character;
use App\Models\Item;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StarterService
{
    /**
     * @param Campaign $campaign
     */
    public static function generateBoilerplate(Campaign $campaign)
    {
        // Generate locations
        $kingdom = new Location([
            'name' => 'Genory',
            'type' => 'Kingdom',
            'description' => '<p>The Kingdomof Genory is situated on the Bolan planes of the Thaelian continent.</p>',
            'history' => '<p>The Kingdom of Genory was founded by Genorian tribesmen in the late 5th century after they invaded the lands from the Hottens.</p>',
            'campaign_id' => $campaign->id,
        ]);
        $kingdom->save();

        $city = new Location([
            'name' => 'Unria',
            'type' => 'Capital',
            'parent_location_id' => $kingdom->id,
            'description' => '<p>Unria is the capital city of the kingdom of Genory, and third biggest city of Agagir Alliance.</p>',
            'history' => '<p>Unria is the capital city of the kingdom of Genory. It was founded by Frasan Irwen and is located on the Unri river.</p>',
            'campaign_id' => $campaign->id,
        ]);
        $city->save();

        $james = new Character([
            'name' => 'James Owlchester',
            'title' => 'Grey Hunter',
            'age' => '43',
            'race' => 'Human',
            'sex' => 'Male',
            'history' => '<p>Born to Mance Owlchester and Rige Dunton, James grew up in the countryside of Genory before moving to the capital city of Unria to work as a scribe for the king.</p>',
            'location_id' => $city->id,
            'campaign_id' => $campaign->id,
            'fears' => 'James is scared of loud noises and explosions.',
            'traits' => 'Will always bend the truth to his advantage.',

        ]);
        $james->save();

        $irwie = new Character([
            'name' => 'Irwie Gemstone',
            'title' => 'Queen of Explosions',
            'age' => '37',
            'race' => 'Gnome',
            'sex' => 'Female',
            'history' => '<p>From a young age, Irwie has always been fascinated by explosives, and has dedicated her career to the craft.</p>',
            'location_id' => $kingdom->id,
            'campaign_id' => $campaign->id,
            'goals' => 'Create the biggest explosion possible',
            'free' => 'Want to track something else? We\'ve got you covered with this free text section!',
        ]);
        $irwie->save();

        $item = new Item([
            'name' => 'Dagger of Darkness',
            'campaign_id' => $campaign->id,
            'type' => 'Weapon',
            'description' => '<p>Description of the item.</p>',
            'history' => '<p>History of the item.</p>',
            'character_id' => $irwie->id,
            'location_id' => $kingdom->id,
        ]);
        $item->save();
    }
}
