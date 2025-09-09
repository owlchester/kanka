# Relations


- [All Relations](#all-relations)
- [Single Relation](#relation)
- [Create a relation](#create-relation)
- [Update a relation](#update-relation)
- [Delete a relation](#delete-relation)
- [All Campaign Relations](#all-campaign-relations)

> {info} In the Kanka website, the term `Connection` is used. But the API models are called `Relations`.


<a name="all-relations"></a>
## All Relations

You can get a list all the relations of an entity by using the following endpoint.

> {warning} Remember that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
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
            "attitude": 22,
            "visibility_id": 1,
            "is_pinned": false,
            "colour": null,
            "created_at":  "2019-01-30T00:01:44.000000Z",
            "created_by": 1,
            "updated_at":  "2019-08-29T13:48:54.000000Z"
        }
    ]
}
```


<a name="relation"></a>
## Relation

To get the details of a single relation, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/relations/{relation.id}` | Default |

### Results
```json
{
    "data": {
        "owner_id": 168,
        "target_id": 72,
        "relation": "Just Friends",
        "attitude": 22,
        "visibility_id": 1,
        "is_pinned": false,
        "colour": "#22bbff",
        "created_at":  "2019-01-30T00:01:44.000000Z",
        "created_by": 1,
        "updated_at":  "2019-08-29T13:48:54.000000Z"
    }
}
```


<a name="create-relation"></a>
## Create a relation

To create a relation, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `entities/{entity.id}/relations` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `relation` | `string` (Required, max 255) | Description of the relation |
| `owner_id` | `int` (Required) | The relation's entity |
| `target_id` | `int` (Required if `targets` is not set) | The relation's target entity |
| `targets` | `array` (Required if `target_id` is not set) | An array of the relation's target entities |
| `attitude` | `int` | -100 to 100 |
| `colour` | `string` | Hex colour of the attitude (with or without the `#`) |
| `two_way` | `boolean` | If set, will duplicate the relation but in the other direction |
| `is_pinned` | `boolean` | If the relation is visible on the entity's submenu |
| `visibility_id` | `int` | The visibility ID: 1 for `all`, 2 `self`, 3 `admin`, 4 `self-admin` or 5 `members`. |

### Results

> {success} Code 200 with JSON body of the new relations.


<a name="update-relation"></a>
## Update a relation

To update a relation, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `entities/{entity.id}/relations/{relation.id}` | Default |

### Body

The same body parameters are available as for when creating a relation.

### Results

> {success} Code 200 with JSON body of the updated relation.


<a name="delete-relation"></a>
## Delete a relation

To delete a relation, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `entities/{entity.id}/relations/{relation.id}` | Default |

### Results

> {success} Code 200 with JSON.


<a name="all-campaign-relations"></a>
## All Campaign Relations

You can get a list of all the relations of a campaign by using the following endpoint.


> {warning} Remember that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `relations` | Default |
