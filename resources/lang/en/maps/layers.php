<?php

return [
    'actions'       => [
        'add'   => 'Add a new layer',
    ],
    'base'          => 'Base Layer',
    'create'        => [
        'success'   => 'Layer :name created.',
        'title'     => 'New Layer',
    ],
    'delete'        => [
        'success'   => 'Layer :name deleted.',
    ],
    'edit'          => [
        'success'   => 'Layer :name updated.',
        'title'     => 'Edit Layer :name',
    ],
    'fields'        => [
        'position'  => 'Position',
        'type'      => 'Layer type',
    ],
    'helper'        => [
        'amount'            => 'You can add up to :amount layers on a map to switch the background image displayed below your markers.',
        'boosted_campaign'  => ':boosted can have up to :amount layers.',
    ],
    'placeholders'  => [
        'name'      => 'Underground, Level 2, Shipwreck',
        'position'  => 'Optional field to set the order in which the layers appear.',
    ],
    'short_types'   => [
        'overlay'       => 'Overlay',
        'overlay_shown' => 'Overlay (auto show)',
        'standard'      => 'Standard',
    ],
    'types'         => [
        'overlay'       => 'Overlay (displayed above the active layer)',
        'overlay_shown' => 'Overlay shown by default',
        'standard'      => 'Standard layer (toggle between layers)',
    ],
];
