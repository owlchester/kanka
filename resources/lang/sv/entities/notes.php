<?php

return [
    'actions'       => [
        'add'       => 'Ny Entitetsanteckning',
        'add_user'  => 'Lägg till Användare',
    ],
    'create'        => [
        'description'   => 'Skapa en ny Entitetsanteckning',
        'success'       => 'Entitetsanteckning \':name\' tillagd till :entity.',
        'title'         => 'Ny Entitetsanteckning för :name',
    ],
    'destroy'       => [
        'success'   => 'Entitetsanteckning \':name\' för :entity borttagen.',
    ],
    'edit'          => [
        'description'   => 'Uppdatera en existerande entitetsanteckning',
        'success'       => 'Entitetsanteckning \':name\' för :entity uppdaterad.',
        'title'         => 'Uppdatera entitetsanteckning för :name',
    ],
    'fields'        => [
        'creator'   => 'Skapare',
        'entry'     => 'Notering',
        'is_pinned' => 'Fastnålad',
        'name'      => 'Namn',
        'position'  => 'Fastnålad position',
    ],
    'hint'          => 'Information som inte riktigt passar i dom vanliga fälten på en entitet eller som borde hållas privat kan läggas till som en Entitetsanteckning.',
    'hints'         => [
        'is_pinned' => 'Fastnålad entitetsanteckningar visas nedanför entitetens text på den primära entitets vyn. Kombinera med positionsfältet för att kontrollera i vilken ordning fastnålade entitetsanteckningar visas.',
    ],
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
