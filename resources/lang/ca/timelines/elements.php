<?php

return [
    'create'        => [
        'success'   => 'S\'ha afegit l\'element a la línia de temps.',
        'title'     => 'Nou element cronològic',
    ],
    'delete'        => [
        'success'   => 'S\'ha eliminat l\'element «:name».',
    ],
    'edit'          => [
        'success'   => 'S\'ha actualitzat l\'element.',
        'title'     => 'Edita l\'element cronològic',
    ],
    'fields'        => [
        'date'              => 'Data',
        'era'               => 'Era',
        'icon'              => 'Icona',
        'use_entity_entry'  => 'Mostra l\'entrada de l\'entitat vinculada. Si hi ha text en aquest element, es mostrarà abans.',
    ],
    'helpers'       => [
        'entity_is_private' => 'L\'entitat de l\'element és privada.',
        'icon'              => 'Copia l\'HTML d\'una icona de :fontawesome o :rpgawesome.',
        'is_collapsed'      => 'L\'element es mostra col·lapsat per defecte.',
    ],
    'placeholders'  => [
        'date'      => '22 de març, 1332-1337...',
        'name'      => 'Requerit si no hi ha cap entitat seleccionada',
        'position'  => 'Posició a la llista d\'elements de l\'era. Deixeu-ho en blanc per a afegir-lo al final.',
    ],
];
