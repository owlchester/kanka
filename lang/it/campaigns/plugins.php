<?php

return [
    'actions'       => [
        'bulks'             => [
            'disable'   => 'Disattiva plugin',
            'enable'    => 'Attiva plugin',
            'update'    => 'Aggiorna plugin',
        ],
        'changelog'         => 'Registro',
        'disable'           => 'Disattiva plugin',
        'enable'            => 'Attiva plugin',
        'import'            => 'Importa',
        'update'            => 'Aggiorna plugin',
        'update_available'  => 'Aggiornamento disponibile!',
    ],
    'bulks'         => [
        'delete'    => '{1} Rimosso :count plugin.|[2,*] Rimossi :count plugin.',
        'disable'   => '{1} Disattivato :count plugin.|[2,*] Disattivati :count plugin.',
        'enable'    => '{1} Attivato :count plugin.|[2,*] Attivati :count plugins.',
        'update'    => '{1} Aggiornato :count plugin.|[2,*] Aggiornati :count plugin.',
    ],
    'destroy'       => [
        'success'   => 'Plugin :plugin rimosso.',
    ],
    'disabled'      => [
        'success'   => 'Plugin :plugin disattivato.',
    ],
    'empty_list'    => 'La campagna non ha attualmente alcun plugin. Vai al Mercato per installarne alcuni e torna qui per attivarli.',
    'enabled'       => [
        'success'   => 'Plugin :plugin attivato.',
    ],
    'errors'        => [
        'invalid_plugin'    => 'Plugin invalido.',
    ],
    'fields'        => [
        'name'      => 'Nome plugin',
        'obsolete'  => 'Questo plugin è stato dichiarato obsoleto dal team di Kanka, il che significa che non funziona più come previsto dal suo creatore.',
        'status'    => 'Stato',
        'type'      => 'Tipo di plugin',
    ],
    'import'        => [
        'button'                => 'Importa',
        'created'               => 'Create le seguenti entità:',
        'helper'                => 'Stai per importare :count entità dal plugin :plugin. Se questo plugin è stato importato in precedenza, le modifiche apportate alle entità importate possono andare perse.',
        'no_new_entities'       => 'Non ci sono nuove entità da importare.',
        'option_only_import'    => 'Importa solo le nuove entità, saltando quelle importate in precedenza.',
        'option_private'        => 'Importa tutte le entità come private.',
        'success'               => '{1} Importata :count entità dal plugin :plugin.|[2,*] Importate :count entità dal plugin :plugin.',
        'title'                 => 'Importa :plugin',
        'updated'               => 'Aggiornate le seguenti entità:',
    ],
    'info'          => [
        'helper'    => 'Quando viene rilasciata una nuova versione di un plugin, puoi aggiornarlo alla versione più recente per la tua campagna.',
        'title'     => 'Aggiornamenti del plugin :plugin',
        'updates'   => 'Aggiornamenti',
    ],
    'pitch'         => 'Installa e organizza i plugin dal :marketplace',
    'status'        => [
        'disabled'  => 'Disattivato',
        'enabled'   => 'Attivato',
    ],
    'templates'     => [
        'name'  => ':name da :user',
    ],
    'title'         => 'Plugin - :name',
    'types'         => [
        'attribute' => 'Template dell\'attributo',
        'pack'      => 'Pacchetto di Contenuti',
        'theme'     => 'Tema',
    ],
    'update'        => [
        'success'   => 'Plugin :plugin aggiornato.',
    ],
];
