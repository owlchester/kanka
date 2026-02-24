<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Config
    |--------------------------------------------------------------------------
    |
    | This option defines the default config that is provided to HTMLPurifier.
    |
    */

    'default' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Config sets
    |--------------------------------------------------------------------------
    |
    | Here you may configure various sets of configuration for differentiated use of HTMLPurifier.
    | A specific set of configuration can be applied by calling the "config($name)" method on
    | a Purify instance. Feel free to add/remove/customize these attributes as you wish.
    |
    | Documentation: http://htmlpurifier.org/live/configdoc/plain.html
    |
    |   Core.Encoding               The encoding to convert input to.
    |   HTML.Doctype                Doctype to use during filtering.
    |   HTML.Allowed                The allowed HTML Elements with their allowed attributes.
    |   HTML.ForbiddenElements      The forbidden HTML elements. Elements that are listed in this
    |                               string will be removed, however their content will remain.
    |   CSS.AllowedProperties       The Allowed CSS properties.
    |   AutoFormat.AutoParagraph    Newlines are converted in to paragraphs whenever possible.
    |   AutoFormat.RemoveEmpty      Remove empty elements that contribute no semantic information to the document.
    |
    */

    'configs' => [

        'default' => [
            'Core.Encoding' => 'utf-8',
            'HTML.Doctype' => 'HTML 4.01 Transitional',

            /*
            |--------------------------------------------------------------------------
            | HTML.Allowed
            |--------------------------------------------------------------------------
            |
            | The allowed HTML Elements with their allowed attributes.
            |
            | http://htmlpurifier.org/live/configdoc/plain.html#HTML.Allowed
            |
            */
            'HTML.Allowed' => ''
                /** Titles */
                . 'h1[class|style|id|title],'
                . 'h2[class|style|id|title],'
                . 'h3[class|style|id|title],'
                . 'h4[class|style|id|title],'
                . 'h5[class|style|id|title],'
                . 'h6[class|style|id|title],'
                /** General elements */
                . 'div[class|style|id|align|role|title],'
                . 'p[class|style|id|dir|align],'
                . 'span[class|style|id|dir],'
                . 'a[href|class|style|target|rel|title|id|role|data-toggle|data-html|data-dropdown|data-pulse|data-animate|data-tooltip|data-title|data-entity-type],'
                . 'br[class|style],'
                . 'i[class|style],u[class|style],'
                . 'img[src|style|alt|width|height|class|title|id|data-gallery-id|data-uuid],'
                . 'hr[class|style|id|title],'

                /** Text blocks */
                . 'pre[class|style|title|id],'
                . 'blockquote[cite|class|style|id],'
                . 'code[class|style|id],'

                /** Lists **/
                . 'ul[class|style|id|role|data-type],'
                . 'ol[class|style|id|role|start|type],'
                . 'li[class|style|id|role|value|data-type|data-checked],'
                . 'dl[class|style|id],dt[class|style|id],dd[class|style|id],'

                /** Task lists */
                . 'label[class|style],'
                . 'input[type|checked|disabled],'

                /** Misc elements */
                . 'mark[class|style],'
                . 'cite[class|style],'
                . 'q[cite|class|style],'
                . 'caption[class|style|id|title],'
                . 'acronym[title|class|style],'
                . 'abbr[title|class|style],'
                . 'font[class|style|color],'
                . 'summary[class|style|id],'
                . 'details[class|style|id|open],'
                . 'figure[class|style|id|title],figcaption[class|style|id|title],'

                /** Iframe, combined with the domain whitelist */
                . 'iframe[src|width|height|style|class|scrolling|id],'

                /** Formatting */
                . 'ins[class|style],del[class|style],'
                . 'sup[class|style],sub[class|style],'
                . 'big,small,'
                . 's[class|style],strong[class|style],em[class|style],b[class|style],strike,'

                /** Tables */
                . 'table[class|style|summary|border|cellpadding|cellspacing|id|width],'
                . 'tbody[class|style|id],'
                . 'thead[class|style|id],'
                . 'tfoot[class|style|id],'
                . 'colgroup,'
                . 'col[style|class],'
                . 'tr[class|style|id],'
                . 'td[class|style|abbr|colspan|rowspan|title|align|valign],'
                . 'th[class|style|abbr|colspan|rowspan|title|align|valign],',

            /*
            |--------------------------------------------------------------------------
            | HTML.ForbiddenElements
            |--------------------------------------------------------------------------
            |
            | The forbidden HTML elements. Elements that are listed in
            | this string will be removed, however their content will remain.
            |
            | For example if 'p' is inside the string, the string: '<p>Test</p>',
            |
            | Will be cleaned to: 'Test'
            |
            | http://htmlpurifier.org/live/configdoc/plain.html#HTML.ForbiddenElements
            |
            */

            'HTML.ForbiddenElements' => '',

            /*
            |--------------------------------------------------------------------------
            | CSS.AllowedProperties
            |--------------------------------------------------------------------------
            |
            | The Allowed CSS properties.
            |
            | http://htmlpurifier.org/live/configdoc/plain.html#CSS.AllowedProperties
            |
            */

            'CSS.AllowedProperties' => ''
                /** Typography */
                . 'font,font-size,font-weight,font-style,font-family,'
                . 'text-decoration,text-align,text-indent,text-transform,'
                . 'line-height,letter-spacing,word-spacing,white-space,'
                . 'vertical-align,color,'
                /** Backgrounds */
                . 'background-color,'
                /** Box model */
                . 'width,height,min-width,min-height,max-width,max-height,'
                . 'margin,margin-top,margin-right,margin-bottom,margin-left,'
                . 'padding,padding-top,padding-right,padding-bottom,padding-left,'
                /** Borders */
                . 'border,border-collapse,border-style,border-color,border-width,'
                . 'border-top,border-right,border-bottom,border-left,'
                /** Layout */
                . 'float,list-style-type',

            /*
            |--------------------------------------------------------------------------
            | AutoFormat.AutoParagraph
            |--------------------------------------------------------------------------
            |
            | The Allowed CSS properties.
            |
            | This directive turns on auto-paragraphing, where double
            | newlines are converted in to paragraphs whenever possible.
            |
            | http://htmlpurifier.org/live/configdoc/plain.html#AutoFormat.AutoParagraph
            |
            */

            'AutoFormat.AutoParagraph' => false,

            /*
            |--------------------------------------------------------------------------
            | AutoFormat.RemoveEmpty
            |--------------------------------------------------------------------------
            |
            | When enabled, HTML Purifier will attempt to remove empty
            | elements that contribute no semantic information to the document.
            |
            | http://htmlpurifier.org/live/configdoc/plain.html#AutoFormat.RemoveEmpty
            |
            */

            'AutoFormat.RemoveEmpty' => false,
            // 'AutoFormat.RemoveEmpty.Predicate' => ['iframe' => false],

            // To allow max-width and max-height on images. This might cause imageattacks?
            'HTML.MaxImgLength' => null,
            'CSS.MaxImgLength' => null,

            // Allow links that target blank
            'Attr.AllowedFrameTargets' => ['_blank'],

            // Allow setting IDs for anchors
            'Attr.EnableID' => true,

            // Iframes to vimeo and youtube
            // 'HTML.SafeIframe' => true,
            // 'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            'Filter.YouTube' => true,

            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp' => '%^(https?:)?//('
                . "www\.youtube(?:-nocookie)?\.com/embed/|"
                . "player\.vimeo\.com/video/|"
                . "open\.spotify\.com/embed|"
                . 'docs.google.com/|'
                . 'drive.google.com/|'
                . 'www.google.com/maps/embed|'
                . 'calendar.google.com/calendar/embed|'
                . 'snazzymaps.com/embed|'
                . 'w.soundcloud.com/player/|'
                . "www\.dndbeyond\.com/|"
                . "www\.aonprd\.com/|"
                . "2e\.aonprd\.com/|"
                . "www\.aonsrd\.com/|"
                . "p3d\.in/e/|"
                . "api\.mapbox\.com/|"
                . 'app.box.com/embed/'
                . "discord\.com/|"
                . "discord\.gg/|"
                . "bardly\.io/|"
                . "view\.genially\.com/|"
                . ')%',
        ],

        'tooltips' => [
            // <p>', '<table>', '<tr>', '<th>', '<td>', '<i>', '<span>', '<div>', '<img>
            'allowed' => [
                'a',
                'i', 'b', 'strong',
                'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
                'p', 'div', 'span',
                'table', 'tr', 'th', 'td',
                'img',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | HTMLPurifier definitions
    |--------------------------------------------------------------------------
    |
    | Here you may specify a class that augments the HTML definitions used by
    | HTMLPurifier. Additional HTML5 definitions are provided out of the box.
    | When specifying a custom class, make sure it implements the interface:
    |
    |   \Stevebauman\Purify\Definitions\Definition
    |
    | Note that these definitions are applied to every Purifier instance.
    |
    | Documentation: http://htmlpurifier.org/docs/enduser-customize.html
    |
    */

    'definitions' => App\Definitions\CustomDefinitions::class,

    'css-definitions' => App\Definitions\CustomCssDefinitions::class,

    /*
    |--------------------------------------------------------------------------
    | Serializer location
    |--------------------------------------------------------------------------
    |
    | The location where HTMLPurifier can store its temporary serializer files.
    | The filepath should be accessible and writable by the web server.
    | A good place for this is in the framework's own storage path.
    |
    */

    'serializer' => [
        'disk' => env('FILESYSTEM_DRIVER', 'local'),
        'path' => 'purify',
        'cache' => Stevebauman\Purify\Cache\FilesystemDefinitionCache::class,
    ],

    // 'serializer' => [
    //    'driver' => env('CACHE_DRIVER', 'file'),
    //    'cache' => \Stevebauman\Purify\Cache\CacheDefinitionCache::class,
    // ],

];
