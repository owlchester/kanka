<?php

return [
    'actions'   => [
        'clear'             => 'Cancella tutto',
        'first'             => 'Aggiungi un fondatore',
        'founder'           => 'Aggiungi un nuovo fondatore',
        'rename-relation'   => 'Rinomina la relazione',
        'reset'             => 'Scarta i cambiamenti',
        'save'              => 'Salva',
    ],
    'modal'     => [
        'first-title'   => 'Seleziona un\'entità',
        'helper'        => 'Sostituisci l\'entità con un\'altra della stessa campagna',
        'relation'      => 'Relazione',
        'title'         => 'Sostituisci l\'entità',
    ],
    'modals'    => [
        'clear'     => [
            'confirm'   => 'Sei sicuro di voler reinizializzare tutti i dati dell\'albero genealogico?',
        ],
        'entity'    => [
            'add'       => [
                'founder'   => 'Fondatore',
                'member'    => 'Membro',
                'success'   => 'Entità aggiunta.',
                'title'     => 'Aggungi un\'entità',
            ],
            'child'     => [
                'success'   => 'Figlio aggiunto.',
                'title'     => 'Aggiungi un figlio',
            ],
            'edit'      => [
                'helper'    => 'Seleziona questa opzione se la relazione è sconosciuta. Un personaggio può essere aggiunto in seguito.',
                'success'   => 'Entità aggiornata.',
                'title'     => 'Aggiorna un\'entità',
            ],
            'founder'   => [
                'title' => 'Aggiungi un nuovo fondatore',
            ],
            'remove'    => [
                'confirm'   => 'Sei sicuro di voler rimuovere questa entità dall\'albero genealogico?',
                'success'   => 'Entità rimossa.',
            ],
        ],
        'relations' => [
            'add'       => [
                'success'   => 'Relazione aggiunta.',
                'title'     => 'Aggiungi una relazione',
            ],
            'edit'      => [
                'success'   => 'Relazione aggiornata.',
                'title'     => 'Aggiorna una relazione',
            ],
            'unknown'   => 'Sconosciuto',
        ],
        'reset'     => [
            'confirm'   => 'Sei sicuro di voler eliminare tutte le modifiche apportate all\'albero genealogico?',
        ],
    ],
    'pitch'     => 'Crea un dettagliato albero genealogico per le famiglie della campagna.',
    'success'   => [
        'cleared'   => 'Albero genealogico cancellato.',
        'reseted'   => 'L\'albero genealogico è stato ripristinato.',
        'saved'     => 'L\'albero genealogico è stato salvato.',
    ],
    'title'     => 'Albero Genealogico :name',
    'unknown'   => 'non stabilito',
];
