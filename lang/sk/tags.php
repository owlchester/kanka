<?php

return [
    'children'      => [
        'actions'   => [
            'add'   => 'Pridať novú kategóriu',
        ],
        'create'    => [
            'attach_success'    => '{1} :count objekt pridaný do kategórie :name.|[2,4] :count objekty pridané do kategórie :name.|[5,*] :count objektov pridaných do kategórie :name.',
            'modal_title'       => 'Pridať objekty k :name.',
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
        'nested_without'    => 'Zobrazujú sa všetky kategórie, ktoré nemajú nadradenú kategóriu. Kliknutím na riadok zobrazíš podradené kategórie.',
        'no_children'       => 'Aktuálne nemá túto kategóriu pridelený žiaden objekt.',
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
        'description'   => 'Presunie objekty tejto kategórie pod inú kategóriu.',
        'fail'          => 'Nepodarilo sa presunúť objekty z :tag na :newTag',
        'success'       => 'Presun objektov z :tag na :newTag bol úspešný',
        'title'         => 'Presun :name',
        'transfer'      => 'Presun',
    ],
];
