<?php

return [
    'actions'       => [
        'add'   => 'Ajouter un alias',
    ],
    'create'        => [
        'helper'    => 'Créés un alias pour :name, ce qui permettra de le retrouver dans la recherche globale et dans les mentions :code.',
        'success'   => 'Alias :name ajouté à :entity.',
        'title'     => 'Ajouter un alias à :name.',
    ],
    'destroy'       => [
        'success'   => 'L\'alias :name a été retiré.',
    ],
    'fields'        => [
        'name'  => 'Nom',
    ],
    'helpers'       => [
        'primary'   => 'Définir un ou plusieurs alias sur l\'entrée la rentra trouvable avec la recherche global (tout en haut) et à travers les mentions.',
    ],
    'limit'         => 'Cette campagne a atteint sa limite d\'alias. Pour obtenir un nombre illimité d\'alias, débloques les fonctionnalités premium.',
    'pitch'         => 'Créés des alias vers cette entrée pour facilement la trouver dans la recherche et les mentions.',
    'placeholders'  => [
        'name'  => 'Nouvel alias',
    ],
    'unboosted'     => [],
    'update'        => [
        'success'   => 'Alias :name modifié pour :entity.',
        'title'     => 'Modifier l\'alias pour :name',
    ],
];
