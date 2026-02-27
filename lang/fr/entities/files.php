<?php

return [
    'call-to-action'    => [
        'max'       => [
            'helper'    => 'Tu ne peux pas joindre plus de fichiers à moins d\'en supprimer un existant.',
            'limit'     => 'Cette entrée a atteint le nombre maximum de fichiers',
        ],
        'upgrade'   => [
            'limit'     => 'Tu as atteint la limite de :limit fichiers pour cette entrée.',
            'premium'   => 'Passer à une campagne premium pour joindre un nombre illimité de fichiers et bénéficier d\'une flexibilité créative encore plus grande.',
            'upgrade'   => 'Passe à une campagne premium pour pouvoir joindre jusqu\'à :limit fichiers et débloquer encore plus de flexibilité créative.',
        ],
    ],
    'create'            => [
        'helper'            => 'Ajouter un fichier à :name. Le fichier sera pris en compte dans la limite de stockage de la galerie.',
        'success_plural'    => '{1} Fichier :file ajouté.|[2,*] :count fichiers ajoutés.',
        'title'             => 'Nouveau fichier',
    ],
    'destroy'           => [
        'success'   => 'Fichier :file retiré.',
    ],
    'fields'            => [
        'file'  => 'Fichier',
        'files' => 'Fichiers',
        'name'  => 'Nom de fichier',
    ],
    'max'               => [
        'title' => 'Limite atteinte',
    ],
    'update'            => [
        'success'   => 'Fichier :name modifié.',
        'title'     => 'Modifier le fichier',
    ],
];
