<?php

return [
    /**
     * We use FontAwesome kits to load additional icons. To have fontawesome loaded in your local
     * version of Kanka, create a kit on fontawesome and add your kit name in your .env file.
     * https://fontawesome.com/kits
     */
    'kit' => getenv('FONTAWESOME_KIT'),

    'search' => 'https://fontawesome.com/search',
];
