<?php

return [
    'children'      => [
        'actions'   => [
            'add'           => 'Pridať novú kategóriu',
            'add_entity'    => 'Pridať nový objekt',
        ],
        'create'    => [
            'attach_success'        => '{1} :count objekt pridaný do kategórie :name.|[2,4] :count objekty pridané do kategórie :name.|[5,*] :count objektov pridaných do kategórie :name.',
            'attach_success_entity' => 'Kategórie pre :name úspešne pridané.',
            'entity'                => 'Pridať kategórie k :name',
            'modal_title'           => 'Pridať objekty k :name.',
        ],
    ],
    'create'        => [
        'title' => 'Nová kategória',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'children'          => 'Podradené kategórie',
        'is_auto_applied'   => 'Automaticky nastaviť pre nové objekty',
        'is_hidden'         => 'Skryté v záhlaví a náhľade',
    ],
    'helpers'       => [
        'no_children'   => 'Aktuálne nemá túto kategóriu pridelený žiaden objekt.',
        'no_posts'      => 'Aktuálne nemá túto kategóriu pridelená žiadna poznámka.',
    ],
    'hints'         => [
        'children'          => 'Tento zoznam obsahuje všetky objekty priamo pod touto kategóriou a jej podriadenými kategóriami.',
        'is_auto_applied'   => 'Aktivuj toto nastavenie, ak chceš, aby bola táto kategória automaticky pri novo vytvorených objektoch.',
        'is_hidden'         => 'Ak zaškrtneš túto možnosť, táto kategória sa nezobrazí v záhlaví ani náhľade objektu.',
        'tag'               => 'Zobrazené sú všetky kategórie, ktoré sú tejto priamo podriadené.',
    ],
    'index'         => [],
    'placeholders'  => [
        'type'  => 'mýtus, vojna, historická udalosť, náboženstvo, vexilológia',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Podradené kategórie',
        ],
    ],
    'tags'          => [],
    'transfer'      => [
        'description'       => 'Presunie objekty tejto kategórie pod inú kategóriu.',
        'fail'              => 'Nepodarilo sa presunúť objekty z :tag na :newTag',
        'fail_post'         => 'Nepodarilo sa presunúť ponámky z :tag na :newTag',
        'post_description'  => 'Presunie poznámky tejto kategórie pod inú kategóriu.',
        'success'           => 'Presun objektov z :tag na :newTag úspešný',
        'success_post'      => 'Presun poznámok z :tag na :newTag úspešný',
        'title'             => 'Presun :name',
        'transfer'          => 'Presun',
    ],
];
