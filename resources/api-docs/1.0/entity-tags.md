# Entity Tags

---

- [All Entity Tags](#all-entity-tags)
- [Single Entity Tag](#entity-tag)
- [Create an Entity Tag](#create-entity-tag)
- [Update an Entity Tag](#update-entity-tag)
- [Delete an Entity Tag](#delete-entity-tag)

<a name="all-entity-tags"></a>
## All Entity Tags

You can get a list of all the entity-tags of an entity by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/entity_tags` | Default |

### Results
```json
{
    "data": [
        {
            "id": 1,
            "tag_id": 12,
        }
    ]
}
```


<a name="entity-tag"></a>
## Entity Tag

To get the details of a single entity-tag, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/entity_tags/{entity_tag.id}` | Default |

### Results
```json
{
    "data": {
        "id": 1,
        "tag_id": "12"
    }
}
```


<a name="create-entity-tag"></a>
## Create an Entity Tag

To create an entity-tag, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `entities/{entity.id}/entity_tags` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `entity_id` | `integer` (Required) | The entity-tag's parent entity |
| `tag_id` | `integer` (Required) | The entity-tag's parent tag |


### Results

> {success} Code 200 with JSON body of the new entity-tag.


<a name="update-entity-tag"></a>
## Update an Entity Tag

To update an entity-tag, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `entities/{entity.id}/entity_tags/{entity_tag.id}` | Default |

### Body

The same body parameters are available as for when creating an entity-tag.

### Results

> {success} Code 200 with JSON body of the updated entity-tag.


<a name="delete-entity-tag"></a>
## Delete an Entity Tag

To delete an entity-tag, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `entities/{entity.id}/entity_tags/{entity_tag.id}` | Default |

### Results

> {success} Code 200 with JSON.
