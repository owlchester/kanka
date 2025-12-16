<?php

return [
    'actions'   => [
        'add'   => 'Ajouter',
        'reset' => 'Réinitialiser les charges',
        'sync'  => 'Ajouter depuis les races',
    ],
    'charges'   => [
        'left'  => ':amount restant',
    ],
    'create'    => [
        'helper'            => 'Ajouter un ou plusieurs pouvoirs à :name.',
        'success'           => 'Pouvoir :ability ajouté à :entity.',
        'success_multiple'  => 'Les pouvoirs :abilities ont été ajouté à :entity.',
        'title'             => 'Ajouter des pouvoirs',
    ],
    'fields'    => [
        'note'      => 'Note',
        'position'  => 'Position',
    ],
    'groups'    => [
        'unorganised'   => 'Inorganisé',
    ],
    'helpers'   => [
        'note'      => 'Ce champ peut référencer des entités en utilisant les mentions avancées (ex :code) et les attributs d\'une entité (ex :attr).',
        'recharge'  => 'Réinitialiser toutes les charges des pouvoirs qui ont été utilisées.',
        'sync'      => 'Importer les pouvoirs définis sur les races du personnage.',
    ],
    'import'    => [
        'errors'            => [
            'no_race'       => 'Ce personnage n\'as pas de race.',
            'not_character' => 'Cette entité n\'est pas un personnage.',
        ],
        'helper'            => 'Attacher des pouvoir des races auxquelles :name appartient:',
        'no_abilities'      => 'Actuellement, il n\'existe aucune possibilité d\'importer des pouvoirs provenant des races auxquelles :name appartient.',
        'race_abilities'    => '{1} :name (:count pouvoir)|[2,*] :name (:count pouvoirs)',
        'success'           => '{1} :count pouvoir ajouté.|[2,*] :count pouvoirs ajoutés.',
    ],
    'recharge'  => [
        'success'   => 'Toutes les charges ont été réinitialisées.',
    ],
    'reorder'   => [
        'parentless'    => 'Aucun parent',
        'success'       => 'Pouvoirs réordonnés.',
    ],
    'show'      => [
        'helper'    => 'Attache des pouvoirs à cette entité. Il est toujours possible de modifier ou de supprimer un pouvoir. Les pouvoirs qui appartiennent au même parent sont groupés ensemble et agissent comme filtres.',
        'reorder'   => 'Réordonner',
        'title'     => 'Pouvoirs de:name',
    ],
    'types'     => [
        'unorganised'   => 'Les pouvoirs sont regroupés en fonction de leur parent, ou se retrouvent ici.',
    ],
    'update'    => [
        'success'   => 'Pouvoir d\'entité :ability mis à jour.',
        'title'     => 'Pouvoirs de :name',
    ],
];
