<?php

return [
    'actions'       => [
        'entry' => 'Schrijf een custom invoer veld voor deze markering.',
        'remove'=> 'Verwijder markering',
        'update'=> 'Wijzig markering',
    ],
    'create'        => [
        'success'   => 'Markering :name gemaakt.',
        'title'     => 'Nieuwe Markering',
    ],
    'delete'        => [
        'success'   => 'Markering :name verwijderd.',
    ],
    'edit'          => [
        'success'   => 'Markering :name bijgewerkt.',
        'title'     => 'Wijzig Markering :name',
    ],
    'fields'        => [
        'circle_radius' => 'Cirkel straal',
        'copy_elements' => 'Kopieer elementen',
        'custom_icon'   => 'Aangepast Pictogram',
        'custom_shape'  => 'Aangepaste Vorm',
        'font_colour'   => 'Pictogram Kleur',
        'group'         => 'Markering Groep',
        'is_draggable'  => 'Sleepbaar',
        'latitude'      => 'Breedtegraad',
        'longitude'     => 'Lengtegraad',
        'opacity'       => 'Doorzichtigheid',
        'pin_size'      => 'Pin Grootte',
        'polygon_style' => [
            'stroke'            => 'Lijn kleur',
            'stroke-opacity'    => 'Lijn doorzichtigheid',
            'stroke-width'      => 'Lijn breedte',
        ],
    ],
    'helpers'       => [
        'base'                      => 'Voeg markeringen toe aan de kaart door op een willekeurige plek te klikken.',
        'copy_elements'             => 'Kopieer groepen, lagen en markeringen.',
        'copy_elements_to_campaign' => 'Kopieer groepen, lagen en markeringen van de kaarten. Markeringen die aan een entiteit zijn gekoppeld, worden geconverteerd naar een standaard markering.',
        'custom_icon'               => 'Kopieer de HTML van een pictogram van :fontawesome of :rpgawesome, of een aangepast SVG pictogram.',
        'custom_radius'             => 'Selecteer de optie voor custom formaat in de vervolgkeuzelijst om een formaat te definiëren.',
        'draggable'                 => 'Schakel in om het verplaatsen van een markering in de verkenning modus toe te staan.',
        'label'                     => 'Een label wordt als een tekstblok op de kaart weergegeven. De inhoud is de naam van de markering van de entiteit.',
        'polygon'                   => [
            'edit'  => 'Klik op de kaart om die positie toe te voegen aan de coördinaten van de polygoon.',
            'new'   => 'Verplaats de markering op de kaart om de positie op de veelhoek op te slaan.',
        ],
    ],
    'icons'         => [
        'custom'        => 'Aangepast',
        'entity'        => 'Entiteit',
        'exclamation'   => 'Uitroep',
        'marker'        => 'Markering',
        'question'      => 'Vraag',
    ],
    'placeholders'  => [
        'custom_shape'  => '100,100 200,240 340,110',
        'name'          => 'Vereist als er geen entiteit is geselecteerd',
    ],
    'shapes'        => [
        '0' => 'Cirkel',
        '1' => 'Vierkant',
        '2' => 'Driehoek',
        '3' => 'Aangepast',
    ],
    'sizes'         => [
        '0' => 'Mini',
        '1' => 'Standaard',
        '2' => 'Klein',
        '3' => 'Groot',
        '4' => 'Zeer Groot',
    ],
    'tabs'          => [
        'circle'    => 'Cirkel',
        'label'     => 'Label',
        'marker'    => 'Markering',
        'polygon'   => 'Polygoon',
    ],
];
