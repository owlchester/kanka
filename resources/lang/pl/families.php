<?php

return [
    'create'        => [
        'description'   => 'Stwórz nową rodzinę',
        'success'       => 'Rodzina \':name\' stworzona.',
        'title'         => 'Nowa Rodzina',
    ],
    'destroy'       => [
        'success'   => 'Rodzina \':name\' usunięta.',
    ],
    'edit'          => [
        'success'   => 'Rodzina \':name\' zaktualizowana.',
        'title'     => 'Edycja rodziny :name',
    ],
    'fields'        => [
        'families'  => 'Rodziny pochodne',
        'family'    => 'Rodzina źródłowa',
        'image'     => 'Obraz',
        'location'  => 'Miejsce',
        'members'   => 'Członkowie',
        'name'      => 'Nazwa',
        'relation'  => 'Relacja',
        'type'      => 'Rodzaj',
    ],
    'helpers'       => [
        'descendants'   => 'Na liście znajdują się wszystkie rodziny wywodzące się od tej rodziny, nie tylko bezpośrednio.',
        'nested'        => 'W Widoku Zagnieżdżonym na poziomie podstawowym wyświetlane są rodziny, które nie mają źródła. Po kliknięciu na rodzinę zobaczysz jej rodziny pochodne. Możesz klikać, póki nie skończą się poziomy zależności.',
    ],
    'hints'         => [
        'members'   => 'Lista członków rodziny. Aby dodać postać do rodziny, wybierz ją z listy w pozycji "Rodzina" podczas edycji tej postaci.',
    ],
    'index'         => [
        'add'   => 'Nowa Rodzina',
    ],
    'members'       => [
        'title' => 'Członkowie rodziny :name',
    ],
    'placeholders'  => [
        'location'  => 'Wybierz miejsce',
        'name'      => 'Nazwisko rodowe',
        'type'      => 'Królewska, szlachecka, wymarła',
    ],
];
