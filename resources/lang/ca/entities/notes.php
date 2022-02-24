<?php

return [
    'actions'       => [
        'add'       => 'Nova anotació',
        'add_role'  => 'Afegeix un rol',
        'add_user'  => 'Afegeix un usuari',
    ],
    'create'        => [
        'success'   => 'S\'ha afegit l\'anotació «:name» a :entity.',
        'title'     => 'Nova anotació a :name',
    ],
    'destroy'       => [
        'success'   => 'S\'ha eliminat l\'anotació «:name» de :entity.',
    ],
    'edit'          => [
        'success'   => 'S\'ha actualitzat l\'anotació «:name» de :entity.',
        'title'     => 'Actualiza l\'anotació de :name',
    ],
    'fields'        => [
        'collapsed' => 'Tanca l\'anotació fixada per defecte',
        'creator'   => 'Creador',
        'entry'     => 'Entrada',
        'name'      => 'Nom',
    ],
    'footer'        => [
        'created'   => 'Creada per :user el :date',
        'updated'   => 'Actualitzada per :user el :date',
    ],
    'hint'          => 'Aquí podeu afegir tota aquella informació que no encaixa del tot als camps per defecte de l\'entitat, o que es vol mantenir en privat.',
    'hints'         => [
        'reorder'   => 'Podeu reordenar les anotacions d\'una entitat fent-ne clic a l\'icona de :icon a la capçalera.',
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
