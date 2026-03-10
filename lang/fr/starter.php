<?php

return [
    'campaign'      => [
        'name'  => 'Monde de :user',
    ],
    'character1'    => [
        'age'           => '[20/30/40 ans]',
        'background'    => [
            'cur'       => 'Actuellement [occupation/rôle]',
            'loc'       => 'A grandi à [ville/région]',
            'seeking'   => 'En quête de [objectif/motivation]',
            'title'     => 'Historique',
        ],
        'description'   => [
            'intro'     => '[Une brève introduction de ton personnage - qui il est, d\'où il vient et ce qu\'il veut.]?',
            'template'  => 'Ceci est un personnage modèle que tu peux personnaliser. Remplace les détails ci-dessous par les informations de ton propre personnage. Tu pourras toujours ajouter d\'autres champs plus tard.',
            'tip'       => 'Conseil: Commence par un nom et une description en une phrase. Tu pourras étoffer les détails au fil du développement de ton monde.',
        ],
        'name'          => '[Nom de ton personnage]',
        'personality'   => [
            'trait1'    => [
                'name'  => 'Trait 1',
                'value' => '[Courageux/Prudent/Ambitieux]',
            ],
            'trait2'    => [
                'name'  => 'Trait 2',
                'value' => '[Loyal/Indépendant/Rusé]',
            ],
            'trait3'    => [
                'name'  => 'Trait 3',
                'value' => '[Optimiste/Cynique/Pragmatique]',
            ],
        ],
        'physical'      => [
            'build'     => [
                'name'  => 'Corpulence',
                'value' => '[Mince/Moyen/Musclé]',
            ],
            'features'  => [
                'name'  => 'Traits distinctifs',
                'value' => '[Cicatrices, tatouages, vêtements distinctifs]',
            ],
        ],
    ],
    'character2'    => [
        'description'   => [
            'first' => 'Un personnage secondaire qui aide ou voyage avec :mention. Personnalise ces détails pour qu\'ils correspondent à ton histoire.',
            'second'=> 'Conseil: Les personnages secondaires n\'ont pas besoin d\'autant de détails que les protagonistes. Concentre-toi sur ce qui les rend utiles ou intéressants pour ton histoire.',
        ],
        'name'          => '[Nom du personnage allié]',
        'relation'      => '[Ami/Mentor/Rival]',
        'skills'        => [
            'first' => '[Compétence 1: Combat/Magie/Soin/Artisanat]',
            'second'=> '[Compétence 2: Social/Savoir/Technique]',
            'third' => '[Compétence 3: Talent unique ou spécialité]',
            'title' => 'Compétences et capacités',
        ],
    ],
    'city'          => [
        'description'   => 'Le cœur battant du royaume, où marchands, nobles et roturiers se côtoient dans des marchés animés et de grandes places. Les vieux murs de la ville tiennent toujours, bien que celle-ci les ait dépassés depuis longtemps.',
        'districts'     => [
            'first' => 'Quartier noble: Manoirs et jardins',
            'fourth'=> 'Quais: Port fluvial, entrepôts',
            'second'=> 'Quartier du marché: Commerce, artisanat, tavernes',
            'third' => 'Vieille ville: Cité fortifiée d\'origine',
            'title' => 'Quartiers',
        ],
        'locations'     => [
            'first' => 'Le Palais Royal (centre du Quartier noble)',
            'second'=> 'Le Grand Bazar (Quartier du marché)',
            'third' => 'L’Auberge de l’Épée Rouillée (lieu populaire des aventuriers)',
            'title' => 'Lieux notables',
        ],
        'name'          => '[Ta capitale]',
        'type'          => 'Capitale',
    ],
    'kingdom'       => [
        'description'   => 'Un royaume prospère, réputé pour ses terres fertiles et ses forêts séculaires. La famille royale règne depuis trois générations, préservant la paix par la diplomatie et le commerce.',
        'features'      => [
            'capital'   => [
                'name'  => 'Capitale',
            ],
            'exp'       => [
                'name'  => 'Export principal',
                'value' => 'Céréales, bois de construction',
            ],
            'gov'       => [
                'name'  => 'Gouvernement',
                'value' => 'Monarchie héréditaire',
            ],
            'pop'       => [
                'name'  => 'Population',
                'value' => '~50,000',
            ],
            'title'     => 'Caractéristiques notables',
        ],
        'name'          => '[Nom de ton royaume]',
        'recent'        => [
            'first' => 'Recrudescence du banditisme sur les routes de l\'est',
            'second'=> 'Mauvaises récoltes dans les provinces du sud',
            'title' => 'Événements récents',
        ],
        'type'          => 'Royaume',
    ],
    'kingdom1'      => [],
    'kingdom2'      => [],
    'name'          => ':name (exemple)',
    'note1'         => [],
];
