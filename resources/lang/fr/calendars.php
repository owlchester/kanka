<?php

return [
    'actions'       => [
        'add_month'     => 'Ajouter un mois',
        'add_weekday'   => 'Ajouter un jour de semaine',
        'add_year'      => 'Ajouter un nom d\'année',
    ],
    'create'        => [
        'description'   => 'Créer un nouveau calendrier',
        'success'       => 'Nouveau calendrier \':name\' créé.',
        'title'         => 'Nouveau Calendrier',
    ],
    'destroy'       => [
        'success'   => 'Calendrier \':name\' supprimé.',
    ],
    'edit'          => [
        'success'   => 'Calendrier \':name\' modifié.',
        'title'     => 'Modifier le calendrier :name',
    ],
    'fields'        => [
        'current_day'       => 'Jour Actuel',
        'current_month'     => 'Mois actuel',
        'current_year'      => 'Année actuelle',
        'date'              => 'Date actuelle',
        'has_leap_year'     => 'Année bissextile',
        'leap_year_amount'  => 'Jours à ajouter',
        'leap_year_month'   => 'Mois',
        'leap_year_offset'  => 'Chaque',
        'leap_year_start'   => 'Année bissextile',
        'months'            => 'Mois',
        'name'              => 'Nom',
        'parameters'        => 'Paramètres',
        'seasons'           => 'Saisons',
        'suffix'            => 'Suffix',
        'type'              => 'Type',
        'weekdays'          => 'Jours de la semaine',
    ],
    'index'         => [
        'add'           => 'Nouveau Calendrier',
        'description'   => 'Gestion des calendriers pour :name.',
        'header'        => 'Calendriers de :name',
        'title'         => 'Calendrier',
    ],
    'panels'        => [
        'leap_year' => 'Année bissextile',
        'years'     => 'Nom d\'années',
    ],
    'parameters'    => [
        'month' => [
            'length'    => 'Nombre de jours',
            'name'      => 'Nom du mois',
        ],
        'year'  => [
            'name'      => 'Nom',
            'number'    => 'Année',
        ],
    ],
    'placeholders'  => [
        'date'              => 'La date actuelle',
        'leap_year_amount'  => 'Nombre de jours à ajouter lors d\'une année bissextile',
        'leap_year_month'   => 'Mois durant lequel les jours sont à ajouter',
        'leap_year_offset'  => 'Nombre d\'années entre chaque année bissextile',
        'leap_year_start'   => 'Première année bissextile',
        'months'            => 'Nombre de mois dans une année',
        'name'              => 'Nom du calendrier',
        'seasons'           => 'Nombre de saisons',
        'suffix'            => 'Suffix de l\'époque actuelle (AC, BC)',
        'type'              => 'Type de calendrier',
        'weekdays'          => 'Nombre de jours dans une semaine',
    ],
    'show'          => [
        'description'   => 'Vue détaillée d\'un calendrier',
        'tabs'          => [
            'information'   => 'Information',
        ],
        'title'         => 'Calendrier :name',
    ],
];
