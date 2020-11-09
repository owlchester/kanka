<?php

return [
    'create'    => [
        'success'   => 'Organisasjon \':name\' opprettet.',
        'title'     => 'Opprett ny organisasjon.',
    ],
    'destroy'   => [
        'success'   => 'Organisasjon \':name\' fjernet.',
    ],
    'edit'      => [
        'success'   => 'Organisasjon \':name\' oppdatert.',
        'title'     => 'Rediger Organisasjon :name',
    ],
    'fields'    => [
        'organisation'  => 'Forelder Organisasjon',
    ],
    'helpers'   => [
        'descendants'   => 'Denne listen inneholder organisasjoner som stammer fra denne organisasjonen, og ikke bare de direkte under den.',
        'nested'        => 'Når man er i Rede Visning, kan man se Organisasjoner som i et rede. Organisasjoner uten forelder organisasjon blir vist som standard. Organisasjoner med datter-etikett kan klikkes for å vise datter objektene. Du kan fortsette å klikke på dem til det ikke er flere datter-objekter å vises.',
    ],
    'index'     => [
        'add'           => 'Legg til Organisasjon',
        'description'   => 'Ordne organisasjonene til :name.',
    ],
];
