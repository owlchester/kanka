<?php

return [
    'actions'       => [
        'accept'        => 'Accepter',
        'applications'  => 'Candidatures: :status',
        'change'        => 'Modifier',
        'reject'        => 'Décliner',
    ],
    'apply'         => [
        'apply'         => 'Appliquer',
        'help'          => 'Cette campagne est ouverte à de nouveaux membre. Postules pour la rejoindre en remplissant ce formulaire. Une notification sera envoyée lorsque les administrateurs de la campagne examine ta candidature.',
        'remove_text'   => 'ta candidature',
        'success'       => [
            'apply' => 'Ta candidature a été enregistrée. Tu peux la modifier ou l\'annuler à tout moment. Une notification sera envoyée lorsque les administrateurs de la campagne l\'examine.',
            'remove'=> 'Ta candidature a été retirée.',
            'update'=> 'Ta candidature a été modifiée. Tu peux toujours la modifier ou l\'annuler à tout moment. Une notification sera envoyée lorsque les administrateurs de la campagne l\'examine.',
        ],
        'title'         => 'Rejoindre :name',
    ],
    'errors'        => [
        'not_open'  => 'La campagne n\'est pas ouverte à de nouveaux membres. Modifier la configuration de la campagne pour permettre aux utilisateurs de postuler.',
    ],
    'fields'        => [
        'application'   => 'Application',
        'approval'      => 'Raison d\'approbation',
        'rejection'     => 'Raison du rejet',
    ],
    'helpers'       => [
        'filter-helper'     => 'Cette campagne est ouverte aux candidatures!',
        'modal'             => 'Une campagne qui est ouverte aux candidatures et qui est publique peut avoir des utilisateurs demander de joindre la campagne.',
        'no_applications'   => 'Il n\'y a actuellement aucune candidature en attente pour rejoindre la campagne. Les utilisateurs peuvent demander à rejoindre la campagne en visitant son tableau de bord et en cliquant sur le bouton :bouton.',
        'not_open'          => 'La campagne n\'accepte pas les candidatures pour le moment.',
        'open_not_public'   => 'La campagne est ouverte aux candidatures, mais pas publique, ce qui signifie que personne ne peut postuler pour la rejoindre. Cela peut être modifié en modifiant les paramètres de la campagne.',
    ],
    'placeholders'  => [
        'note'  => 'Ecris ta candidature pour rejoindre la campagne.',
    ],
    'statuses'      => [
        'closed'    => 'Fermé',
        'open'      => 'Ouvert',
    ],
    'toggle'        => [
        'closed'    => 'Fermé aux candidatures',
        'label'     => 'Status',
        'open'      => 'Ouvert aux candidatures',
        'success'   => 'Le status de candidature de la campagne a été modifié.',
        'title'     => 'Status des candidatures',
    ],
    'update'        => [
        'approve'   => 'Sélectionner le rôle auquel l\'utilisateur sera ajouté à la campagne.',
        'approved'  => 'Candidatures approuvée.',
        'reject'    => 'Ecrire une raison optionnelle pourquoi la candidature est rejetée.',
        'rejected'  => 'Candidature déclinée.',
    ],
];
