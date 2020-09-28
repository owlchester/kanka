<?php

return [
    'actions'       => [
        'add'   => 'Yeni Varlık Notu',
    ],
    'create'        => [
        'description'   => 'Yeni bir Varlık Notu yarat',
        'success'       => '\':name\' Varlık Notu :entity varlığına eklendi.',
        'title'         => ':name için Yeni Varlık Notu',
    ],
    'destroy'       => [
        'success'   => ':entity için \':name\' Varlık Notu kaldırıldı.',
    ],
    'edit'          => [
        'description'   => 'Varolan bir varlık notunu güncelle',
        'success'       => ':entity için \':name\' Varlık Notu güncellendi.',
        'title'         => ':name için varlık notunu güncelle',
    ],
    'fields'        => [
        'creator'   => 'Yaratan',
        'entry'     => 'Girdi',
        'name'      => 'Ad',
    ],
    'hint'          => 'Bir varlığın normal kutucuklarının standartlarına uymayan ya da sır tutulması gereken bilgiler Varlık Notları olarak eklenebilir.',
    'index'         => [
        'title' => ':name için Varlık Notları',
    ],
    'placeholders'  => [
        'name'  => 'Varlık notunun, gözlemin ya da yorumun adı',
    ],
    'show'          => [
        'title' => ':entity Varlığı için :name Varlık Notu',
    ],
];
