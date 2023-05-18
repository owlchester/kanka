<?php

return [
    'actions'       => [
        'add_appearance'    => 'Přidat vzhled',
        'add_personality'   => 'Přidat povahovou vlastnost',
    ],
    'conversations' => [],
    'create'        => [
        'title' => 'Nová postava',
    ],
    'destroy'       => [],
    'dice_rolls'    => [],
    'edit'          => [],
    'fields'        => [
        'age'                       => 'Věk',
        'is_dead'                   => 'Po smrti',
        'is_personality_visible'    => 'Povahové vlastnosti viditelné',
        'life'                      => 'Život',
        'physical'                  => 'Tělesné rysy',
        'pronouns'                  => 'Zájmena',
        'sex'                       => 'Pohlaví',
        'title'                     => 'Titul',
        'traits'                    => 'Rysy',
    ],
    'helpers'       => [
        'age'   => 'Tento objekt lze propojit s kalendářem tažení. Věk se pak bude počítat automaticky. :more',
    ],
    'hints'         => [
        'is_dead'                   => 'Tato postava je mrtvá.',
        'is_personality_visible'    => 'Celou sekci s popisem osobnosti lze skrýt před uživateli, kteří nejsou členy role správců.',
        'personality_not_visible'   => 'Sekci s popisem osobnosti postavy si nyní mohou zobrazit pouze členové role správců.',
        'personality_visible'       => 'Sekce s popisem osobnosti postavy je nyní dostupná všem uživatelům.',
    ],
    'index'         => [],
    'items'         => [],
    'journals'      => [],
    'maps'          => [],
    'organisations' => [
        'create'    => [
            'success'   => 'Postava přidána za člena organizace.',
            'title'     => 'Nová organizace pro :name',
        ],
        'destroy'   => [
            'success'   => 'Členství postavy v organizaci zrušeno',
        ],
        'edit'      => [
            'success'   => 'Členství postavy v organizaci aktualizováno',
            'title'     => 'Upravit členství postavy :name v organizaci',
        ],
        'fields'    => [
            'role'  => 'Role',
        ],
    ],
    'placeholders'  => [
        'age'               => 'Věk',
        'appearance_entry'  => 'Popis',
        'appearance_name'   => 'Vlasy, oči, pleť, výška...',
        'personality_entry' => 'Podrobnosti',
        'personality_name'  => 'Cíle, povahové rysy, obavy, slabiny, závazky...',
        'physical'          => 'Tělesné rysy',
        'pronouns'          => 'On, ona, ono',
        'sex'               => 'Pohlaví',
        'title'             => 'Titul',
        'traits'            => 'Rysy',
        'type'              => 'NPC, hráčská postava, božstvo...',
    ],
    'quests'        => [
        'helpers'   => [
            'quest_giver'   => 'Dobrodružství, jejichž zadavatelem je tato postava.',
            'quest_member'  => 'Dobrodružství, jichž je postava členem.',
        ],
    ],
    'sections'      => [
        'appearance'    => 'Vzhled',
        'personality'   => 'Povahové rysy',
    ],
    'show'          => [],
    'warnings'      => [
        'personality_hidden'    => 'Nemáš oprávnění upravovat povahové rysy této postavy.',
    ],
];
