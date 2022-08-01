<?php

return [
    'actions'       => [
        'add'   => 'Lägg till en länk',
    ],
    'create'        => [
        'success'   => 'Länk :name tillagd till :entity.',
        'title'     => 'Lägg till en länk till :name',
    ],
    'destroy'       => [
        'success'   => 'Länk :name borttagen från :entity.',
    ],
    'fields'        => [
        'icon'      => 'Ikon',
        'name'      => 'Namn',
        'position'  => 'Position',
        'url'       => 'URL',
    ],
    'helpers'       => [
        'icon'  => 'Du kan anpassa ikonen som visas för länken. Använd någon gratis ikon från :fontawesome eller lämna detta fält blankt för att använda standard ikonen.',
    ],
    'placeholders'  => [
        'name'  => 'DNDBeyond',
        'url'   => 'https://dndbeyond.com/character-url',
    ],
    'show'          => [
        'helper'    => 'Boostade kampanjer kan lägga till länkar till entiteter som pekar till externa websidor.',
        'title'     => 'Länkar för :name',
    ],
    'update'        => [
        'success'   => 'Länk :name uppdaterad för :entity.',
        'title'     => 'Uppdatera länk för :name',
    ],
];
