<?php

return [
    'actions'       => [
        'copy'      => 'Kopiuj',
        'transfer'  => 'Przenieś',
    ],
    'errors'        => [
        'permission'        => 'Nie możesz tworzyć elementów :type w kampanii docelowej.',
        'permission_update' => 'Nie masz uprawień, by przenieś ten element.',
        'same_campaign'     => 'Wybierz inną kampanię, do której element ma być przeniesiony.',
        'unknown_campaign'  => 'Nieznana kampania.',
    ],
    'fields'        => [
        'campaign'      => 'Kampania docelowa',
        'copy'          => 'Opcje kopiowania',
        'select_one'    => 'Wybierz kampanię',
    ],
    'helpers'       => [
        'copy'  => 'Zachowaj kopię elementu w obecnej kampanii.',
    ],
    'panel'         => [
        'description'           => 'Przenosi element do innej kampanii. Możesz opcjonalnie zachować tu kopię.',
        'description_bulk_copy' => 'Wybierz kampanię, do której chcesz skopiować wybrane elementy.',
        'title'                 => 'Przenieś element do innej kampanii.',
    ],
    'success'       => 'Przeniesiono element :name do kampanii :campaign.',
    'success_copy'  => 'Skopiowano element :name do kampanii :campaign.',
    'title'         => 'Przenoszenie elementu :name',
    'warnings'      => [
        'custom'    => 'Ten element nie należy do kategorii podstawowej, ale dodatkowej, stworzonej na potrzeby tej kampanii. W kampanii docelowej zostanie przeniesiony do Notatek.',
    ],
];
