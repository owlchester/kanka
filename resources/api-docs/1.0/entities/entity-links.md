# Entity Links

---

- [All Entity Links](#all-entity-links)
- [Single Entity Link](#entity-link)
- [Create an Entity Link](#create-entity-link)
- [Delete an Entity Link](#delete-entity-link)

<a name="all-entity-links"></a>
## All Entity Links

You can get a list of all the entity-links of an entity by using the following endpoint.

> {warning} Remember that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/entity_links` | Default |

### Results
```json
{
    "data": [
        {
            "created_at":  "2021-01-30T00:01:44.000000Z",
            "created_by": 1,
            "entity_id": 69,
            "id": 31,
            "visibility_id": 1,
            "name": "DNDbeyond",
            "url": "{url}",
            "icon": "",
            "position": 1,
            "updated_at":  "2021-01-31T13:48:54.000000Z",
            "updated_by": null
        }
    ]
}
```


<a name="entity-link"></a>
## Entity Link

To get the details of a single entity-link, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/entity_links/{entity_link.id}` | Default |

### Results
```json
{
    "data": {
        "created_at":  "2021-01-30T00:01:44.000000Z",
        "created_by": 1,
        "entity_id": 69,
        "id": 31,
        "visibility_id": 1,
        "name": "DNDbeyond",
        "url": "{url}",
        "icon": "",
        "position": 1,
        "updated_at":  "2021-01-31T13:48:54.000000Z",
        "updated_by": null
    }
}
```


<a name="create-entity-link"></a>
## Create an Entity Link

To create an entity-link, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `entities/{entity.id}/entity_links` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` | The name of the link |
| `icon` | `string` | The icon of the link |
| `url` | `string` | The url of the link |
| `position` | `int` | Optional position of the entity link |
| `visibility_id` | `integer` | The visibility: 1 for `all`, 2 `self`, 3 `admin`, 4 `self-admin` or 5 `members`. |

### Results

> {success} Code 200 with JSON body of the new entity-link.


<a name="delete-entity-link"></a>
## Delete an Entity Link

To delete an entity-link, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `entities/{entity.id}/entity_links/{entity_link.id}` | Default |

### Results

> {success} Code 200 with JSON.
