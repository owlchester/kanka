<?php

return [
    'description'   => 'Quelques aides disponnibles dans Kanka',
    'dice'          => [
        'description'               => 'Example de jet de dés: "d20", "4d4+4", "d%" pour un pourcent et "df" pour un jet Fudge.',
        'description_attributes'    => 'Il est aussi possible d\'accéder aux paramètres d\'un personnage en utilisant la syntax {character.nom_d_attribut}. Par example, {character.niveau}d6+{character.force}.',
        'more'                      => 'D\'autres options sont expliquées sur le site du plugin.',
        'title'                     => 'Jets de dés',
    ],
    'link'          => [
        'auto_update'   => 'Les liens vers d\'autres entités seront automatiquement mis à jour lorsque le nom ou la description de l\'entitée cible est modifié.',
        'description'   => 'Un lien vers une entité peut être facilement inséré en utilisant \'@\' dans le text. \'#\' peut être utilisé pour avoir une liste de mois depuis les calendriers de la campagne.',
        'title'         => 'Liens vers d\'autres éléments et raccourcis',
    ],
    'public'        => 'Une vidéo sur Youtube explique comment fonctionne les campagnes publiques.',
    'title'         => 'Aides',
];
