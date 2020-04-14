<?php

return [
    'feeds' => [
        'main' => [
            'items' => 'App\Models\Release@getFeedItems',
            'url' => '/feeds/news.rss',
            'title' => 'Kanka News',
            'description' => 'News for Kanka.io',
            'language' => 'en-UK',
            'view' => 'feed::atom',
            'type' => 'application/atom+xml',
        ],
        'community-votes' => [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * 'App\Model@getAllFeedItems'
             *
             * You can also pass an argument to that method:
             * ['App\Model@getAllFeedItems', 'argument']
             */
            'items' => 'App\Models\CommunityVote@getFeedItems',

            /*
             * The feed will be available on this url.
             */
            'url' => '/feeds/community-votes.rss',

            'title' => 'Kanka Community Votes',
            'description' => 'Community votes for Kanka',
            'language' => 'en-UK',

            /*
             * The view that will render the feed.
             */
            'view' => 'feed::atom',

            /*
             * The type to be used in the <link> tag
             */
            'type' => 'application/atom+xml',
        ],
    ],
];
