<?php

return [
    'actions'       => [
        'copy'  => 'Kopiuj',
    ],
    'errors'        => [
        'permission'        => 'Nie możesz tworzyć elementów tego typu w kampanii docelowej.',
        'permission_update' => 'Nie masz uprawień, by przenieś ten element.',
        'same_campaign'     => 'Musisz wybrać kampanię, do której element ma być przeniesiony.',
        'unknown_campaign'  => 'Nieznana kampania.',
    ],
    'fields'        => [
        'campaign'      => 'Kampania docelowa',
        'copy'          => 'Skopiuj',
        'select_one'    => 'Wybierz kampanię',
    ],
    'helpers'       => [
        'copy'  => 'Stwórz kopię elementu ze wskazanej kampanii.',
    ],
    'panel'         => [
        'description'           => 'Wybierz kampanię do której element ma zostać przeniesiony albo skopiowany.',
        'description_bulk_copy' => 'Wybierz kampanię, do której chcesz skopiować wybrane elementy.',
        'title'                 => 'Przenieś lub skopiuj element do innej kampanii.',
    ],
    'success'       => 'Przeniesiono element :name.',
    'success_copy'  => 'Skopiowano element :name.',
    'title'         => 'Przenoszenie elementu :name',
    'warnings'      => [
        'custom'    => 'Ten element nie jest częścią modułu domyślnego, ale własnego, stworzonego w tej kampanii. W kampanii docelowej stanie się elementem Notatek.',
    ],
];
