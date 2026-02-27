<?php

return [
    'attribute_templates'   => [],
    'create'                => [
        'title' => 'Nieuw attribuutsjabloon',
    ],
    'destroy'               => [],
    'edit'                  => [],
    'fields'                => [],
    'hints'                 => [
        'automatic'                 => 'Attributen worden automatisch toegepast vanuit de :link Attribuutsjabloon',
        'entity_type'               => 'Indien ingesteld, zal bij het maken van een nieuwe entiteit van dit type automatisch deze attribuutsjabloon worden toegepast.',
        'parent_attribute_template' => 'Dit attribuutsjabloon kan gerelateerd zijn aan een ander attribuutsjabloon. Bij het toepassen van deze attribuutsjabloon worden deze en al zijn bovenliggende entiteiten toegepast.',
    ],
    'index'                 => [],
    'placeholders'          => [
        'name'  => 'Naam van de attribuutsjabloon',
    ],
    'show'                  => [],
];
