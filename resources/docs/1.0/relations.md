# Relations

---

- [All Relations](#all-relations)
- [Single Relation](#relation)
- [Create an relation](#create-relation)
- [Update an relation](#update-relation)
- [Delete an relation](#delete-relation)

<a name="all-relations"></a>
## All Relations

You can get a list of all the relations of an entity by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaigns/{campaign.id}/`.


| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/relations` | Default |

### Results
```json
{
    "data": [
        {
            "owner_id": 168,
            "target_id": 72,
            "relation": "Just Friends",
            "is_private": false,
            "created_at": {
                "date": "2018-04-18 12:49:16.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_at": {
                "date": "2018-04-18 12:49:16.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        }
    ]
}
```


<a name="relation"></a>
## Relation

To get the details of a single relation, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/relations/{relation.id}` | Default |

### Results
```json
{
    "data": {
        "owner_id": 168,
        "target_id": 72,
        "relation": "Just Friends",
        "is_private": false,
        "created_at": {
            "date": "2018-04-18 12:49:16.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "updated_at": {
            "date": "2018-04-18 12:49:16.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        }
    }
}
```


<a name="create-relation"></a>
## Create an relation

To create an relation, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| POST | `entities/{entity.id}/relations` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `relation` | `string` (Required, max 255) | Description of the relation |
| `owner_id` | `integer` (Required) | The relation's entity |
| `target_id` | `integer` (Required) | The relation's target entity |
| `two_way` | `boolean` | If set, will duplicate the relation but in the other direction |
| `is_private` | `boolean` | If the relation is only visible to `admin` members of the campaign |

### Results

> {success} Code 200 with JSON body of the new relation.


<a name="update-relation"></a>
## Update an relation

To update an relation, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `entities/{entity.id}/relations/{relation.id}` | Default |

### Body

The same body parameters are available as for when creating an relation.

### Results

> {success} Code 200 with JSON body of the updated relation.


<a name="delete-relation"></a>
## Delete an relation

To delete an relation, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| DELETE | `entities/{entity.id}/relations/{relation.id}` | Default |

### Results

> {success} Code 200 with JSON.
