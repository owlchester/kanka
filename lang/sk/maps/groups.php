<?php

return [
    'actions'       => [
        'add'   => 'Pridať novú skupinu',
    ],
    'bulks'         => [
        'delete'    => '{1} Odstránená :count skupina.|[2,4] Odstránené :count skupiny.|[5,*] Odstránených :count skupín.',
        'patch'     => '{1} Aktualizovaná :count skupina.|[2,4] Aktualizované :count skupiny.|[5,*] Aktualizovaných :count skupín.',
    ],
    'create'        => [
        'success'   => 'Skupina :name vytvorená.',
        'title'     => 'Nová skupina',
    ],
    'delete'        => [
        'success'   => 'Skupina :name odstránená.',
    ],
    'edit'          => [
        'success'   => 'Skupina :name aktualizovaná.',
        'title'     => 'Upraviť skupinu :name',
    ],
    'fields'        => [
        'is_shown'  => 'Zobraziť značky skupiny',
        'position'  => 'Pozícia',
    ],
    'helper'        => [
        'amount_v3' => 'Značky môžu byť zoskupené pomocou mapových skupín. Kliknutím na skupinu je možné pri objavovaní na mape zobraziť alebo skryť všetky jej značky.',
    ],
    'hints'         => [
        'is_shown'  => 'Aktivovaním sa značky skupiny zobrazia na mape automaticky.',
    ],
    'index'         => [
        'title' => 'Skupiny :name',
    ],
    'pitch'         => [],
    'placeholders'  => [
        'name'          => 'Obchody, Poklady, NPC',
        'position'      => 'Nepovinné pole na nastavenie poradia zobrazenia skupín.',
        'position_list' => 'Po :name',
    ],
    'reorder'       => [
        'save'      => 'Uložiť nové poradie',
        'success'   => '{1} Preuskupená :count skupina.|[2,4] Preskupené :count skupiny.|[5,*] Preskupených :count skupín.',
        'title'     => 'Preskupiť skupiny',
    ],
];
