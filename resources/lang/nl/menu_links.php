<?php

return [
    'create'        => [
        'success'   => 'Snelle Link \':name\' gemaakt.',
        'title'     => 'Nieuwe Snelle Link',
    ],
    'destroy'       => [
        'success'   => 'Menu Quick \':name\' verwijderd.',
    ],
    'edit'          => [
        'success'   => 'Snelle Link \':name\' bijgewerkt.',
        'title'     => 'Snelle Link :name',
    ],
    'fields'        => [
        'dashboard'     => 'Dashboard',
        'entity'        => 'Entiteit',
        'filters'       => 'Filters',
        'menu'          => 'Menu',
        'name'          => 'Naam',
        'position'      => 'Positie',
        'random'        => 'Willekeurig',
        'random_type'   => 'Willekeurig Entiteit Type',
        'selector'      => 'Quick Link Configuratie',
        'tab'           => 'Tabblad',
        'type'          => 'Entiteit Type',
    ],
    'helpers'       => [
        'dashboard' => 'Laat de snelkoppeling een van de custom dashboards van de campaign targeten.',
        'entity'    => 'Stel deze snelle link in om rechtstreeks naar een entiteit te gaan. Het :tab veld bepaalt welke van de tabbladen de focus heeft. Het :menu veld bepaalt welke subpagina van de entiteit wordt geopend.',
        'position'  => 'Gebruik dit veld om te bepalen in welke oplopende volgorde de links in het menu verschijnen.',
        'random'    => 'Gebruik dit veld om een snelle link naar een willekeurige entiteit te laten verwijzen. Je kunt de link filteren om alleen naar een specifiek entiteit type te gaan.',
        'selector'  => 'Configureer waar deze snelle link naartoe gaat wanneer een gebruiker erop klikt in de zijbalk.',
        'type'      => 'Stel deze snelle link in om rechtstreeks naar een lijst met entiteiten te gaan. Om de resultaten te filteren, kopieer je delen van de url in de gefilterde entiteitenlijst na het :? teken op het :filter veld.',
    ],
    'index'         => [
        'add'   => 'Nieuwe Snelle Link',
        'title' => 'Snelle Links',
    ],
    'placeholders'  => [
        'entity'    => 'Kies een entiteit',
        'filters'   => 'location_id=15&type=city',
        'menu'      => 'Menu subpagina (gebruik de laatste tekst van de url)',
        'name'      => 'Naam van de snelle link',
        'tab'       => 'invoer, relaties, notities',
    ],
    'random_types'  => [
        'any'   => 'Elke entiteit',
    ],
    'show'          => [],
];
