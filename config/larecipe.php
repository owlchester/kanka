<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Documentation Routes
    |--------------------------------------------------------------------------
    |
    | These options configure the behavior of the LaRecipe docs basic route
    | where you can specify the url of your documentations, the location
    | of your docs and the landing page when a user visits /docs route.
    |
    |
    */

    'docs' => [
        'route' => '/api-docs',
        'path' => '/resources/api-docs',
        'landing' => 'overview',
    ],

    /*
    |--------------------------------------------------------------------------
    | Documentation Versions
    |--------------------------------------------------------------------------
    |
    | Here you may specify and set the versions and the default (latest) one
    | of your documentation's versions where you can redirect the user to.
    | Just make sure that the default version is in the published list.
    |
    |
    */

    'versions' => [
        'default' => '1.0',
        'published' => [
            '1.0',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Documentation Settings
    |--------------------------------------------------------------------------
    |
    | These options configure the additional behaviors of your documentation
    | where you can limit the access to only authenticated users in your
    | system. It is false initially so that guests can view your docs.
    |
    | You may also specify links to show under the auth dropdown menu.
    | Logout link will show by default.
    |
    |
    */

    'settings' => [
        'auth' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    |
    | Obviously rendering markdown at the back-end is costly especially if
    | the rendered files are massive. Thankfully, caching is considered
    | as a good option to speed up your app when having high traffic.
    |
    | Caching period unit: minutes
    |
    */

    'cache' => [
        'enabled' => false,
        'period' => 60,
    ],

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    |
    | Here you can add configure the search functionality of your docs.
    | You can choose the default engine of your search from the list
    | However, you can also enable/disable the search's visibility
    |
    | Supported Search Engines: 'algolia', 'internal'
    |
    */

    'search' => [
        'enabled' => false,
        'default' => 'algolia',
        'engines' => [
            'internal' => [
                'index' => ['h2', 'h3'],
            ],
            'algolia' => [
                'key' => '',
                'index' => '',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Documentation Repository
    |--------------------------------------------------------------------------
    |
    | This is an optional config you can set in order to show an external link
    | to your documentation's repository if you have one. Once you set the
    | value of the url, LaRecipe automatically will show the nav button.
    |
    |
    */

    'repository' => [
        'provider' => 'github',
        'url' => 'https://github.com/owlchester/kanka',
    ],

    /*
    |--------------------------------------------------------------------------
    | Appearance
    |--------------------------------------------------------------------------
    |
    | Here you can add configure the appearance of your docs. For example,
    | you can swap the default logo to custom one that matches your Id
    | Also, you can change the theme of your docs if you prefer that
    |
    | Supported Themes: 'light', 'dark'
    |
    */

    'ui' => [
        'fav' => '/favicon.ico', // e.g.: /fav.png
        'code_theme' => 'dark',
        'show_side_bar' => true,
        'colors' => [
            'primary' => '#787AF6',
            'secondary' => '#2b9cf2',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | SEO
    |--------------------------------------------------------------------------
    |
    | These options configure the SEO settings of your docs. You can set the
    | author, the description and the keywords. Also, LaRecipe by default
    | sets the canonical link to the viewed page's link automatically.
    |
    |
    */

    'seo' => [
        'author' => 'Kanka',
        'description' => 'Free online worldbuilding and campaign management tool',
        'keywords' => 'Kanka api documentation integration discord app',
        'og' => [
            'title' => 'Kanka API Docs',
            'type' => 'article',
            'url' => 'kanka.io',
            'image' => '',
            'description' => 'Kanka\'s API documentation',
        ],
    ],

    /*
   |--------------------------------------------------------------------------
   | Forum
   |--------------------------------------------------------------------------
   |
   | Giving a chance to your users to post their questions or feedback
   | directly on your docs, is pretty nice way to engage them more.
   | However, you can also enable/disable the forum's visibility.
   |
   | Supported Services: 'disqus'
   |
   */

    'forum' => [
        'enabled' => false,
        'default' => 'disqus',
        'services' => [
            'disqus' => [
                'site_name' => '', // yoursite.disqus.com
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Components and Packages
    |--------------------------------------------------------------------------
    |
    | Once you create a new asset or theme, its directory will be
    | published under `larecipe-components` folder. However, If
    | you want a different location, feel free to change it.
    |
    |
    */
    'packages' => [
        'path' => 'larecipe-components',
    ],
];
