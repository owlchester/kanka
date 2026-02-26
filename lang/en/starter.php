<?php

return [
    'campaign'      => [
        'name'  => ':user\'s world',
    ],
    'character1'    => [
        'name' => '[Your Character Name]',
        'description' => [
            'template' => 'This is a template character you can customize. Replace the placeholder details below with your own character\'s information. You can always add more fields later.',
            'intro' => '[A brief introduction to your character - who they are, where they\'re from, and what they want.]',
            'tip' => 'Tip: Start with just a name and one-sentence description. You can expand the details as your world develops.'
        ],
        'age' => '[20s/30s/40s]',
        'physical' => [
            'build' => [
                'name' => 'Build',
                'value' => '[Lean/Average/Muscular]',
            ],
            'features' => [
                'name' => 'Notable features',
                'value' => '[Scares, tattoos, distinctive clothing]',
            ],
        ],
        'personality' => [
            'trait1' => [
                'name' => 'Trait 1',
                'value' => '[Brave/Cautious/Ambitious]',
            ],
            'trait2' => [
                'name' => 'Trait 2',
                'value' => '[Loyal/Independant/Cunning]',
            ],
            'trait3' => [
                'name' => 'Trait 3',
                'value' => '[Optimistic/Cynical/Pragmatic]',
            ],
        ],
        'background' => [
            'title' => 'Background',
            'loc' =>'Gew up in [hometown/region]',
            'cur' => 'Currently [occupation/role]',
            'seeking' => 'Seeking [goal/motivation]',
        ]
    ],
    'character2'    => [
        'name' => '[Allied Character Name]',
        'description' => [
            'first' => 'A supporting character who helps or travels with :mention. Customize these details to fit your story.',
            'second' => 'Tip: Supporting characters don\'t need as much detail as protagonists. Focus on what makes them useful or interesting to your story.',
        ],
        'skills' => [
            'title' => 'Skills & Abilities',
            'first' => '[Skill 1: Combat/Magic/Healing/Crafting]',
            'second' => '[Skill 2: Social/Knowledge/Technical]',
            'third' => '[Skill 3: Unique talent or specialty]',
        ],
        'relation' => '[Friend/Mentor/Rival]',
    ],
    'kingdom'      => [
        'name' => '[Your Kingdom Name]',
        'description'   => 'A prosperous realm known for its fertile farmlands and ancient forests. The royal family has ruled for three generations, maintaining peace through diplomacy and trade.',
        'type'          => 'Kingdom',
        'features' => [
            'title' => 'Notable features',
            'capital' => [
                'name' => 'Capital',
            ],
            'pop' => [
                'name' => 'Population',
                'value' => '~50\'000',
            ],
            'exp' => [
                'name' => 'Primary export',
                'value' => 'Grain, timber',
            ],
            'gov' => [
                'name' => 'Government',
                'value' => 'Hereditary monarchy',
            ]
        ],
        'recent' => [
            'title' => 'Recent Events',
            'first' => 'Increased bandit activity on eastern roads',
            'second' => 'Failed harvest in southern provinces',
        ]
    ],
    'city'      => [
        'name' => '[Your Capital City]',
        'description'       => 'The beating heart of the kingdom, where merchants, nobles, and common folk mingle in bustling markets and grand plazas. The old city walls still stand, though the city has long since grown beyond them.',
        'type'          => 'Capital',
        'districts' => [
            'title' => 'Districts',
            'first' => 'Noble Quarter: Manor houses and gardens',
            'second' => 'Market District: Trade, crafts, taverns',
            'third' => 'Old Town: Original walled city',
            'fourth' => 'Dockside: River port, warehouses'
        ],
        'locations' => [
            'title' => 'Notable locations',
            'first' => 'The Royal Palace (center of Noble Quarter)',
            'second' => 'The Grand Bazaar (Market District)',
            'third' => 'The Rusty Sword Inn (popular adventurer hangout)',
        ]
    ],
    'name'          => ':name (example)',
];
