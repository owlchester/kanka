<?php

return [
    'actions'       => [
        'add'   => 'Ajouter un nouveau groupe',
    ],
    'bulks'         => [
        'delete'    => '{1} Retiré :count groupe.|[2,*] Retiré :count groupes.',
        'patch'     => '{1} Modifié :count groupe.|[2,*] Modifié :count groupes.',
    ],
    'create'        => [
        'helper'    => 'Ajoute un nouveau groupe à :name. Des marqueurs pourront ensuite être attribués à ce groupe.',
        'success'   => 'Groupe :name créé.',
        'title'     => 'Nouveau Groupe',
    ],
    'delete'        => [
        'success'   => 'Groupe :name supprimé.',
    ],
    'edit'          => [
        'success'   => 'Groupe :name modifié.',
        'title'     => 'Modifier le groupe :name',
    ],
    'fields'        => [
        'is_shown'  => 'Afficher les marqueurs du groupe',
        'position'  => 'Position',
    ],
    'helper'        => [
        'amount_v3' => 'Les marqueurs peuvent être groupé ensemble dans des groupes. Chaque groupe peut être activé pour rapidement afficher ou cacher les marqueurs de celui-ci.',
    ],
    'hints'         => [
        'is_shown'  => 'Si sélectionné, les marqueurs du groups seront affichés par défaut.',
    ],
    'index'         => [
        'title' => 'Groupes de :name',
    ],
    'pitch'         => [
        'error'     => 'Nombre maximum de groupes atteint.',
        'max'       => [
            'helper'    => 'Tu ne peux pas ajouter d\'autres groupes à moins d\'en supprimer un existant.',
            'limit'     => 'Cette carte a atteint sa limite de groupes',
        ],
        'until'     => 'Créer jusqu\'à :max groupes pour chaque carte.',
        'upgrade'   => [
            'limit'     => 'Cette carte a atteint sa limite de :limit groupes',
            'upgrade'   => 'Passe à une campagne premium pour ajouter jusqu\'à :limit groupes et débloquer encore plus de flexibilité créative.',
        ],
    ],
    'placeholders'  => [
        'name'          => 'Magasins, trésors, PNJs',
        'position'      => 'Première',
        'position_list' => 'Après :name',
    ],
    'reorder'       => [
        'save'      => 'Enregister l\'ordre',
        'success'   => '{1} Réordonné :count groupe.|[2,*] Réordonné :count groupes.',
        'title'     => 'Réordonner les groupes',
    ],
];
