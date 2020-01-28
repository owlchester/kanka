<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    |
    | The configuration settings array is passed directly to HTMLPurifier.
    |
    | Feel free to add / remove / customize these attributes as you wish.
    |
    | Documentation: http://htmlpurifier.org/live/configdoc/plain.html
    |
    */

    'settings' => [

        /*
        |--------------------------------------------------------------------------
        | Core.Encoding
        |--------------------------------------------------------------------------
        |
        | The encoding to convert input to.
        |
        | http://htmlpurifier.org/live/configdoc/plain.html#Core.Encoding
        |
        */

        'Core.Encoding' => 'utf-8',

        /*
        |--------------------------------------------------------------------------
        | Core.SerializerPath
        |--------------------------------------------------------------------------
        |
        | The HTML purifier serializer cache path.
        |
        | http://htmlpurifier.org/live/configdoc/plain.html#Cache.SerializerPath
        |
        */

        'Cache.SerializerPath' => storage_path('purify'),

        /*
        |--------------------------------------------------------------------------
        | HTML.Doctype
        |--------------------------------------------------------------------------
        |
        | Doctype to use during filtering.
        |
        | http://htmlpurifier.org/live/configdoc/plain.html#HTML.Doctype
        |
        */

        'HTML.Doctype' => 'XHTML 1.0 Transitional',

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

        'HTML.Allowed' =>
            'big,small,h1[class|style|id],h2[class|style|id],h3[class|style|id],h4[class|style|id],h5[class|style|id],h6[class|style|id],div[style],ins,del,pre,blockquote[cite],sup,sub,hr,caption,'
            . 'strong,em,b,ul[style],ol[style],li[style],p,i,br,'
            . 'img[src|style|alt|width|height|class|title],'
            . 'a[href|target|rel|title|data-toggle|data-html|id],'
            . 'p[class|style|id],span[style],'
            . 'table[class|summary|style|border|cellpadding|cellspacing],tbody,thead,tfoot,tr[class|style],td[class|style|abbr|colspan],th[class|style|abbr|colspan],'
            . 'acronym[title],abbr[title],'
            . 'iframe[src|width|height]', // only use this with HTML.SafeIframe

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

        'CSS.AllowedProperties' => 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,' .
            'color,background-color,text-align,width,border,border-collapse,max-width,max-height,' .
            'list-style-type',

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
        //'AutoFormat.RemoveEmpty.Predicate' => ['iframe' => false],

        // To allow max-width and max-height on images. This might cause imageattacks?
        'HTML.MaxImgLength'   => NULL,
        'CSS.MaxImgLength'   => NULL,

        // Allow links that target blank
        'Attr.AllowedFrameTargets' => ['_blank'],

        // Allow setting IDs for anchors
        'Attr.EnableID' => true,

        // Iframes to vimeo and youtube
        //'HTML.SafeIframe' => true,
        //'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
        'Filter.YouTube' => true,

        "HTML.SafeIframe" => true,
        "URI.SafeIframeRegexp" => "%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/|open\.spotify\.com/embed/)%",
    ],

];
