<?php

return [
    'actions'   => [
        'add'                       => 'Aggiungi un\'abilità',
        'import_from_race'          => 'Aggiungi abilitò di razza',
        'import_from_race_mobile'   => 'Abilità della razza',
        'reset'                     => 'Reimposta gli utilizzi dell\'abilità',
    ],
    'create'    => [
        'success'           => 'Abilità :ability aggiunta a :entity.',
        'success_multiple'  => 'Abilità :abilità aggiunte a :entità',
        'title'             => 'Aggiungi un\'abilità a :name',
    ],
    'fields'    => [
        'note'      => 'Nota',
        'position'  => 'Posizione',
    ],
    'helpers'   => [
        'note'  => 'Puoi citare un\'entità usando la menzione avanzata (ex :code) e le caratteristiche dell\'entità (ex :attr) in questo campo.',
    ],
    'import'    => [
        'errors'    => [
            'no_race'       => 'Il personaggio non ha una razza.',
            'not_character' => 'L\'entità non è un personaggio.',
        ],
        'success'   => '{1} :count abilità importata.|[2,*] :count abilità importate.',
    ],
    'reorder'   => [
        'success'   => 'Abilità riordinate con successo',
    ],
    'show'      => [
        'helper'    => 'Lega abilità a questa entità. Puoi sempre modificare la visibilità o rimuovere un\'abilità. Le abilità appartenenti alla medesima abilità genitore saranno mostrate come dei riquadri filtranti.',
        'reorder'   => 'Riordina',
        'title'     => 'Abilità dell\'entità :name',
    ],
    'update'    => [
        'title' => 'Abilità dell\'entità per :nome',
    ],
];
