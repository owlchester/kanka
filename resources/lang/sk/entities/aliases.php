<?php

return [
    'actions'       => [
        'add'   => 'Pridať alias',
    ],
    'create'        => [
        'success'   => 'Alias :name pridaný k :entity.',
        'title'     => 'Pridať alias k :name',
    ],
    'destroy'       => [
        'success'   => 'Alias :name odstránený.',
    ],
    'fields'        => [
        'name'  => 'Názov',
    ],
    'helpers'       => [
        'primary'   => 'Nastavením jedného alebo viacerých aliasov objektu ho umožňuje nájsť v rámci celkového hľadania (horná lišta) a cez referencie.',
    ],
    'placeholders'  => [
        'name'  => 'Nový alias',
    ],
    'unboosted'     => [
        'text'  => 'Pridávanie aliasov k objektom pre hľadanie a referencie je rezervované pre :boosted-campaigns.',
    ],
    'update'        => [
        'success'   => 'Alias :name aktualizovaný pre :entity.',
        'title'     => 'Aktualizovať alias pre :name',
    ],
];
