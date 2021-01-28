<?php

return [
    'actions'       => [
        'add'   => 'Voeg een nieuw tijdperk toe',
    ],
    'create'        => [
        'success'   => 'Tijdperk :name gemaakt',
        'title'     => 'Nieuw Tijdperk',
    ],
    'delete'        => [
        'success'   => 'Tijdperk :name verwijderd.',
    ],
    'edit'          => [
        'success'   => 'Tijdperk :name bijgewerkt.',
        'title'     => 'Wijzig Tijdperk :name',
    ],
    'fields'        => [
        'abbreviation'  => 'Afkorting',
        'end_year'      => 'Einde jaar',
        'start_year'    => 'Start Jaar',
    ],
    'helpers'       => [
        'eras'      => 'De tijdlijn moet worden gemaakt voordat er tijdperken aan kunnen worden toegevoegd.',
        'primary'   => 'Scheid je tijdlijn in tijdperken. Een tijdlijn heeft minstens één tijdperk nodig om goed te kunnen werken.',
    ],
    'placeholders'  => [
        'abbreviation'  => 'AD, BC, BCE',
        'end_year'      => 'Jaar waarin het tijdperk eindigt. Laat leeg als dit het huidige tijdperk is.',
        'name'          => 'Moderne Tijdperk, Bronze Tijdperk, Galactische Oorlogen',
        'start_year'    => 'Jaar waarin het tijdperk begint. Laat leeg als dit het eerste tijdperk is.',
    ],
    'reorder'       => [
        'success'   => 'Elementen van het :era tijdperk opnieuw gerangschikt.',
    ],
];
