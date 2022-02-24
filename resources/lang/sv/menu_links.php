<?php

return [
    'create'        => [
        'success'   => 'Snapplänk \':name\' skappad.',
        'title'     => 'Ny Snabblänk',
    ],
    'destroy'       => [
        'success'   => 'Snabblänk \':name\' borttagen.',
    ],
    'edit'          => [
        'success'   => 'Snabblänk \':name\' uppdaterad.',
        'title'     => 'Snabblänk :name',
    ],
    'fields'        => [
        'entity'        => 'Entitet',
        'filters'       => 'Filter',
        'menu'          => 'Meny',
        'name'          => 'Namn',
        'position'      => 'Position',
        'random'        => 'Slumpmässig',
        'random_type'   => 'Slumpmässig Entitetstyp',
        'tab'           => 'Flik',
        'type'          => 'Entitetstyp',
    ],
    'helpers'       => [
        'entity'    => 'Ställ in denna snabblänk att gå direkt till en entitet. :tab fältet kontrollerar vilken flik som sätts i fokus. :menu fältet kontrollerar vilken undersida för entiteten är öppen.',
        'position'  => 'Använd detta fält för att kontrollera vilken stigande ordning länkarna visas i menyn.',
        'random'    => 'Använd detta fältet för att få snabblänken att peka på en slumpmässig entitet. Du kan filtrera länken att bara leda till en specifik entitetstyp.',
        'type'      => 'Ställ in denna snabblänk att gå direkt till en lista över entiteter. För att filtrera resultaten, kopiera delarna efter :? i url:en för en filtrerad entitets lista till :filter fältet.',
    ],
    'index'         => [
        'add'   => 'Ny Snabblänk',
        'title' => 'Snabblänkar',
    ],
    'placeholders'  => [
        'entity'    => 'Välj en entitet',
        'filters'   => 'location_id=15&type=stad',
        'menu'      => 'Meny undersida (använd den förra texten för url:en)',
        'name'      => 'Namn på snabblänken',
        'tab'       => 'Notering, Förbindelser, Anteckningar',
    ],
    'random_types'  => [
        'any'   => 'Valfri entitet',
    ],
    'show'          => [
        'tabs'  => [
        ],
        'title' => 'Snabblänk :name',
    ],
];
