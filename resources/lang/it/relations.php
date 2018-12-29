<?php

return [
    'create'        => [
        'description'   => 'Crea una nuova relazione',
        'success'       => 'Relazione aggiunta per :name.',
        'title'         => 'Crea le relazioni',
    ],
    'destroy'       => [
        'success'   => 'Relazione rimossa per :name.',
    ],
    'edit'          => [
        'success'   => 'Relazione aggiornata per :name.',
        'title'     => 'Aggiorna le relazioni',
    ],
    'fields'        => [
        'relation'  => 'Relazione',
        'target'    => 'Bersaglio',
        'two_way'   => 'Crea anche la relazione speculare',
    ],
    'hints'         => [
        'two_way'   => 'Se selezione la creazione della relazione speculare la stessa relazione sarà creata per il bersaglio. Però, se ne modificherai una, quella speculare non verrà aggiornata.',
    ],
    'placeholders'  => [
        'relation'  => 'Natura della relazione',
        'target'    => 'Seleziona un\'entità',
    ],
];
