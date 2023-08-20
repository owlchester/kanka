# Entity Aliases

---

- [All Entity Aliases](#all-entity-aliases)
- [Single Entity Alias](#entity-alias)
- [Create an Entity Alias](#create-entity-alias)
- [Delete an Entity Alias](#delete-entity-alias)

<a name="all-entity-aliases"></a>
## All Entity Aliases

You can get a list of all the entity-aliases of an entity by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/entity_aliases` | Default |

### Results
```json
{
    "data": [
        {
            "created_at":  "2022-01-30T00:01:44.000000Z",
            "created_by": 1,
            "entity_id": 309,
            "id": 2,
            "visibility_id": "1",
            "name": "The BEST",
            "updated_at":  "2022-01-31T13:48:54.000000Z",
            "updated_by": null
        }
    ]
}
```


<a name="entity-alias"></a>
## Entity Alias

To get the details of a single entity-alias, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/entity_aliases/{entity_alias.id}` | Default |

### Results
```json
{
    "data": {
        "created_at":  "2022-01-30T00:01:44.000000Z",
        "created_by": 1,
        "entity_id": 309,
        "id": 2,
        "visibility_id": "1",
        "name": "The BEST",
        "updated_at":  "2022-01-31T13:48:54.000000Z",
        "updated_by": null
    }
}
```


<a name="create-entity-alias"></a>
## Create an Entity Alias

To create an entity-alias, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `entities/{entity.id}/entity_aliases` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` | The name of the alias (max 45) |
| `visibility_id` | `int` | The visibility id: 1 `all`, 2 `self`, 3 `admin`, 4 `self-admin` or 5 `members`. |

### Results

> {success} Code 200 with JSON body of the new entity-alias.


<a name="delete-entity-alias"></a>
## Delete an Entity Alias

To delete an entity-alias, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `entities/{entity.id}/entity_aliases/{entity_alias.id}` | Default |

### Results

> {success} Code 200 with JSON.
