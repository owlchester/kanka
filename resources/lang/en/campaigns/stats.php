<?php

return [
    'achievements'  => [
        'calendars' => [
            'goal'  => 'Calendars',
            'title' => 'Time Keeper',
        ],
        'murderer'  => [
            'goal'  => 'Dead characters',
            'title' => 'Murderer',
        ],
    ],
    'helper'        => 'Track your progress to unlocking various achievements for your campaign. These numbers are updated once every 24 hours.',
    'placeholder'   => ':amount of :target',
    'targets'       => [
        'calendars' => 'Create :target calendars',
        'characters'=> 'Create :target characters',
        'dead'      => 'Kill :target characters',
        'families'  => 'Create :target families',
        'locations' => 'Create :target locations',
        'races'     => 'Create :target races',
    ],
    'title'         => 'Campaign :campaign Achievements',
    'titles'        => [
        'calendars' => 'Time Keeper level :level',
        'characters'=> 'Name Giver level :level',
        'dead'      => 'Murderer level :level',
        'families'  => 'Family Planning level :level',
        'locations' => 'Builder level :level',
        'quests'    => 'Mastermind level :level',
        'races'     => 'Breeder level :level',
    ],
];
