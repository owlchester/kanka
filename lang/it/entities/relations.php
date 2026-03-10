<?php

return [
    'actions'           => [
        'mode-map'      => 'Strumento di Esplorazione di Legami',
        'mode-table'    => 'Tabella dei legami e degli elementi correlati',
    ],
    'bulk'              => [
        'delete'    => '{0} Rimossi :count legami|{1} Rimosso :count legame.|[2,*] Rimossi :count legami.',
        'fields'    => [
            'delete_mirrored'   => 'Elimina i speculari',
            'unmirror'          => 'Scollega i speculari',
            'update_mirrored'   => 'Aggiorna i speculari',
        ],
        'helpers'   => [
            'delete_mirrored'   => 'Elimina anche i legami speculari.',
            'unmirror'          => 'Scollega i legami speculari.',
            'update_mirrored'   => 'Aggiorna i legami speculari.',
        ],
        'success'   => [
            'editing'           => '{0} :count legami sono stati aggiornati|{1} :count legame è stato aggiornato.|[2,*] :count legami sono stati aggiornati.',
            'editing_partial'   => '{0} :count/:total legami sono stati aggiornati|{1} :count/:total legame è stato aggiornato.|[2,*] :count/:total legami sono stati aggiornati.',
        ],
    ],
    'call-to-action'    => 'Esplora visivamente i legami di questa entità e il modo in cui è collegata al resto della campagna.',
    'connections'       => [
        'map_point'         => 'Punto mappa',
        'mention'           => 'Menzione',
        'quest_element'     => 'Elemento di Missione',
        'timeline_element'  => 'Elemento di Linea Temporale',
    ],
    'create'            => [
        'new_title'     => 'Nuovo legame',
        'success_bulk'  => '{1} Aggiunto :count legame a :entity.|[2,*] Aggiunti :count legami a :entity.',
    ],
    'delete_mirrored'   => [
        'helper'    => 'Questo legame è speculare nell\'entità bersaglio. Selezionare questa opzione rimuoverà anche il legame speculare.',
        'option'    => 'Elimina il legame speculare',
    ],
    'destroy'           => [
        'mirrored'  => 'Eliminerai il legame speculare in modo permanente.',
        'success'   => 'Legame :target rimosso per :name.',
    ],
    'fields'            => [
        'attitude'  => 'Attitudine',
        'is_pinned' => 'Fissato',
        'owner'     => 'Fonte',
        'target'    => 'Entità Bersaglio',
        'two_way'   => 'Crea anche il legame speculare',
        'unmirror'  => 'Togli l\'impostazione speculare di questo legame.',
    ],
    'filters'           => [
        'connection'    => 'Relazione del legame',
        'name'          => 'Bersaglio del legame',
    ],
    'helper'            => 'Imposta i legami fra due entità con atteggiamento e visibilità. I legami possono anche essere fissati nel menù dell\'entità.',
    'helpers'           => [
        'no_relations'  => 'Questa entità non ha attualmente nessun legame ad altre entità nella campagna.',
    ],
    'hints'             => [
        'attitude'  => 'Questo campo opzionale può essere utilizzato per definire l\'ordine predefinito di visualizzazione dei legami in ordine decrescente.',
        'two_way'   => 'Se scegli di creare un legame speculare, il medesimo legame sarà creato per l\'entità bersaglio: se ne modificherai uno, tuttavia, l\'altro non verrà aggiornato.',
    ],
    'index'             => [
        'title' => 'Legami',
    ],
    'options'           => [
        'mentions'          => 'Predefinito + correlato + menzioni',
        'only_relations'    => 'Solo legami diretti',
        'related'           => 'Predefinito + correlato',
        'relations'         => 'Predefinito',
        'show'              => 'Mostra',
    ],
    'panels'            => [
        'related'   => 'Correlato',
    ],
    'placeholders'      => [
        'attitude'  => '-100 fino a 100, in cui 100 rappresenta un attitudine molto positiva',
    ],
    'show'              => [
        'title' => 'Legami per :name',
    ],
    'types'             => [
        'family_member'         => 'Membro di Famiglia',
        'organisation_member'   => 'Membro di Organizzazione',
    ],
    'update'            => [
        'success'   => 'Legame :target aggiornato per :name.',
        'title'     => 'Aggiorna i legami per :name',
    ],
];
