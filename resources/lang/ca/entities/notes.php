<?php

return [
    'actions'       => [
        'add'       => 'Nova anotació',
        'add_user'  => 'Afegeix un usuari',
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
        'collapsed' => 'Tanca l\'anotació fixada per defecte',
        'creator'   => 'Creador',
        'entry'     => 'Entrada',
        'is_pinned' => 'Fixada',
        'name'      => 'Nom',
        'position'  => 'Posició fixa',
    ],
    'hint'          => 'Aquí podeu afegir tota aquella informació que no encaixa del tot als camps per defecte de l\'entitat, o que es vol mantenir en privat.',
    'hints'         => [
        'is_pinned' => 'Les anotacions fixades es mostren sota el text de l\'entitat a la vista principal segons l\'ordre de posició fixada.',
    ],
    'index'         => [
        'title' => 'Anotacions de :name',
    ],
    'placeholders'  => [
        'name'  => 'Secrets del màster, observacions, imatges extra, peticions...',
    ],
    'show'          => [
        'advanced'  => 'Permisos avançats',
        'title'     => 'Anotació :name de :entity',
    ],
];
