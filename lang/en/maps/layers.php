<?php

return [
    'actions'       => [
        'add'   => 'Add a new layer',
    ],
    'base'          => 'Base Layer',
    'bulks'         => [
        'delete'    => '{1} Removed :count layer.|[2,*] Removed :count layers.',
        'patch'     => '{1} Updated :count layer.|[2,*] Updated :count layers.',
    ],
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
        'amount_v2' => 'Upload layers to a map to switch the background image displayed below the markers, or as overlays above the map but beneath the markers.',
        'is_real'   => 'Layers aren\'t available when using OpenStreetMaps.',
    ],
    'index'         => [
        'title' => 'Layers of :name',
    ],
    'pitch' => [
        'max' => [
            'limit' => 'This map has reached its layer limit',
            'helper' => 'You can\'t add any more layers unless you remove an existing one.',
        ],
        'upgrade'   => [
            'limit' => 'You\'ve reached the limit of :limit layers for this map',
            'upgrade' => 'Upgrade to a premium campaign to add up to :limit layers and unlock even more creative flexibility.',
        ],
    ],
    'placeholders'  => [
        'name'          => 'Underground, Level 2, Shipwreck',
        'position'      => 'First',
        'position_list' => 'After :name',
    ],
    'reorder'       => [
        'save'      => 'Save new order',
        'success'   => '{1} Reordered :count layer.|[2,*] Reordered :count layers.',
        'title'     => 'Reorder layers',
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
