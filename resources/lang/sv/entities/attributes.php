<?php

return [
    'actions'       => [
        'apply_template'    => 'Tillämpa en Egenskapsmall',
        'manage'            => 'Hantera',
        'more'              => 'Fler alternativ',
        'remove_all'        => 'Ta bort allt',
    ],
    'fields'        => [
        'attribute'             => 'Egenskap',
        'community_templates'   => 'Community Mallar',
        'is_private'            => 'Privata Egenskaper',
        'is_star'               => 'Fastnålad',
        'template'              => 'Mall',
        'value'                 => 'Värde',
    ],
    'helpers'       => [
        'delete_all'    => 'Är du säker på att du vill ta bort alla egenskaper från den här entiteten?',
    ],
    'hints'         => [
        'is_private'    => 'Du kan dölja alla egenskaper för en entitet för alla medlemmar utom de i admin rollen genom att göra den privat.',
    ],
    'index'         => [
        'success'   => 'Egenskaper för :entity uppdaterade.',
        'title'     => 'Egenskaper för :name',
    ],
    'placeholders'  => [
        'attribute' => 'Antal erövringar, Challenge Rating, Initiativ, Folkmängd',
        'block'     => 'Blocknamn',
        'checkbox'  => 'Kryssrutenamn',
        'section'   => 'Sektionsnamn',
        'template'  => 'Välj en mall',
        'value'     => 'Värde för egenskapen',
    ],
    'template'      => [
        'success'   => 'Egenskapsmall :name tillämpad på :entity',
        'title'     => 'Tillämpa en Egenskapsmall för :name',
    ],
    'types'         => [
        'attribute' => 'Egenskap',
        'block'     => 'Block',
        'checkbox'  => 'Kryssruta',
        'section'   => 'Sektion',
        'text'      => 'Flerrads Text',
    ],
    'visibility'    => [
        'entry'     => 'Egenskap visas på entitets menyn.',
        'private'   => 'Egenskap bara synlig för medlemmar med "Admin" rollen.',
        'public'    => 'Egenskap synlig för alla medlemmar.',
        'tab'       => 'Egenskap visas bara under Egenskaps fliken.',
    ],
];
