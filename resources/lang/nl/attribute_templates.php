<?php

return [
    'attribute_templates'   => [
        'title' => ':name attribuutsjablonen',
    ],
    'create'                => [
        'description'   => 'Maak een nieuwe attribuutsjabloon',
        'success'       => 'Attribuutsjabloon \':naam\' gemaakt.',
        'title'         => 'Nieuw attribuutsjabloon',
    ],
    'destroy'               => [
        'success'   => 'Attribuutsjabloon \':naam\' verwijderd.',
    ],
    'edit'                  => [
        'description'   => 'Wijzig een attribuutsjabloon',
        'success'       => 'Attribuutsjabloon \':naam\' bijgewerkt.',
        'title'         => 'Wijzig attribuutsjabloon :name',
    ],
    'fields'                => [
        'attribute_template'    => 'Bovenliggende Attribuutsjabloon',
        'attributes'            => 'Attributen',
        'name'                  => 'Naam',
    ],
    'hints'                 => [
        'automatic'                 => 'Attributen worden automatisch toegepast vanuit de :link Attribuutsjabloon',
        'entity_type'               => 'Indien ingesteld, zal bij het maken van een nieuwe entiteit van dit type automatisch deze attribuutsjabloon worden toegepast.',
        'parent_attribute_template' => 'Dit attribuutsjabloon kan gerelateerd zijn aan een ander attribuutsjabloon. Bij het toepassen van deze attribuutsjabloon worden deze en al zijn bovenliggende entiteiten toegepast.',
    ],
    'index'                 => [
        'add'           => 'Nieuw attribuutsjabloon',
        'description'   => 'Beheer de Attribuutsjablonen van :naam.',
        'header'        => 'Attribuutsjablonen van :naam',
        'title'         => 'Attribuutsjablonen',
    ],
    'placeholders'          => [
        'attribute_template'    => 'Kies een attribuutsjabloon',
        'name'                  => 'Naam van de attribuutsjabloon',
    ],
    'show'                  => [
        'description'   => 'Een gedetailleerd overzicht van een attribuutsjabloon',
        'tabs'          => [
            'attribute_templates'   => 'Attribuutsjablonen',
            'attributes'            => 'Attributen',
        ],
        'title'         => 'Attribuutsjabloon :name',
    ],
];
