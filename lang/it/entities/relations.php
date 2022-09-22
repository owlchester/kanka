<?php

return [
    'create'        => [
        'success'   => 'Relazione :target aggiunta per :name.',
        'title'     => 'Nuova relazione per :name',
    ],
    'destroy'       => [
        'success'   => 'Relazione :target rimossa per :name.',
    ],
    'fields'        => [
        'attitude'  => 'Atteggiamento',
        'is_star'   => 'Fissata',
        'relation'  => 'Relazione',
        'target'    => 'Bersaglio',
        'two_way'   => 'Crea anche la relazione speculare',
    ],
    'helper'        => 'Imposta le relazioni fra due entità con atteggiamento e visibilità. Le relazioni possono anche essere fissate nel menù dell\'entità.',
    'hints'         => [
        'attitude'  => 'Questo campo opzionale può essere utilizzato per definire l\'ordine predefinito di visualizzazione delle relazioni in ordine decrescente.',
        'mirrored'  => [
            'text'  => 'Questa relazione è speculare con :link.',
            'title' => 'Speculare',
        ],
        'two_way'   => 'Se Scegli di creare una relazione speculare, la medesima relazione sarà creata per il bersaglio: se ne modificherai una, tuttavia, l\'altra non verrà aggiornata.',
    ],
    'placeholders'  => [
        'attitude'  => 'Da -100 a 100, con 100 che indica un atteggiamento decisamente positivo.',
        'relation'  => 'Rivale, Migliore Amico, Fratello/Sorella',
        'target'    => 'Seleziona un\'entità',
    ],
    'show'          => [
        'title' => 'Relazioni per :name',
    ],
    'update'        => [
        'success'   => 'Relazione :target aggiornata per :name.',
        'title'     => 'Aggiorna le relazioni per :name',
    ],
];
