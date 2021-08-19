<?php

return [
    'actions'       => [
        'back'      => 'Vissza ide: :name',
        'edit'      => 'Térkép szerkesztése',
        'explore'   => 'Felfedezés',
    ],
    'create'        => [
        'success'   => ':name térképet létrehoztuk.',
        'title'     => 'Új térkép',
    ],
    'destroy'       => [
        'success'   => ':name térképet töröltük.',
    ],
    'edit'          => [
        'success'   => ':name térképet frissítettük.',
        'title'     => ':name térkép szerkesztése',
    ],
    'errors'        => [
        'dashboard' => [
            'missing'   => 'Szükség van egy képre a térképnek, hogy a főoldalon megjeleníthessük.',
        ],
        'explore'   => [
            'missing'   => 'Kérlek adj egy képet a térképnek, mielőtt nekikezedél a felfedezésének.',
        ],
    ],
    'fields'        => [
        'center_marker'     => 'Jelölő',
        'center_x'          => 'Alapértelmezett hosszúsági pozíció',
        'center_y'          => 'Alapértelmezett szélességi pozíció',
        'centering'         => 'Középre állítás',
        'distance_measure'  => 'Távolságmérő',
        'distance_name'     => 'Távolsági aránymérték egysége',
        'grid'              => 'Rács',
        'initial_zoom'      => 'Kezdeti zoom',
        'map'               => 'Szülő Térkép',
        'maps'              => 'Térképek',
        'max_zoom'          => 'Maximális zoom',
        'min_zoom'          => 'Minimális zoom',
        'name'              => 'Név',
        'tabs'              => [
            'coordinates'   => 'Koordináták',
            'marker'        => 'Jelölő',
        ],
        'type'              => 'Típus',
    ],
    'helpers'       => [
        'center'            => 'A következő értékek megváltoztatása befolyásolja, hogy milyen területre fókuszálsz a térképen. Ha üresen hagyod, a térkép közepére fogsz fókuszálni.',
        'centering'         => 'Ha egy jelölőt állítasz középre, az lesz az alapértelmezett koordináta.',
        'descendants'       => 'Ez a lista a helyszín összes leszármazott térképét tartalmazza, nemcsak a közvetlen altérképeket.',
        'distance_measure'  => 'Távolságmérő hozzáadásával Felfedezés módban lehetségessé válik a távolságmérés a térképen.',
        'grid'              => 'Határozd meg a rács méretét, amely majd megjelenik Felfedezés módban.',
        'initial_zoom'      => 'A térkép a kezdeti zoom szinttel töltődik be. Az alapértelmezett érték: :default, a maximális érték: :max, míg a minimális zoom szint: :min.',
        'max_zoom'          => 'A legmagasabb szint, amennyire be lehet zoomolni a térképen. Az alapértelmezett értéke: :default, míg a maximális zoom értéke: :max.',
        'min_zoom'          => 'A legalacsonyabb szint, amennyire ki lehet zoomolni a térképen. Az alapértelmezett értéke: :default, míg a legalacsonyabb zoom szint értéke: :min.',
        'missing_image'     => 'Tölts fel egy képet a térképhez mielőtt nekikezdenél újabb rétegeket, és térképjelzőket elhelyezni rajta!',
        'nested'            => 'Hierarchikus nézetben a térképeket alá-fölérendeltségi viszonyukban tekintheted meg. Alapesetben a szülő helyszín nélküli helyszínek látszanak, leszármazottakkal rendelkező térképekre kattintva megtekintheted azok altérképeit, és így tovább amíg az adott altérképnek vannak leszármazottjai.',
        'nested_parent'     => ':parent térképeinek mutatása',
        'nested_without'    => 'Minden olyan térkép mutatása, aminek nincs szülője. Klikkelj egy sorra, hogy lásd a gyermektérképeit.',
    ],
    'index'         => [
        'add'   => 'Új Térkép',
        'title' => 'Térképek',
    ],
    'maps'          => [
        'title' => ':name térképei',
    ],
    'panels'        => [
        'groups'    => 'Csoportok',
        'layers'    => 'Rétegek',
        'markers'   => 'Térképjelzők',
        'settings'  => 'Beállítások',
    ],
    'placeholders'  => [
        'center_marker'     => 'Hagyd üresen, hogy a térkép közepét töltsük be.',
        'center_x'          => 'Hagyd üresen, hogy a térkép közepét töltsük be.',
        'center_y'          => 'Hagyd üresen, hogy a térkép közepét töltsük be.',
        'distance_measure'  => 'Egység / pixel',
        'distance_name'     => 'A távolság mértékegységének neve (kilométer, mérföld, stb.)',
        'grid'              => 'Rácsvonalak közötti távolság, pixelben. Ha üresen hagyod nem jelenik meg a rács a térképen.',
        'name'              => 'A térkép neve',
        'type'              => 'Tömlöc, Város, Galaxis',
    ],
    'show'          => [
        'tabs'  => [
            'maps'  => 'Térképek',
        ],
        'title' => ':name térkép',
    ],
];
