<?php

return [
    'actions'       => [
        'accept'    => 'Accepter',
        'reject'    => 'Décliner',
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
    'fields'        => [
        'application'   => 'Application',
        'reason'        => 'Motif d\'approbation / de rejet',
    ],
    'helpers'       => [
        'modal'                 => 'Une campagne qui est ouverte aux candidatures et qui est publique peut avoir des utilisateurs demander de joindre la campagne.',
        'no_applications'       => 'Il n\'y a actuellement aucune candidature en attente pour rejoindre la campagne. Les utilisateurs peuvent demander à rejoindre la campagne en visitant son tableau de bord et en cliquant sur le bouton :bouton.',
        'no_applications_title' => 'Aucune application trouvée',
        'reason'                => 'Si une raison est fournie, le/la demandeur en sera informé.',
        'role'                  => 'En cas d\'approbation, le rôle auquel le candidat est ajouté.',
    ],
    'open'          => [
        'closed'    => 'La campagne est fermée',
        'open'      => 'La campagne est ouverte',
        'title'     => 'Campagne ouverte',
    ],
    'placeholders'  => [
        'note'      => 'Ecris ta candidature pour rejoindre la campagne.',
        'reason'    => 'Ta raison',
    ],
    'public'        => [
        'private'   => 'La campagne est privée',
        'public'    => 'La campagne est publique',
        'title'     => 'Campaign publique',
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
