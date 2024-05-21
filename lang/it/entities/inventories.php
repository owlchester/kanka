<?php

return [
    'actions'       => [
        'add'   => 'Aggiungi oggetto',
    ],
    'create'        => [
        'success'   => 'L\'oggetto :item è stato aggiunto ad :entity.',
        'title'     => 'Aggiungi un oggetto a :name',
    ],
    'destroy'       => [
        'success'   => 'L\'oggetto :item è stato rimosso da :entity.',
    ],
    'fields'        => [
        'amount'        => 'Quantità',
        'description'   => 'Descrizione',
        'is_equipped'   => 'Equipaggiato',
        'name'          => 'Nome',
        'position'      => 'Posizione',
        'qty'           => 'Quantità',
    ],
    'helpers'       => [],
    'placeholders'  => [
        'amount'        => 'Qualsiasi quantità',
        'description'   => 'Utilizzato, Danneggiato, In Sintonia',
        'name'          => 'Richiesto se nessun oggetto è stato selezionato',
        'position'      => 'Equipaggiato, Zaino, Magazzino, Banca',
    ],
    'show'          => [
        'helper'    => 'Le entità possono avere oggetti collegati ad esse per creare degli inventari.',
        'title'     => 'Inventario dell\'Entità :name',
        'unsorted'  => 'Non classificato',
    ],
    'update'        => [
        'success'   => 'L\'oggetto :item è stato aggiornato per :entity.',
        'title'     => 'Aggiorna un oggetto per :name',
    ],
];
