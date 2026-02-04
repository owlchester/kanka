<?php

return [
    'applied'       => [
        'actions'       => [
            'retract'   => 'Retirer la candidature',
        ],
        'description'   => 'Ta candidature a été envoyée et est en cours d’examen. Tu recevras une notification lorsqu’elle sera approuvée ou refusée.',
        'title'         => 'Candidature envoyée',
    ],
    'apply'         => [
        'errors'    => [
            'empty' => 'La question :field nécessite plus de contenu',
        ],
    ],
    'approved'      => [
        'description'   => 'Félicitations! Ta candidature a été approuvée et est maintenant mise en avant sur la page :spotlight.',
        'title'         => 'Candidature approuvée',
    ],
    'faq'           => [
        'finisher'  => 'Envoyer une candidature ne garantit pas la sélection. Nous lisons chaque candidature, mais ne pouvons pas toutes les mettre en avant.',
        'how'       => [
            'a' => [
                'end'           => 'Pas le nombre d’abonnés. Pas la popularité. Pas le statut de membre',
                'lead'          => 'Nous sélectionnons 1–3 campagnes par mois.',
                'req1'          => 'Une identité et des thèmes clairs',
                'req2'          => 'Un worldbuilding réfléchi',
                'req3'          => 'Des histoires ou des approches intéressantes',
                'requirements'  => 'La sélection est éditoriale, pas compétitive. Nous recherchons:',
            ],
            'q' => 'Comment les campagnes sont-elles sélectionnées?',
        ],
        'reapply'   => [
            'a' => 'Oui. Si ta campagne n’est pas sélectionnée, tu peux postuler à nouveau plus tard, surtout si ton monde a évolué.',
            'q' => 'Puis-je postuler plus d’une fois?',
        ],
        'selected'  => [
            'a' => [
                'end'   => 'Tu seras averti avant la publication.',
                'lead'  => 'Si elle est sélectionnée:',
                'req1'  => 'Ta campagne reçoit le succès Campagne mise en avant',
                'req2'  => 'Nous publions un article sur le :blog et le :showcase',
                'req3'  => 'Nous pouvons légèrement modifier tes réponses pour plus de clarté',
            ],
            'q' => 'Que se passe-t-il si ma campagne est sélectionnée?',
        ],
        'what'      => [
            'a' => 'La vitrine met en avant des campagnes exceptionnelles créées avec Kanka. Les campagnes sélectionnées sont présentées sur la Vitrine Kanka et dans un court article de blog sous forme d’interview.',
            'q' => 'Qu’est-ce que la vitrine?',
        ],
        'who'       => [
            'a' => [
                'end'           => 'Aucune taille minimale. Aucune restriction de système.',
                'lead'          => 'Toute campagne publique sur Kanka peut postuler',
                'req1'          => 'Être accessible publiquement',
                'req2'          => 'Montrer une utilisation active (contenu, historique ou joueurs)',
                'req3'          => 'Représenter des mondes dont les autres peuvent s’inspirer',
                'requirements'  => 'Ta campagne doit:',
            ],
            'q' => 'Qui peut postuler?',
        ],
    ],
    'form'          => [
        'actions'       => [
            'apply'     => 'Envoyer la candidature',
            'retract'   => 'Retirer la candidature',
            'save'      => 'Enregistrer le brouillon',
        ],
        'draft'         => 'Ceci est un brouillon de ta candidature. Tu peux l’enregistrer et y revenir plus tard.',
        'not-public'    => 'Cette campagne n’est pas visible publiquement et ne peut pas postuler au Spotlight.',
        'preset'        => 'Parle-nous un peu de :campaign et explique pourquoi tu penses qu’elle mérite d’être mise en avant. Tu peux enregistrer et revenir à ces questions plus tard.',
        'required'      => 'Ce champ est obligatoire.',
        'title'         => 'Formulaire de candidature au Spotlight',
    ],
    'overview'      => [
        'cta'           => 'Postuler au Spotlight avec :name',
        'not-public'    => ':name n’est pas une campagne visible publiquement.',
        'showcase'      => 'Voir la vitrine',
    ],
    'placeholders'  => [
        'inspiration'   => 'Livres, jeux, histoire, musique, ambiance',
        'kanka'         => 'Explique-nous pourquoi Kanka est devenu l’outil idéal pour ton monde',
        'proud'         => 'Ça peut être le lore, les joueurs, la longévité, le statut',
        'stories'       => 'Tragédie, héroïsme, politique, famille choisie, chaos total et assumé',
        'time'          => 'Des mois, des années, des décennies, sur plusieurs vies?',
        'world'         => 'Thèmes, émotions, conflits (l’accroche)',
    ],
    'questions'     => [
        'inspiration'   => 'Qu’est-ce qui inspire ce monde',
        'kanka'         => 'Pourquoi fais-tu jouer des parties sur Kanka?',
        'proud'         => 'De quoi es-tu le plus fier?',
        'share'         => 'Autoriser l’équipe Kanka à utiliser ta réponse dans ses supports marketing.',
        'stories'       => 'Quel genre d’histoires émergent à la table?',
        'time'          => 'Depuis combien de temps construis-tu ce monde?',
        'world'         => 'De quoi parle vraiment ce monde?',
    ],
    'rejected'      => [
        'description'   => 'Ta candidature a été refusée. Réessaie plus tard.',
        'title'         => 'Candidature refusée',
    ],
    'retract'       => [
        'success'   => 'Ta candidature a été retirée avec succès. Tu peux maintenant la modifier à nouveau.',
    ],
    'rules'         => <<<'TEXT'
Nous sélectionnons 1–3 campagnes chaque mois pour les mettre en avant sur le :showcase de Kanka.
La sélection n’est pas garantie. Les campagnes mises en avant reçoivent un succès permanent et une interview publiée.
TEXT
,
    'started'       => 'Pour commencer, sélectionne l’une de tes campagnes.',
    'title'         => 'Postuler au Spotlight',
];
