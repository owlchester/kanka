<?php

return [
    'create'        => [
        'success'   => 'Dodano element historii.',
        'title'     => 'Nowy element historii',
    ],
    'delete'        => [
        'success'   => 'Usunięto element :name.',
    ],
    'edit'          => [
        'success'   => 'Zaktualizowano element',
        'title'     => 'Edycja elementu historii',
    ],
    'fields'        => [
        'date'              => 'Data',
        'era'               => 'Epoka',
        'icon'              => 'Ikona',
        'use_entity_entry'  => 'Wyświetlaj dołączony element. Po zaznaczeniu, ewentualny opis elementu będzie wyświetlany jako pierwszy.',
    ],
    'helpers'       => [
        'entity_is_private' => 'Element powiązany z tym wpisem jest tajny.',
        'icon'              => 'Skopiuj kod HTML ikony z :fontawesome lub :rpgawesome.',
        'is_collapsed'      => 'Szczegóły elementu są domyślnie zwinięte.',
    ],
    'placeholders'  => [
        'date'      => 'np. 42 marca albo 1332-1337',
        'name'      => 'Wymagana, jeżeli nie wskazano elementu',
        'position'  => 'Kolejność na liście elementów tej epoki. Zostaw puste, by dodać na końcu.',
    ],
];
