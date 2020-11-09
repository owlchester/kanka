<?php

return [
    'actions'       => [
        'back'      => 'Späť na :name',
        'edit'      => 'Upraviť mapu',
        'explore'   => 'Prieskumník',
    ],
    'create'        => [
        'success'   => 'Mapa :name vytvorená.',
        'title'     => 'Nová mapa',
    ],
    'destroy'       => [
        'success'   => 'Mapa :name odstránená.',
    ],
    'edit'          => [
        'success'   => 'Mapa :name aktualizovaná.',
        'title'     => 'Upraviť mapu :name',
    ],
    'errors'        => [
        'dashboard' => [
            'missing'   => 'Táto mapa vyžaduje obrázok, aby mohla byť zobrazená na nástenke.',
        ],
        'explore'   => [
            'missing'   => 'Na použitie Prieskumníka budeš musieť najprv pridať obrázok mapy.',
        ],
    ],
    'fields'        => [
        'center_x'          => 'Štandardná zemepisná dĺžka',
        'center_y'          => 'Štandardná zemepisná šírka',
        'distance_measure'  => 'Mierka vzdialenosti',
        'distance_name'     => 'Jednotka vzdialenosti',
        'grid'              => 'Mriežka',
        'initial_zoom'      => 'Prvotné priblíženie',
        'map'               => 'Nadradená mapa',
        'maps'              => 'Mapy',
        'max_zoom'          => 'Maximálne priblíženie',
        'min_zoom'          => 'Minimálne priblíženie',
        'name'              => 'Názov',
        'type'              => 'Typ',
    ],
    'helpers'       => [
        'center'            => 'Zmenou týchto hodnôt vieš kontrolovať, na ktorú oblasť mapy bude zameraný náhľad. Ak hodnoty ponecháš prázdne, bude zameranie na stred mapy.',
        'descendants'       => 'Tento zoznam obsahuje všetky mapy, ktoré sú podradené tejto mape, ale nielen priamo pod ňou.',
        'distance_measure'  => 'Pridaním merania vzdialenosti sa aktivuje nástroj merania v Prieskumníkovi.',
        'grid'              => 'Definuj veľkosť mriežky, ktorá sa zobrazí v Prieskumníkovi.',
        'initial_zoom'      => 'Úroveň prvotného priblíženia mapy, s ktorou sa zobrazí na začiatku. Štandardná hodnota je :default, pričom najvyššia povolená hodnota je :max a najnižšia :min.',
        'max_zoom'          => 'Mapa môže byť priblížená maximálne na túto hodnotu. Štandardná hodnota je :default, najvyššia povolená hodnota je :max.',
        'min_zoom'          => 'Mapa môže byť oddialená maximálne na túto hodnotu. Štandardná hodnota je :default, najnižšia povolená hodnota je :max.',
        'missing_image'     => 'Na použitie vrstiev a značiek budeš musieť najprv pridať obrázok mapy.',
        'nested'            => 'Vo vnorenom zobrazení vieš zoradiť tvoje mapy podľa nadradených máp. Mapy bez nadradenej mapy sa zoradia štandardným spôsobom. Mapy s podradenými mapami je možné rozkliknúť, dokiaľ nebudú existovať už žiadne ďalšie podradené mapy.',
    ],
    'index'         => [
        'add'   => 'Nová mapa',
        'title' => 'Mapy',
    ],
    'maps'          => [
        'title' => 'Mapy objektu :name',
    ],
    'panels'        => [
        'groups'    => 'Skupiny',
        'layers'    => 'Vrstvy',
        'markers'   => 'Značky',
        'settings'  => 'Nastavenia',
    ],
    'placeholders'  => [
        'center_x'          => 'Ponechaj prázdne, ak sa mapa zobraziť vycentrovane',
        'center_y'          => 'Ponechaj prázdne, ak sa mapa zobraziť vycentrovane',
        'distance_measure'  => 'Počet jednotiek na pixel',
        'distance_name'     => 'Názov jednotky vzdialenosti (kilometer, míľa)',
        'grid'              => 'Vzdialenosť v pixloch medzi prvkami mriežky. Ponechaj prázdne, ak chceš mriežku vypnúť.',
        'name'              => 'Názov mapy',
        'type'              => 'Jaskyňa, Mesto, Galaxia',
    ],
    'show'          => [
        'tabs'  => [
            'maps'  => 'Mapy',
        ],
        'title' => 'Mapa :name',
    ],
];
