<?php

return [
    'children'      => [
        'actions'   => [
            'add'           => 'Füge neue Kategorie hinzu',
            'add_entity'    => 'Zum Objekt hinzufügen',
        ],
        'create'    => [
            'attach_success'        => '{1} :count Objekte zum Tag :name hinzugefügt.|[2,*] :count Objekte zum Tag :name hinzugefügt.',
            'attach_success_entity' => 'Erfolgreich aktualisierte Tags für :name.',
            'entity'                => 'Tags hinzufügen zu :name',
            'helper'                => 'Versehe einen oder mehrere Einträge mit dem Tag :name',
            'title'                 => 'Tag-Einträge',
        ],
    ],
    'create'        => [
        'title' => 'Neue Kategorie',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'children'          => 'Kinder',
        'icon'              => 'Symbol',
        'is_auto_applied'   => 'Automatisch auf neue Objekte anwenden',
        'is_hidden'         => 'Ausgeblendet von Header und Tooltip',
    ],
    'helpers'       => [
        'icon'          => 'Verwende Symbole aus :fontawesome oder :rpgawesome. Das Symbol wird in Listen anstelle des Tag-Namens angezeigt.',
        'no_children'   => 'Es gibt derzeit kein Objekt, die mit diesem Tag getaggt sind.',
        'no_posts'      => 'Derzeit gibt es keine Beiträge mit diesem Tag.',
    ],
    'hints'         => [
        'children'          => 'Diese Liste enthält alle Objekte, die direkt in dieser Kategorie und allen Unterkategorien sind.',
        'is_auto_applied'   => 'Aktiviere diese Option, um dieses Tag automatisch auf neu erstellte Objekte anzuwenden.',
        'is_hidden'         => 'Wenn es aktiviert ist, wird dieser Tag nicht in der Kopfzeile oder QuickInfo eines Objekts angezeigt.',
        'tag'               => 'Unten dargestellt sind alle Kategorien, die direkt unter dieser eingeordnet sind.',
    ],
    'index'         => [],
    'lists'         => [
        'empty' => 'Verwende Tags, um Einträge in deiner Welt zu gruppieren und zu filtern, um die Navigation zu vereinfachen.',
    ],
    'placeholders'  => [
        'icon'  => 'Probieren Sie :example1 oder :example2 aus',
        'type'  => 'Überlieferung, Geschichte, Kriege, Religion, Flaggenkunde',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Kinder',
        ],
    ],
    'tags'          => [],
    'transfer'      => [
        'entities'      => [
            'helper'    => 'Trage Einträge, die mit dem Tag „name“ versehen sind, in ein anderes Tag über.',
            'title'     => 'Einträge übertragen',
        ],
        'fail'          => 'Die Übertragung von Objekten von :tag nach :newTag ist fehlgeschlagen',
        'fail_post'     => 'Übertragung von Beiträgen von :tag nach :newTag fehlgeschlagen',
        'posts'         => [
            'helper'    => 'Artikel, die mit dem Tag :name versehen sind, in einen  anderen Tag verschieben.',
            'title'     => 'Artikel übertragen',
        ],
        'success'       => 'Objekte wurden erfolgreich von :tag nach :newTag übertragen',
        'success_post'  => 'Erfolgreich Beiträge von :tag nach :newTag übertragen',
        'transfer'      => 'übertrage',
    ],
];
