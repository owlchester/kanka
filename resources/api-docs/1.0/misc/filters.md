# Filters

The various entity endpoints like `/characters`, `/locations` etc support many filters.

To get a list of filters, first call `/filters` to get the endpoint for each [entity type](/api-docs/{{version}}/entity-types.md).

| Method | URI                   | Headers |
| :- |:----------------------|  :-  |
| GET/HEAD | `{{version}}/filters` | Default |

### Results
```json
{
    "data": [
        {
            "code": "character",
            "url": ".../filters/1"
        },
        {
            "code": "family",
            "url": ".../filters/2"
        },
    ]
}
```

## Filtering

You can add filters to multiple endpoints, to do so you can add the fields you wish to keep separated by commas under the fields key to the query, note that this feature works when viewing a single of most entity types and entities.

| Method | URI                   | Headers |
| :- |:----------------------|  :-  |
| GET/HEAD | `...entities/{entity.id}?fields=id,name,type...` | Default |

### Results
```json
{
    "data": {
        "id": 1324,
        "name": "War on a death world",
        "type": "Global conflict",
    }
}
```


## Character filters

To get a list of available filters for the characters endpoint, call the following endpoint.


| Method | URI               | Headers |
| :- |:------------------|  :-  |
| GET/HEAD | `{{version}}/filters/1` | Default |

### Results
```json
{
    "data": [
        "title",
        "age",
        "sex",
        "pronouns",
        "location_id",
        "is_dead",
        "member_id",
        "race_id",
        "family_id",
        "races",
        "name",
        "type",
        "is_private",
        "template",
        "tag_id",
        "tags",
        "has_image",
        "has_posts",
        "has_entity_files",
        "has_attributes",
        "created_by",
        "updated_by",
        "attribute_name",
        "attribute_value"
    ]
}
```
