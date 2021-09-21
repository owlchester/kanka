<?php

return [
    'actions'       => [
        'add'       => 'Nová poznámka',
        'add_role'  => 'Přidat roli',
        'add_user'  => 'Přidat uživatele',
    ],
    'create'        => [
        'description'   => 'Přidat novou poznámku objektu',
        'success'       => 'Poznámka ":name" přidána objektu :entity.',
        'title'         => 'Nová poznámka objektu :name',
    ],
    'destroy'       => [
        'success'   => 'Poznámka ":name" objektu :entity odstraněna.',
    ],
    'edit'          => [
        'description'   => 'Aktualizovat tuto poznámku',
        'success'       => 'Poznámka ":name" objektu :entity aktualizována.',
        'title'         => 'Upravit poznámku objektu :name',
    ],
    'fields'        => [
        'collapsed' => 'Zobrazovat poznámku sbalenou',
        'creator'   => 'Autor',
        'entry'     => 'Záznam',
        'name'      => 'Název',
    ],
    'footer'        => [
        'created'   => 'Vytvořeno uživatelem :user dne :date',
        'updated'   => 'Aktualizováno uživatelem :user dne :date',
    ],
    'hint'          => 'Informace, na které nestačí běžné vlastnosti objektu nebo které je třeba udržovat v soukromí, lze přidat jako poznámky objektu.',
    'hints'         => [
        'reorder'   => 'Klepnutím na ikonu :icon v záhlaví objektu lze změnit pořadí poznámek.',
    ],
    'index'         => [
        'title' => 'Poznámky objektu :name',
    ],
    'placeholders'  => [
        'name'  => 'Název poznámky, nálezu nebo připomínky',
    ],
    'show'          => [
        'advanced'  => 'Pokročilá oprávnění',
        'title'     => 'Poznámka :name objektu :entity',
    ],
];
