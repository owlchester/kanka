<?php

return [
    'actions'       => [
        'add'       => 'Nová Poznámka',
        'add_user'  => 'Pridať užívateľa',
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
        'collapsed' => 'Zatvoriť pripnutú poznámku objektu štandardne',
        'creator'   => 'Autor/ka',
        'entry'     => 'Hodnota',
        'is_pinned' => 'Pripnutá',
        'name'      => 'Názov',
        'position'  => 'Pozícia pripnutia',
    ],
    'hint'          => 'Informácie, ktoré nepasujú do štandardných polí objektu alebo by mali byť súkromné, môžu byť pridané v podobe poznámok.',
    'hints'         => [
        'is_pinned' => 'Pripnuté poznámky objektov sú zobrazené pod textom objektu v primárnom zobrazení objektu. Kombinovať ich môžeš s pozíciou kvôli ich usporiadaniu.',
        'reorder'   => 'Môžeš zmeniť poradie poznámok daného objektu kliknutím na ikonku :icon vedľa Príbehu v menu objektu.',
    ],
    'index'         => [
        'title' => 'Poznámky pre :name',
    ],
    'placeholders'  => [
        'name'  => 'Názov poznámky, zistenia alebo pripomienky',
    ],
    'show'          => [
        'advanced'  => 'Rozšírené oprávnenia',
        'title'     => 'Poznámka :name objektu :entity',
    ],
];
