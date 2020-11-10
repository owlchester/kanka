<?php

return [
    'achievements' => [
      'murderer' => [
          'title' => 'Murderer',
          'goal' => 'Dead characters'
      ],
      'calendars' => [
          'title' => 'Time Keeper',
          'goal' => 'Calendars'
      ],
    ],
    'helper' => 'Track your progress to unlocking various achievements for your campaign. These numbers are updated once every 24 hours.',
    'placeholder' => ':amount of :target',
    'title' => 'Campaign :campaign Achievements',

    'titles' => [
        'characters' => 'Name Giver level :level',
        'locations' => 'Builder level :level',
        'quests' => 'Mastermind level :level',
        'calendars' => 'Time Keeper level :level',
        'dead' => 'Murderer level :level',
        'families' => 'Family Planning level :level',
        'races' => 'Breeder level :level',
    ],

    'targets' => [
        'characters' => 'Create :target characters',
        'locations' => 'Create :target locations',
        'dead' => 'Kill :target characters',
        'calendars' => 'Create :target calendars',
        'families' => 'Create :target families',
        'races' => 'Create :target races',
    ],
];
