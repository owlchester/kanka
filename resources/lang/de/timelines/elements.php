<?php

return [
    'create'        => [
        'success'   => 'Element zum Zeitstrahl hinzugefügt',
        'title'     => 'neues Zeitstrahlelement',
    ],
    'delete'        => [
        'success'   => 'Element :name entfernt',
    ],
    'edit'          => [
        'success'   => 'Element aktualisiert',
        'title'     => 'Zeitstrahlelement editieren',
    ],
    'fields'        => [
        'date'              => 'Datum',
        'era'               => 'Epoche',
        'icon'              => 'Icon',
        'use_entity_entry'  => 'Zeigen Sie den Eintrag des angehängten Objekts unten an. Der Text dieses Elements wird zuerst angezeigt, falls vorhanden.',
    ],
    'helpers'       => [
        'entity_is_private' => 'Das Element des Objekts ist privat.',
        'icon'              => 'Kopieren Sie den HTML-Code eines Symbols von :fontawesome oder :rpgawesome.',
        'is_collapsed'      => 'Das Element wird standardmäßig reduziert angezeigt.',
    ],
    'placeholders'  => [
        'date'      => 'z.B. 42. März oder 1332-1337',
        'name'      => 'Erforderlich, wenn kein Objekt ausgewählt ist',
        'position'  => 'Position in der Liste der Elemente für die Epoche. Lassen Sie das Feld leer, um es am Ende hinzuzufügen.',
    ],
];
