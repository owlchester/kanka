<?php

return [
    'actions'       => [
        'add'       => 'Ny Entitetsanteckning',
        'add_user'  => 'Lägg till Användare',
    ],
    'create'        => [
        'success'   => 'Entitetsanteckning \':name\' tillagd till :entity.',
        'title'     => 'Ny Entitetsanteckning för :name',
    ],
    'destroy'       => [
        'success'   => 'Entitetsanteckning \':name\' för :entity borttagen.',
    ],
    'edit'          => [
        'success'   => 'Entitetsanteckning \':name\' för :entity uppdaterad.',
        'title'     => 'Uppdatera entitetsanteckning för :name',
    ],
    'fields'        => [
        'creator'   => 'Skapare',
        'entry'     => 'Notering',
        'name'      => 'Namn',
    ],
    'hint'          => 'Information som inte riktigt passar i dom vanliga fälten på en entitet eller som borde hållas privat kan läggas till som en Entitetsanteckning.',
    'hints'         => [],
    'index'         => [
        'title' => 'Entitetsanteckning för :name',
    ],
    'placeholders'  => [
        'name'  => 'Namn på entitetsanteckningen, observationen eller anmärkningen',
    ],
    'show'          => [
        'advanced'  => 'Avancerade Behörigheter',
        'title'     => 'Entitetsanteckning :name för :entity',
    ],
];
