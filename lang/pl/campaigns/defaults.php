<?php

return [
    'fields'    => [
        'character_personality_visibility'  => 'Domyślna widoczność osobowości postaci',
        'connections'                       => 'Widok powiązań',
        'connections_mode'                  => 'Styl mapy powiązań',
        'descendants'                       => 'Domyślne filtrowanie list',
        'entity_privacy'                    => 'Widoczność nowych elementów',
        'gallery_visibility'                => 'Widoczność domyślnych grafik w galerii',
        'post_collapsed'                    => 'Domyślne wyświetlanie komentarzy',
        'private_mention_visibility'        => 'Wzmiankowanie elementów tajnych',
        'related_visibility'                => 'Widoczność treści zależnych',
    ],
    'helpers'   => [
        'character_visibility'          => 'Określa widoczność cech osobowości nowo stworzonych postaci.',
        'connections'                   => 'Określa, czy powiązania elementu wyświetlane są domyślnie w formie mapy, czy listy.',
        'connections_mode'              => 'Określa domyślny styl mapy powiązań (w kampaniach premium).',
        'descendants'                   => 'Określa, czy na listach zagnieżdżonych (na przykład postaci w danym miejscu) wyświetlane są tylko elementy pochodne bezpośrednio, czy wszystkie pochodne.',
        'display'                       => 'Określa domyślne wyświetlanie stron elementów.',
        'entity'                        => 'Reguluje domyślą widoczność przypisywaną przez Kankę nowym elementom.',
        'entity_privacy'                => 'Okresla widoczność nowo stworzonych postaci, miejsc i tak dalej.',
        'gallery_visibility'            => 'Domyślna widoczność grafik dodawnych do galerii.',
        'post_collapsed'                => 'Określa, czy komentarze na stronie elementu są domyślnie rozwinięte, czy zwinięte.',
        'privacy'                       => 'Określa domyślną widoczność tworzonych elenentów. Będzie stosowana podczas dodawania nowych elementów i można ją zmienić ręcznie.',
        'private_mention_visibility'    => 'Kontroluje sposób wyświetlania nazw tajnych elementów wzmiankowanych w widocznych tekstach.',
        'related_visibility'            => 'Kontroluje widoczość komentarzy, cech i powiązań dodawanych do elementów.',
    ],
    'sections'  => [
        'display'   => 'Układ treści',
        'entity'    => 'Ustawienia elementów',
        'media'     => 'Wyświetlanie grafik',
        'mention'   => 'Wyświetlanie wzmianek',
    ],
    'tutorial'  => 'Ustawienia domyślne pomagają w tworzeniu treści. Możesz tu wybrać widoczność elementów, komentarzy, grafik i tak dalej: ustawienia będą stosowane automatycznie podczas tworzenia nowej zawartości. Dzięki temu oszczędzisz czas i łatwiej zapanujesz na organizacją kampanii.',
    'update'    => [
        'success'   => 'Zmieniono domyślne ustawienia kampanii.',
    ],
    'values'    => [
        'collapsed'     => [
            'collapsed' => 'Zwinięte',
            'default'   => 'Domyślna',
            'expanded'  => 'Rozwinięte',
        ],
        'connections'   => [
            'explorer'  => 'Mapa powiązań (premium)',
            'list'      => 'Lista',
        ],
        'descendants'   => [
            'all'       => 'Wyświetla wszystkie pochodne',
            'direct'    => 'Wyświetla bezpośrednio pochodne',
        ],
        'mentions'      => [
            'private'   => 'Wyświetla wzmiankowaną nazwę',
            'visible'   => 'Ukrywa wzmiankowaną nazwę',
        ],
    ],
];
