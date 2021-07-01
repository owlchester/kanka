<?php

return [
    'actions'       => [
        'add'   => 'Dodaj odnośnik',
    ],
    'create'        => [
        'success'   => 'Dodano odnośnik :name do elementu :entity.',
        'title'     => 'Dodaj odnośnik do :name',
    ],
    'destroy'       => [
        'success'   => 'Usunięto odnośnik :name z elementu :entity.',
    ],
    'fields'        => [
        'icon'      => 'Ikona',
        'name'      => 'Nazwa',
        'position'  => 'Kolejność',
        'url'       => 'URL',
    ],
    'helpers'       => [
        'goto'      => 'Idź do :name',
        'icon'      => 'Możesz dostosować ikonę wyświetlaną przy odnośniku. Użyj dowolnej ikony z :fontawesome albo zostaw to pole puste, by wyświetlać ikonę domyślną.',
        'leaving'   => 'Zaraz opuścisz Kankę i przejdziesz do strony zewnętrznej. Strona ta została załączona przez użytkownika i nie jest przez nas kontrolowana.',
        'url'       => 'Adres do którego zamierzasz przejść to :url.',
    ],
    'placeholders'  => [
        'icon'  => 'fab fa-d-and-d-beyond',
        'name'  => 'DNDBeyond',
        'url'   => 'https://dndbeyond.com/character-url',
    ],
    'show'          => [
        'helper'    => 'W doładowanych kampaniach można dodawać elementom odnośniki do stron zewnętrznych.',
        'title'     => 'Odnośniki elementu :name',
    ],
    'unboosted'     => [
        'text'  => 'Dodawanie linków do zasobów zewnętrznych, wyświetlanych bezpośrednio w opisie elementu wymaga :boosted-campaigns.',
        'title' => 'doładowania kampanii',
    ],
    'update'        => [
        'success'   => 'Zaktualizowano odnośnik :name dla elementu :entity.',
        'title'     => 'Aktualizacja odnośnika elementu :name',
    ],
];
