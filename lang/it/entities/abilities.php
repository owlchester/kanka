<?php

return [
    'actions'   => [
        'add'                       => 'Aggiungi abilità',
        'import_from_race'          => 'Aggiungi abilità di stirpe',
        'import_from_race_mobile'   => 'Abilità di stirpe',
        'reset'                     => 'Ripristina gli usi dell\'abilità',
    ],
    'create'    => [
        'success'           => 'Abilità :ability aggiunta a :entity.',
        'success_multiple'  => 'Abilità :abilities aggiunte a :entity',
        'title'             => 'Aggiungi abilità a :name',
    ],
    'fields'    => [
        'note'      => 'Nota',
        'position'  => 'Posizione',
    ],
    'helpers'   => [
        'note'  => 'Puoi citare un\'entità usando la menzione avanzata (ex :code) e gli attributi dell\'entità (ex :attr) in questo campo.',
    ],
    'import'    => [
        'errors'    => [
            'no_race'       => 'Il personaggio non ha una stirpe.',
            'not_character' => 'Questa entità non è un personaggio.',
        ],
        'success'   => '{1} :count abilità importata.|[2,*] :count abilità importate.',
    ],
    'reorder'   => [
        'parentless'    => 'Nessun Genitore',
        'success'       => 'Abiità riordinate con successo',
    ],
    'show'      => [
        'helper'    => 'Collega le abilità a questa entità. È sempre possibile modificare la visibilità o rimuovere un\'abilità. Le abilità che appartengono alla stessa abilità genitore verranno visualizzate come caselle di filtro.',
        'reorder'   => 'Riordina',
        'title'     => 'Abilità di :name',
    ],
    'update'    => [
        'title' => 'Abilità dell\'entità per :name',
    ],
];
