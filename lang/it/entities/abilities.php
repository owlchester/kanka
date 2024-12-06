<?php

return [
    'actions'   => [
        'add'   => 'Aggiungi abilità',
        'reset' => 'Ripristina gli usi dell\'abilità',
        'sync'  => 'Aggiungi alle stirpi',
    ],
    'charges'   => [
        'left'  => ':amount rimaste',
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
    'groups'    => [
        'unorganised'   => 'Disorganizzato',
    ],
    'helpers'   => [
        'note'      => 'Puoi citare un\'entità usando la menzione avanzata (ex :code) e gli attributi dell\'entità (ex :attr) in questo campo.',
        'recharge'  => 'Azzeramento di tutte le cariche delle abilità utilizzate.',
        'sync'      => 'Importa le abilità definite nelle stirpi del personaggio.',
    ],
    'import'    => [
        'errors'    => [
            'no_race'       => 'Il personaggio non ha una stirpe.',
            'not_character' => 'Questa entità non è un personaggio.',
        ],
        'success'   => '{1} :count abilità importata.|[2,*] :count abilità importate.',
    ],
    'recharge'  => [
        'success'   => 'Tutte le cariche sono state azzerate.',
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
    'types'     => [
        'unorganised'   => 'Le abilità sono raggruppate in base al loro campo genitore, e si trovano qui.',
    ],
    'update'    => [
        'success'   => 'Abilità dell\'entità :ability aggiornata.',
        'title'     => 'Abilità dell\'entità per :name',
    ],
];
