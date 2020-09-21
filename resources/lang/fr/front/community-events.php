<?php

return [
    'actions'       => [
        'return'        => 'Retour aux événements',
        'send'          => 'Participer',
        'show_ongoing'  => 'Afficher & Participer',
        'show_past'     => 'Afficher les gagnants',
        'update'        => 'Mettre à jour',
        'view'          => 'Voir la participation',
    ],
    'description'   => 'Nous organisations fréquemment des événements de worldbuilding pour notre communauté, et affichons les gagnants.',
    'fields'        => [
        'comment'       => 'Commentaire',
        'entity_link'   => 'Liens vers l\'entité',
        'rank'          => 'Rang',
        'submitter'     => 'Participant',
    ],
    'index'         => [
        'ongoing'   => 'Événements en cours',
        'past'      => 'Événements passés',
    ],
    'participate'   => [
        'description'   => 'Inspiré par cet événement? Créés une entité dans une campagne publique et envois nous le liens vers l\'entité avec le formulaire de participation. Les informations peuvent être changées à tout moment tant que l\'événement n\'est pas clôs.',
        'login'         => 'Connectes-toi à ton compte pour participer.',
        'participated'  => 'Tu as déjà participé à cet événement. Tu peux modifier ou supprimer ta participation.',
        'success'       => [
            'modified'  => 'Les modifications à ta participation ont été enregistrées.',
            'removed'   => 'Ta participation a été retirée.',
            'submit'    => 'Ta participation a été envoyée. Tu peux la modifier ou la supprimer à tout moment.',
        ],
        'title'         => 'Participer à l\'événement',
    ],
    'placeholders'  => [
        'comment'       => 'Commentaire (optionnel)',
        'entity_link'   => 'Copier-coller le liens vers l\'entité ici',
    ],
    'results'       => [
        'description'       => 'Notre jury à sélectionner ces participants comme gagnants.',
        'title'             => 'Gagnants',
        'waiting_results'   => 'L\'événement est fini! Le jury va maintenant délibérer et les gagnants seront bientôt affichés.',
    ],
    'show'          => [
        'participants'  => '{1} :number participant.|[2,*] :number participants.',
        'title'         => 'Événement :name',
    ],
    'title'         => 'Événements',
];
