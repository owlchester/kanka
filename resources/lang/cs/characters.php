<?php

return [
    'actions'       => [
        'add_appearance'    => 'Přidat vzhled',
        'add_organisation'  => 'Přidat organizaci',
        'add_personality'   => 'Přidat povahovou vlastnost',
    ],
    'conversations' => [
        'title' => 'Rozhovory s postavou :name',
    ],
    'create'        => [
        'success'   => 'Postava ":name" vytvořena',
        'title'     => 'Nová postava',
    ],
    'destroy'       => [
        'success'   => 'Postava ":name" odstraněna',
    ],
    'dice_rolls'    => [
        'hint'  => 'Hody kostkami lze pro herní účely přiřadit postavě.',
        'title' => 'Hody kostkami postavy :name',
    ],
    'edit'          => [
        'success'   => 'Postava ":name" aktualizována',
        'title'     => 'Upravit postavu :name',
    ],
    'fields'        => [
        'age'                       => 'Věk',
        'family'                    => 'Rod',
        'image'                     => 'Obrázek',
        'is_dead'                   => 'Po smrti',
        'is_personality_visible'    => 'Povahové vlastnosti viditelné',
        'life'                      => 'Život',
        'location'                  => 'Místo',
        'name'                      => 'Jméno',
        'physical'                  => 'Tělesné rysy',
        'pronouns'                  => 'Zájmena',
        'race'                      => 'Rasa',
        'relation'                  => 'Souvislost',
        'sex'                       => 'Pohlaví',
        'title'                     => 'Titul',
        'traits'                    => 'Rysy',
        'type'                      => 'Typ',
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
    'index'         => [
        'actions'   => [
            'random'    => 'Nová náhodná postava',
        ],
        'add'       => 'Nová postava',
        'header'    => 'Postavy v :name',
        'title'     => 'Postavy',
    ],
    'items'         => [
        'hint'  => 'Předměty přiřazené postavám se zobrazí zde.',
        'title' => 'Předměty postavy :name',
    ],
    'journals'      => [
        'title' => 'Deníky postavy :name',
    ],
    'maps'          => [
        'title' => 'Mapa souvislostí postavy :name',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Přidat organizaci',
        ],
        'create'        => [
            'success'   => 'Postava přidána za člena organizace.',
            'title'     => 'Nová organizace pro :name',
        ],
        'destroy'       => [
            'success'   => 'Členství postavy v organizaci zrušeno',
        ],
        'edit'          => [
            'success'   => 'Členství postavy v organizaci aktualizováno',
            'title'     => 'Upravit členství postavy :name v organizaci',
        ],
        'fields'        => [
            'organisation'  => 'Organizace',
            'role'          => 'Role',
        ],
        'hint'          => 'Postavy mohou být členy více organizací, což ukazuje pro koho postava pracuje nebo do jaké sociální skupiny patří.',
        'placeholders'  => [
            'organisation'  => 'Vybrat organizaci...',
        ],
        'title'         => 'Členství postavy :name v organizacích',
    ],
    'placeholders'  => [
        'age'               => 'Věk',
        'appearance_entry'  => 'Popis',
        'appearance_name'   => 'Vlasy, oči, pleť, výška...',
        'family'            => 'Vyber postavu',
        'image'             => 'Obrázek',
        'location'          => 'Vyber místo',
        'name'              => 'Jméno',
        'personality_entry' => 'Podrobnosti',
        'personality_name'  => 'Cíle, povahové rysy, obavy, slabiny, závazky...',
        'physical'          => 'Tělesné rysy',
        'pronouns'          => 'On, ona, ono',
        'race'              => 'Rasa',
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
        'general'       => 'Všeobecné informace',
        'personality'   => 'Povahové rysy',
    ],
    'show'          => [
        'tabs'  => [
            'map'           => 'Mapa souvislostí',
            'organisations' => 'Organizace',
        ],
        'title' => 'Postava :name',
    ],
    'warnings'      => [
        'personality_hidden'    => 'Nemáš oprávnění upravovat povahové rysy této postavy.',
    ],
];
