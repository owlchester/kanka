<?php

return [
    'characters'    => [
        'description'   => 'Postavy patriace k danej rase.',
        'helpers'       => [
            'all_characters'    => 'Zobrazí všetky postavy tejto rasy a jej podradených rás.',
            'characters'        => 'Zobrazí všetky postavy iba tejto rasy.',
        ],
        'title'         => 'Postavy rasy :name',
    ],
    'create'        => [
        'description'   => 'Vytvoriť novú rasu',
        'success'       => 'Rasa :name vytvorená.',
        'title'         => 'Nová rasa',
    ],
    'destroy'       => [
        'success'   => 'Rasa :name odstránená.',
    ],
    'edit'          => [
        'success'   => 'Rasa :name upravená.',
        'title'     => 'Upraviť rasu :name',
    ],
    'fields'        => [
        'characters'    => 'Postavy',
        'name'          => 'Názov',
        'race'          => 'Nadradená rasa',
        'races'         => 'Podrasy',
        'type'          => 'Typ',
    ],
    'helpers'       => [
        'nested'        => 'Vo vnorenom zobrazení vieš zoradiť tvoje rasy podľa nadradených rás. Rasy bez nadradenej rasy sa zoradia štandardným spôsobom. Rasy s podrasami je možné rozkliknúť, dokiaľ nebudú existovať už žiadne ďalšie podrasy.',
        'nested_parent' => 'Zobraziť rasy :parent.',
        'nested_without'=> 'Zobrazujú sa všetky rasy, ktoré nemajú nadradenú rasu. Kliknutím na riadok zobrazíš podradené rasy.',
    ],
    'index'         => [
        'add'           => 'Nová rasa',
        'description'   => 'Spravovať rasy :name.',
        'header'        => 'Rasy :name',
        'title'         => 'Rasy',
    ],
    'placeholders'  => [
        'name'  => 'Názov rasy',
        'type'  => 'Človek, Fey, Borg',
    ],
    'races'         => [
        'description'   => 'Rasy patriace pod danú rasu.',
        'title'         => 'Podrasy rasy :name',
    ],
    'show'          => [
        'description'   => 'Detailné zobrazenie rasy',
        'tabs'          => [
            'characters'    => 'Postavy',
            'menu'          => 'Menu',
            'races'         => 'Podrasy',
        ],
        'title'         => 'Rasa :name',
    ],
];
