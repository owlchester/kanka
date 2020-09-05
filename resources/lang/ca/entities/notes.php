<?php

return [
    'actions'       => [
        'add'   => 'Nova anotació',
    ],
    'create'        => [
        'description'   => 'Crea una nova anotació',
        'success'       => 'S\'ha afegit l\'anotació «:name» a :entity.',
        'title'         => 'Nova anotació a :name',
    ],
    'destroy'       => [
        'success'   => 'S\'ha eliminat l\'anotació «:name» de :entity.',
    ],
    'edit'          => [
        'description'   => 'Actualiza l\'anotació',
        'success'       => 'S\'ha actualitzat l\'anotació «:name» de :entity.',
        'title'         => 'Actualiza l\'anotació de :name',
    ],
    'fields'        => [
        'creator'   => 'Creador',
        'entry'     => 'Entrada',
        'name'      => 'Nom',
    ],
    'hint'          => 'Aquí podeu afegir tota aquella informació que no encaixa del tot als camps per defecte de l\'entitat, o que es vol mantenir en privat.',
    'index'         => [
        'title' => 'Anotacions de :name',
    ],
    'placeholders'  => [
        'name'  => 'Secrets del màster, observacions, imatges extra, peticions...',
    ],
    'show'          => [
        'title' => 'Anotació :name de :entity',
    ],
];
