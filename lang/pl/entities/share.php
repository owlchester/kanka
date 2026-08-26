<?php

return [
    'buttons'   => [
        'copy'          => 'Skopiuj link',
        'make_public'   => 'Upublicznij',
    ],
    'fields'    => [
        'campaign_access'   => 'Ustawienia kampanii',
        'visibility_mode'   => 'Napraw widoczność',
    ],
    'helpers'   => [
        'campaign_access'               => 'By udostępnić element publicznie należy najpierw upublicznić kampanię.',
        'entity_permissions_warning'    => 'Upublicznienie kampanii pozwoli wszystkim ją przeglądać. Elementy tajne pozostaną niewidoczne.',
        'hidden_explanation'            => 'Kampania jest publiczna, ale ten element ukryto przed osobami nie będącymi uczestnikami.',
        'hidden_unlisted_explanation'   => 'Kampanii nie ma w katalogu, żeby ją znaleźć, trzeba mieć link.',
        'member-link'                   => 'Udostępnij wyłącznie uczestnikom',
        'private_explanation'           => 'Ten element widzą tylko uczestnicy kampanii.',
        'public_explanation'            => 'Kampania i ten element są publiczne, może je zobaczyć każda osoba posiadająca link.',
        'unlisted_explanation'          => 'Kampania jest poza katalogiem, ale jej elementy są widoczne i każda osoba posiadająca link może je przeglądać.',
    ],
    'labels'    => [
        'member_link'   => 'Link dla uczestników',
        'public_link'   => 'Link publiczny',
        'share_link'    => 'Link do udostępnienia',
    ],
    'options'   => [
        'keep_private'          => 'Zachowaj prywatność',
        'make_all_public'       => 'Pokaż wszystkie :module osobom nie będącym uczestnikami',
        'make_campaign_public'  => 'Upublicznij kampanię',
        'make_entity_public'    => 'Pokaż :name osobom nie będącym uczestnikami',
    ],
    'status'    => [
        'hidden'    => 'Niewidoczne dla osób nie będących uczestnikami',
        'private'   => 'Kampania jest prywatna',
        'public'    => 'Widoczne dla osób nie będących uczestnikami',
        'unlisted'  => 'Widoczne dla każdej osoby posiadające link',
    ],
    'success'   => [
        'copied'            => 'Link skopiowany do schowka!',
        'copied_members'    => 'Skopiowano link dla uczestników.',
        'copied_public'     => 'Skopiowano link publiczny, każda posiadająca go osoba może zobaczyć element.',
        'updated'           => 'Zmieniono ustawienia widoczności,',
    ],
    'title'     => 'Udostępnianie elementu',
];
