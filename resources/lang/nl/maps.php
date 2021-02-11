<?php

return [
    'actions'       => [
        'back'      => 'Terug naar :name',
        'edit'      => 'Wijzig Kaart',
        'explore'   => 'Verkennen',
    ],
    'create'        => [
        'success'   => 'Kaart :name gemaakt.',
        'title'     => 'Nieuwe Kaart',
    ],
    'destroy'       => [
        'success'   => 'Kaart :name verwijderd.',
    ],
    'edit'          => [
        'success'   => 'Kaart :name bijgewerkt.',
        'title'     => 'Wijzig Kaart :name',
    ],
    'errors'        => [
        'dashboard' => [
            'missing'   => 'Deze kaart heeft een afbeelding nodig om op het dashboard te kunnen weergeven.',
        ],
        'explore'   => [
            'missing'   => 'Voeg een afbeelding toe aan de kaart voordat je deze kunt verkennen.',
        ],
    ],
    'fields'        => [
        'center_x'          => 'Standaard Lengtegraad Positie',
        'center_y'          => 'Standaard Breedtegraad Positie',
        'distance_measure'  => 'Afstandsmeting',
        'distance_name'     => 'Afstandseenheid',
        'grid'              => 'Raster',
        'initial_zoom'      => 'Initiële zoom',
        'map'               => 'Bovenliggende Kaart',
        'maps'              => 'Kaarten',
        'max_zoom'          => 'Maximale zoom',
        'min_zoom'          => 'Minimale zoom',
        'name'              => 'Naam',
        'type'              => 'Type',
    ],
    'helpers'       => [
        'center'            => 'Als je de volgende waarden wijzigt, wordt er bepaald op welk gebied van de kaart de focus is gericht. Als je deze waarden leeg laat, wordt er op het midden van de kaart gefocust.',
        'descendants'       => 'Deze lijst bevat alle kaarten die afstammen van deze kaart, en niet alleen de kaarten er direct onder.',
        'distance_measure'  => 'Door de kaart een afstandsmeting te geven, wordt het meetinstrument in de verkenning modus ingeschakeld.',
        'grid'              => 'Definieer een raster grootte die in de verkenning modus wordt weergegeven.',
        'initial_zoom'      => 'Het aanvankelijke zoomniveau waarmee een kaart is geladen. De standaardwaarde is :default, terwijl de hoogst toegestane waarde :max is en de laagst toegestane waarde :min.',
        'max_zoom'          => 'Op een kaart kan maximaal worden ingezoomd. De standaardwaarde is :default, terwijl de hoogst toegestane waarde :max is.',
        'min_zoom'          => 'Op een kaart kan maximaal worden uitgezoomd. De standaardwaarde is :default, terwijl de laagst toegestane waarde :min is.',
        'missing_image'     => 'Sla de kaart met een afbeelding op voordat je lagen en markeringen kunt toevoegen.',
        'nested'            => 'In geneste weergave kan je jouw kaarten op een geneste manier bekijken. Kaarten zonder bovenliggende kaart worden standaard weergegeven. Op kaarten met gerelateerden kan worden geklikt om die gerelateerden te bekijken. Je kunt blijven klikken totdat er geen gerelateerden meer te zien zijn.',
    ],
    'index'         => [
        'add'   => 'Nieuwe Kaart',
        'title' => 'Kaarten',
    ],
    'maps'          => [
        'title' => 'Kaarten van :name',
    ],
    'panels'        => [
        'groups'    => 'Groepen',
        'layers'    => 'Lagen',
        'markers'   => 'Markeringen',
        'settings'  => 'Instellingen',
    ],
    'placeholders'  => [
        'center_x'          => 'Laat leeg om de kaart in het midden te laden',
        'center_y'          => 'Laat leeg om de kaart in het midden te laden',
        'distance_measure'  => 'Eenheden per pixel',
        'distance_name'     => 'Naam van de afstandseenheid (kilometer, mijl)',
        'grid'              => 'Afstand in pixel tussen raster elementen. Laat leeg om het raster te verbergen.',
        'name'              => 'Naam van de kaart',
        'type'              => 'Dungeon, Stad, Sterrestelsel',
    ],
    'show'          => [
        'tabs'  => [
            'maps'  => 'Kaarten',
        ],
        'title' => 'Kaart :name',
    ],
];
