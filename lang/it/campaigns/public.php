<?php

return [
    'helpers'   => [
        'main'  => 'Le campagne pubbliche sono visibili a tutti gli utenti che hanno un link alla campagna o attraverso la pagina :public-campaigns. I permessi per gli utenti che visualizzano la campagna in questo modo sono controllati dal ruolo :public-role della campagna.',
    ],
    'title'     => 'Cambia la visibilità della campagna',
    'update'    => [
        'private'   => 'La campagna è ora privata e visibile solo ai suoi membri.',
        'public'    => 'La campagna è ora pubblica. Potrebbe volerci del tempo prima che appaia nella pagina :public-campaigns.',
    ],
];
