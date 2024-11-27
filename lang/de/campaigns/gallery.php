<?php

return [
    'actions'       => [
        'close'         => 'Schließen',
        'file-link'     => 'Dateilink',
        'focus_point'   => 'Fokuspunkt festlegen',
        'image-link'    => 'Bildlink',
        'reset_focus'   => 'Fokuspunkt zurücksetzen',
        'save'          => 'Speichern',
        'upgrade'       => 'Speicherplatz erweitern',
    ],
    'breadcrumb'    => 'Gallerie',
    'bulk'          => [
        'destroy'   => [
            'confirm'   => 'Bist du sicher, dass du die ausgewählten Elemente dauerhaft entfernen möchtest? Diese Aktion kann nicht rückgängig gemacht werden.',
            'success'   => '{0}Keine Dateien entfernt.|{1}Eine Datei entfernt.|{2,*} :Anzahl der entfernten Dateien.',
        ],
    ],
    'cta'           => 'Verwalte und verwende Bilder während der gesamten Kampagne wieder.',
    'destroy'       => [
        'folder'    => 'Ordner :name gelöscht.',
        'success'   => 'Bild :name gelöscht',
    ],
    'errors'        => [
        'max'           => 'Bitte wähle nur bis zu :count Dateien gleichzeitig aus.',
        'permissions'   => 'Deinen Kampagnenrollen fehlen die Berechtigungen :permission, um Bilder in die Kampagnengalerie hochladen zu dürfen.',
        'storage'       => 'Es ist nicht genügend Speicherplatz zum Hochladen der ausgewählten Bilder vorhanden. Verfügbarer Speicherplatz: :available.',
    ],
    'fields'        => [
        'created_by'            => 'hochgeladen von',
        'ext'                   => 'äußerlich',
        'file_type'             => 'Dateityp',
        'folder'                => 'Ordner',
        'image_mentioned_in'    => '{0} Dieses Bild wird in keinem Objekt der Kampagne erwähnt.|{1} In einem Eintrag/Beitrag erwähnt.|[2,*] erwähnt in :count Einträgen/Beiträgen.',
        'image_used_in'         => '{0} Wird als Bild in keines Object verwendet.|{1} Wird als Bild eines Objekts verwendet.|[2,*] Wird als Bild von :count entities verwendet.',
        'link'                  => 'Link',
        'name'                  => 'Name',
        'size'                  => 'Größe',
        'unused'                => 'Nirgendwo verwendet',
        'used_in'               => 'Verwendet in',
    ],
    'focus'         => [
        'locked'    => 'Eine Premium-Kampagne ist erforderlich, um den Fokuspunkt eines Bildes zu setzen.',
        'removed'   => 'Bildfokus entfernt.',
        'updated'   => 'Bildfokus aktualisiert.',
    ],
    'new_folder'    => [
        'title' => 'neuer Ordner',
    ],
    'no_folder'     => 'kein Ordner',
    'pitch'         => 'Lade Bilder direkt aus dem Texteditor in die Galerie der Kampagne hoch.',
    'placeholders'  => [
        'search'    => 'Bildname suchen ...',
    ],
    'storage'       => [
        'of'    => 'von',
        'title' => 'Speicher',
    ],
    'title'         => 'Kampagne :campaign Gallerie',
    'update'        => [
        'folder'    => 'Ordner geändert.',
        'success'   => 'Bild geändert',
    ],
    'uploader'      => [
        'add'           => 'neue hinzufügen',
        'new_folder'    => 'neuer Ordner',
        'or'            => 'oder',
        'select_file'   => 'Wählen Sie eine Datei aus',
        'well'          => 'Datei fallen lassen um sie hochzuladen',
    ],
];
