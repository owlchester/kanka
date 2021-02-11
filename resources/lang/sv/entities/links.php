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
        'goto'      => 'Gå till :name',
        'icon'      => 'Du kan anpassa ikonen som visas för länken. Använd någon gratis ikon från :fontawesome eller lämna detta fält blankt för att använda standard ikonen.',
        'leaving'   => 'Du är påväg att lämna Kanka och gå till en annan domän. Sidan du är på väg till angavs av en användare och är inte kontrollerad av vår hemsida.',
        'url'       => 'url:en du kommer gå till är :url.',
    ],
    'placeholders'  => [
        'icon'  => 'fab fa-d-and-d-beyond',
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
