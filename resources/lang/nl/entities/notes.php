<?php

return [
    'actions'       => [
        'add'       => 'Nieuwe Entieit Notitie',
        'add_user'  => 'Voeg gebruiker toe',
    ],
    'create'        => [
        'description'   => 'Maak een nieuwe Entiteit Notitie',
        'success'       => 'Entiteit Notitie \':name\' toegevoegd aan :entity',
        'title'         => 'Nieuwe Entiteit Notitie voor :name',
    ],
    'destroy'       => [
        'success'   => 'Entiteit Notitie \':name\' voor :entity verwijderd.',
    ],
    'edit'          => [
        'description'   => 'Werk een bestaande entiteit notitie bij',
        'success'       => 'Entiteit Notitie \':name\' voor :entity bijgewerkt.',
        'title'         => 'Werk entiteit notitie bij voor :name',
    ],
    'fields'        => [
        'creator'   => 'Maker',
        'entry'     => 'Invoer',
        'is_pinned' => 'Vastgemaakt',
        'name'      => 'Naam',
        'position'  => 'Vastgemaakte positie',
    ],
    'hint'          => 'Informatie die niet helemaal in de standaardvelden van een entiteit past of die privé moet worden gehouden, kan worden toegevoegd als Entiteit Notitie.',
    'hints'         => [
        'is_pinned' => 'Vastgemaakte entiteit notities worden weergegeven onder de tekst van de entiteit in de primaire entiteit weergave. Combineer met het positieveld om te bepalen in welke volgorde vastgezette entiteit notities worden weergegeven.',
    ],
    'index'         => [
        'title' => 'Entiteit Notities voor :name',
    ],
    'placeholders'  => [
        'name'  => 'Naam van de entiteit notitie, observatie of opmerking',
    ],
    'show'          => [
        'advanced'  => 'Geavanceerde Machtigingen',
        'title'     => 'Entiteit Notitie :name voor :entity',
    ],
];
