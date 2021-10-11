<?php

return [
    'actions'       => [
        'add'   => 'Afegeix un enllaç',
    ],
    'create'        => [
        'success'   => 'S\'ha afegit l\'enllaç :name a :entity.',
        'title'     => 'Afegeix un enllaç a :entity',
    ],
    'destroy'       => [
        'success'   => 'S\'ha eliminat l\'enllaç :name de :entity.',
    ],
    'fields'        => [
        'icon'      => 'Icona',
        'name'      => 'Nom',
        'position'  => 'Posició',
        'url'       => 'URL',
    ],
    'helpers'       => [
        'goto'      => 'Anar a :name',
        'icon'      => 'Podeu personalitzar la icona que es mostra amb l\'enllaç. Podeu fer servir les icones gratuïtes de :fontawesome o deixar aquest camp en blanc per a utilitzar la icona per defecte.',
        'leaving'   => 'Esteu a punt de sortir de Kanka i anar a un altre domini. La pàgina a la que us dirigiu ha estat proporcionada per un usari i no ha estat revisada pel nostre web.',
        'url'       => 'L\'adreça a la que us dirigiu és :url.',
    ],
    'placeholders'  => [
        'icon'  => 'fab fa-d-and-d-beyond',
        'name'  => 'DNDBeyond',
        'url'   => 'https://dndbeyond.com/character-url',
    ],
    'show'          => [
        'helper'    => 'Les campanyes millorades poden afegir enllaços a les entitats que dirigeixen a webs externes.',
        'title'     => 'Enllaços de :name',
    ],
    'unboosted'     => [
        'text'  => 'Només les :boosted-campaigns poden afegir enllaços externs a les entitats.',
        'title' => 'Funcionalitat de campanya millorada',
    ],
    'update'        => [
        'success'   => 'S\'ha actualitzat l\'enllaç :name de :entity.',
        'title'     => 'Actualitza l\'enllaç de :name',
    ],
];
