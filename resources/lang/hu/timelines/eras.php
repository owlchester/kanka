<?php

return [
    'actions'       => [
        'add'   => 'Új korszak hozzáadása',
    ],
    'create'        => [
        'success'   => 'A \':name\' korszakot létrehoztuk.',
        'title'     => 'Új korszak',
    ],
    'delete'        => [
        'success'   => 'A \':name\' korszakot eltávolítottuk.',
    ],
    'edit'          => [
        'success'   => 'A \':name\' korszakot frissítettük.',
        'title'     => ':name korszak szerkesztése',
    ],
    'fields'        => [
        'abbreviation'  => 'Rövidítés',
        'end_year'      => 'Záró éve',
        'start_year'    => 'Kezdő éve',
    ],
    'helpers'       => [
        'eras'      => 'Létre kell hozni az idővonalat, mielőtt korszakokat rendelnél hozzá.',
        'primary'   => 'Oszd fel az idővonalad korszakokra. Egy idővonal legalább egy korszakból kell álljon a helyes működéshez.',
    ],
    'placeholders'  => [
        'abbreviation'  => 'Kr. e, IU, stb.',
        'end_year'      => 'Az év, amikor a korszak véget ér. Hagy üresen, ha ez az aktuális korszak.',
        'name'          => 'Modern kor, Bronz kor, Galaktikus Háborúk',
        'start_year'    => 'Az év, amellyel a korszak megkezdődik. Hagyd üresen, ha ez a korszak az aktuális.',
    ],
];
