<?php

return [
    'campaign'      => [
        'name'  => ':user\'s world',
    ],
    'character1'    => [
        'age'           => '[20s/30s/40s]',
        'background'    => [
            'cur'       => 'Currently [occupation/role]',
            'loc'       => 'Gew up in [hometown/region]',
            'seeking'   => 'Seeking [goal/motivation]',
            'title'     => 'Background',
        ],
        'description'   => [
            'intro'     => '[A brief introduction to your character - who they are, where they\'re from, and what they want.]',
            'template'  => 'This is a template character you can customize. Replace the placeholder details below with your own character\'s information. You can always add more fields later.',
            'tip'       => 'Tip: Start with just a name and one-sentence description. You can expand the details as your world develops.',
        ],
        'name'          => '[Your Character Name]',
        'personality'   => [
            'trait1'    => [
                'name'  => 'Trait 1',
                'value' => '[Brave/Cautious/Ambitious]',
            ],
            'trait2'    => [
                'name'  => 'Trait 2',
                'value' => '[Loyal/Independant/Cunning]',
            ],
            'trait3'    => [
                'name'  => 'Trait 3',
                'value' => '[Optimistic/Cynical/Pragmatic]',
            ],
        ],
        'physical'      => [
            'build'     => [
                'name'  => 'Build',
                'value' => '[Lean/Average/Muscular]',
            ],
            'features'  => [
                'name'  => 'Notable features',
                'value' => '[Scares, tattoos, distinctive clothing]',
            ],
        ],
    ],
    'character2'    => [
        'description'   => [
            'first' => 'A supporting character who helps or travels with :mention. Customize these details to fit your story.',
            'second'=> 'Tip: Supporting characters don\'t need as much detail as protagonists. Focus on what makes them useful or interesting to your story.',
        ],
        'name'          => '[Allied Character Name]',
        'relation'      => '[Friend/Mentor/Rival]',
        'skills'        => [
            'first' => '[Skill 1: Combat/Magic/Healing/Crafting]',
            'second'=> '[Skill 2: Social/Knowledge/Technical]',
            'third' => '[Skill 3: Unique talent or specialty]',
            'title' => 'Skills & Abilities',
        ],
    ],
    'city'          => [
        'description'   => 'The beating heart of the kingdom, where merchants, nobles, and common folk mingle in bustling markets and grand plazas. The old city walls still stand, though the city has long since grown beyond them.',
        'districts'     => [
            'first' => 'Noble Quarter: Manor houses and gardens',
            'fourth'=> 'Dockside: River port, warehouses',
            'second'=> 'Market District: Trade, crafts, taverns',
            'third' => 'Old Town: Original walled city',
            'title' => 'Districts',
        ],
        'locations'     => [
            'first' => 'The Royal Palace (center of Noble Quarter)',
            'second'=> 'The Grand Bazaar (Market District)',
            'third' => 'The Rusty Sword Inn (popular adventurer hangout)',
            'title' => 'Notable locations',
        ],
        'name'          => '[Your Capital City]',
        'type'          => 'Capital',
    ],
    'kingdom'       => [
        'description'   => 'A prosperous realm known for its fertile farmlands and ancient forests. The royal family has ruled for three generations, maintaining peace through diplomacy and trade.',
        'features'      => [
            'capital'   => [
                'name'  => 'Capital',
            ],
            'exp'       => [
                'name'  => 'Primary export',
                'value' => 'Grain, timber',
            ],
            'gov'       => [
                'name'  => 'Government',
                'value' => 'Hereditary monarchy',
            ],
            'pop'       => [
                'name'  => 'Population',
                'value' => '~50\'000',
            ],
            'title'     => 'Notable features',
        ],
        'name'          => '[Your Kingdom Name]',
        'recent'        => [
            'first' => 'Increased bandit activity on eastern roads',
            'second'=> 'Failed harvest in southern provinces',
            'title' => 'Recent Events',
        ],
        'type'          => 'Kingdom',
    ],
    'name'          => ':name (example)',
];
