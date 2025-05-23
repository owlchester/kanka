# ✨ Meilisearch setup

Before importing entities to meilisearch is important to do some setup, first of all there are some .ENV
parameters to be set.

`SCOUT_DRIVER` tells scout which search engine to use, it should be set to `meilisearch`.

`SCOUT_QUEUE` tells scout if it should use the jobs queue if set to true or not if set to false/not set.

`MEILISEARCH_HOST` is the url of the meilisearch server, where the requests will be sent to, by default its set to: `http://localhost:7700` which is usually the route for a local test setup.

`MEILISEARCH_KEY` is the key/password which authorizes read/write to the meilisearch database, information on how to set it up can be found on Meilisearch's docs: `https://www.meilisearch.com/docs/learn/security/master_api_keys`.

Now we can start importing the entities.  

## Importing entities

To import all entities that are setup to work with meilisearch, run:

> sail artisan setup:meilisearch

### Individual models

To import entities from an individual model, run:

> sail artisan scout:import "App\Models\ModelName"

This has to be run for each model type we wish to import to the Meilisearch database, for example if we wish to import TimelineElements and Characters we would do:

> sail artisan scout:import "App\Models\TimelineElements"

> sail artisan scout:import "App\Models\Characters"

## Config change

It's also important to run this following command the first time meilisearch is set up and whenever any of the index settings on `config/scout.php` are modified:

> sail artisan scout:sync-index-settings

## Testing

Call the following api endpoint with a valid token

> http://api.kanka.test:8081/1.0/campaigns/xxx/fulltext-search?term=adam

