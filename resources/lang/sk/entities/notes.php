<?php

return [
    'actions'       => [
        'add'   => 'Nová Poznámka',
    ],
    'create'        => [
        'description'   => 'Vytvor novú Poznámku k Objektu',
        'success'       => 'Poznámka :name pridaná k objektu :entity.',
        'title'         => 'Nová Poznámka pre :name',
    ],
    'destroy'       => [
        'success'   => 'Poznámka :name odstránená z :entity.',
    ],
    'edit'          => [
        'description'   => 'Upraviť existujúcu Poznámku',
        'success'       => 'Poznámka :name pre :entity upravená.',
        'title'         => 'Upraviť poznámku pre :name',
    ],
    'fields'        => [
        'creator'   => 'Autor/ka',
        'entry'     => 'Hodnota',
        'name'      => 'Názov',
    ],
    'hint'          => 'Informácie, ktoré nepasujú do štandardných polí objektu alebo by mali byť súkromné, môžu byť pridané v podobe poznámok.',
    'index'         => [
        'title' => 'Poznámky pre :name',
    ],
    'placeholders'  => [
        'name'  => 'Názov poznámky, zistenia alebo pripomienky',
    ],
    'show'          => [
        'title' => 'Poznámka :name objektu :entity',
    ],
];
