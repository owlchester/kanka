<?php

return [
    'select_reason' => 'Please select a reason to continue.',
    'intro'         => 'Thanks for being a subscriber! Your subscription will remain active until :date, after which your premium campaigns will revert to standard and these benefits will be disabled.',
    'loss'  => [
        'ads'       => [
            'title' => 'Ad-free experience for you and your players',
        ],
        'discord'   => [
            'title' => '":role" role in our Discord community',
        ],
        'downgrade' => 'You can downgrade your subscription instead of cancelling it to keep most of your awesome benefits.',
        'premium'   => [
            'players'   => '{1}:count player will lose access to premium features|[2,*]:count players will lose access to premium features',
            'plugins'   => '{1}Access to :count installed plugin|[2,*]Access to :count installed plugin',
            'storage'   => 'Your :current',
            'title'     => '{0}Premium status on ":campaign"|{1}Premium status on ":campaign" and :count other campaign|[2,*]Premium status on ":campaign" and :count other campaigns',
        ],
        'roadmap'   => 'Check the :roadmap, it might already be planned.',
        'title'     => 'Before you cancel, here\'s what will change:',
    ],
    'pause'     => [
        'button'    => 'Pause subscription for 1-3 months',
        'helper'    => 'Keep everything. No charges. Resume anytime.',
    ],
    'secondary' => [
        'label' => 'Can you tell us a bit more?',
        'financial' => [
            'lower_price' => 'A lower price would help',
            'not_often'   => "I just don't use it often enough to justify the cost",
            'forgot'      => 'I forgot I was still subscribed',
        ],
        'not_for'   => [
            'expected_different' => 'I expected something different',
            'terminology'        => "The terminology doesn't match how I think",
            'too_complex'        => 'Too complex to get started',
            'better_fit'         => 'I found a better fit elsewhere',
        ],
        'not_using' => [
            'on_break'        => 'My campaign is on a break but I may return',
            'too_busy'        => "I've been too busy lately",
            'lost_motivation' => 'I lost motivation for the project',
        ],
        'not_playing' => [
            'campaign_finished' => 'The campaign finished',
            'group_fell_apart'  => 'Group fell apart',
            'on_break'          => 'Taking a break, may return',
        ],
        'competitor' => [
            'world_anvil'    => 'World Anvil',
            'legend_keeper'  => 'Legend Keeper',
            'notion_obsidian' => 'Notion or Obsidian',
            'other'          => 'Something else',
        ],
    ],
    'custom' => [
        'label' => 'Anything else you\'d like to share?',
        'placeholder' => 'We read every response.',
    ],
];
