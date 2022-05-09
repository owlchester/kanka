<?php

return [
    'create'        => [
        'success'   => 'Elemento aggiunto alla linea temporale',
        'title'     => 'Nuovo elemento cronologico',
    ],
    'delete'        => [
        'success'   => 'Elemento :element rimosso.',
    ],
    'edit'          => [
        'success'   => 'Elemento aggiornato.',
        'title'     => 'Modifica dell\'elemento cronologico',
    ],
    'fields'        => [
        'date'              => 'Data',
        'era'               => 'Era',
        'icon'              => 'Icona',
        'use_entity_entry'  => 'Visualizza la voce dell\'entità allegata di seguito. Il testo di questo elemento sarà visualizzato per primo se presente.',
    ],
    'helpers'       => [
        'entity_is_private' => 'L\'entità dell\'elemento è privata.',
        'icon'              => 'Copia il codice CSS di un\'icona da :fontawesome o :rpgawesome.',
        'is_collapsed'      => 'L\'immagine dell\'elemento è ridotta a icona per impostazione predefinita.',
    ],
    'placeholders'  => [
        'date'      => 'e.g. 42 Marzo o 1332-1337',
        'name'      => 'Richiesto se nessuna entità è selezionata',
        'position'  => 'Posizione nella lista degli elementi dell\'era. Lasciare vuoto per aggiungere alla fine.',
    ],
];
