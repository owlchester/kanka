<?php

return [
    'actions'           => [
        'copy_inventory'    => 'Copia inventario',
    ],
    'copy'              => [],
    'create'            => [
        'success'       => 'L\'oggetto :item è stato aggiunto ad :entity.',
        'success_bulk'  => '{0} Nessun oggetto aggiunto a :entity.|{1} Aggiunto :count oggetto a :entity.|[2,*] Aggiunti :count oggetti a :entity.',
        'title'         => 'Aggiungi un oggetto a :name',
    ],
    'default_position'  => 'Disorganizzato',
    'destroy'           => [
        'success'           => 'L\'oggetto :item è stato rimosso da :entity.',
        'success_position'  => 'Oggetti in :position rimossi da :entity.',
    ],
    'fields'            => [
        'amount'                => 'Quantità',
        'copy_entity_entry_v2'  => 'Utilizza la voce dell\'oggetto',
        'description'           => 'Descrizione',
        'is_equipped'           => 'Equipaggiato',
        'name'                  => 'Nome',
        'position'              => 'Posizione',
        'qty'                   => 'Quantità',
    ],
    'helpers'           => [
        'amount'                => 'Numero degli oggetti',
        'copy_entity_entry_v2'  => 'Visualizza la voce dell\'oggetto invece della descrizione personalizzata.',
        'description'           => 'Aggiungi una descrizione personalizzata all\'oggetto',
        'is_equipped'           => 'Contrassegna questo oggetto come equipaggiato.',
        'name'                  => 'Assegna il nome all\'oggetto. Il nome è richiesto se non è stato selezionato alcun oggetto',
    ],
    'placeholders'      => [
        'amount'        => 'Qualsiasi quantità',
        'description'   => 'Utilizzato, Danneggiato, In Sintonia',
        'name'          => 'Richiesto se nessun oggetto è stato selezionato',
        'position'      => 'Equipaggiato, Zaino, Magazzino, Banca',
    ],
    'show'              => [
        'helper'    => 'Le entità possono avere oggetti collegati ad esse per creare degli inventari.',
        'title'     => 'Inventario dell\'Entità :name',
        'unsorted'  => 'Non classificato',
    ],
    'tooltips'          => [
        'equipped'  => 'Questo oggetto è equipaggiato',
    ],
    'update'            => [
        'success'   => 'L\'oggetto :item è stato aggiornato per :entity.',
        'title'     => 'Aggiorna un oggetto per :name',
    ],
];
