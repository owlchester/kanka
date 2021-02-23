<?php

return [
    'actions'       => [
        'accept'    => 'Accepter',
        'reject'    => 'Décliner',
    ],
    'apply'         => [
        'apply'         => 'Appliquer',
        'help'          => 'Cette campagne est ouverte à de nouveaux membre. Postules pour la rejoindre en remplissant ce formulaire. Une notification sera envoyée lorsque les administrateurs de la campagne examine ton application.',
        'remove_text'   => 'ton application',
        'success'       => [
            'apply' => 'Ton application a été enregistrée. Tu peux la modifier ou l\'annuler à tout moment. Une notification sera envoyée lorsque les administrateurs de la campagne l\'examine.',
            'remove'=> 'Ton application a été retirée.',
            'update'=> 'Ton application a été modifiée. Tu peux toujours la modifier ou l\'annuler à tout moment. Une notification sera envoyée lorsque les administrateurs de la campagne l\'examine.',
        ],
        'title'         => 'Rejoindre :name',
    ],
    'errors'        => [
        'not_open'  => 'La campagne n\'est pas ouverte à de nouveaux membres. Modifier la configuration de la campagne pour permettre aux utilisateurs de postuler.',
    ],
    'fields'        => [
        'application'   => 'Application',
        'rejection'     => 'Raison du rejet',
    ],
    'helpers'       => [
        'open_and_public'   => 'La campagne est ouverte aux applications. Pour arrêter, modifier les paramètres de la campagne sous l\'onglet :tab.',
    ],
    'placeholders'  => [
        'note'  => 'Ecris ta candidature pour rejoindre la campagne.',
    ],
    'title'         => 'Applications de la campagne',
    'update'        => [
        'approve'   => 'Sélectionner le rôle auquel l\'utilisateur sera ajouté à la campagne.',
        'approved'  => 'Application approvée.',
        'reject'    => 'Ecrire une raison optionnelle pourquoi la candidature est rejetée.',
        'rejected'  => 'Application déclinée.',
    ],
];
