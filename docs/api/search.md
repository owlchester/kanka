# API Search
A search api is made available for campaigns. It will only ever return a maximum of 10 results per request, based on what is the oldest entity.

## Fetching results
* GET /api/v1/campaigns/{campaign_id}/search/`query`
`query` is a string that will be used to look for entities with that name.

## Example
* GET /api/v1/campaigns/`campaign_id`/search/`bob`

```json
    {
        "data": [
            {
                "id": 5,
                "entity_id": 1,
                "name": "Bobba Lalla",
                "image": "http://kanka.io/storage/characters/8EucF147TsQZ2fCeT0657rSmtlzevCVmzSpCy8m9_thumb.jpeg",
                "type": "character",
                "tooltip": "Mauris a efficitur sem, maximus maximus risus. Nulla varius sodales finibus. Sed et dui ac sem efficitur dignissim. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec in accumsan massa. Nam in tellus hendrerit, consectetur augue sed,...",
                "url": "http://kanka.io/campaign/1/characters/5",
                "is_private": false,
                "created_at": {
                    "date": "2017-10-30 21:44:51.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "created_by": null,
                "updated_at": {
                    "date": "2018-09-25 14:57:53.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "updated_by": null
            }
        ]
    }
```