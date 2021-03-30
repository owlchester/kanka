<?php

return [
    'actions'   => [
        'add'               => 'Voeg vaardigheden toe',
        'import_from_race'  => 'Voeg ras vaardigheden toe',
        'reset'             => 'Gebruik van vaardigheden opnieuw instellen',
    ],
    'create'    => [
        'success'           => 'Vaardigheid :ability toegevoegd aan :entity.',
        'success_multiple'  => 'Vaardigheden :abilities toegevoegd aan :entity.',
        'title'             => 'Voeg vaardigheden toe aan :name',
    ],
    'fields'    => [
        'note'      => 'Notitie',
        'position'  => 'Positie',
    ],
    'helpers'   => [
        'note'  => 'Je kunt verwijzen naar entiteiten met behulp van geavanceerde vermeldingen (bijv. :code) en attributen van de entiteit (bijv. :attr) in dit veld.',
    ],
    'import'    => [
        'errors'    => [
            'no_race'       => 'Het personage heeft geen ras.',
            'not_character' => 'De entiteit is geen personage.',
        ],
        'success'   => '{1} :count geïmporteerd.|[2, *] :count geïmporteerd.',
    ],
    'show'      => [
        'helper'    => 'Koppel vaardigheden aan deze entiteit. Je kunt altijd de zichtbaarheid bewerken of een vaardigheid verwijderen. Vaardigheden die tot dezelfde bovenliggende vaardigheid behoren, worden weergegeven als filtervakken.',
        'title'     => 'Entiteit Vaardigheden voor :name',
    ],
    'update'    => [
        'title' => 'Entiteit Vaardigheid voor :name',
    ],
];
