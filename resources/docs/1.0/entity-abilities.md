# Entity Abilities

---

- [All Entity Abilities](#all-entity-abilities)
- [Single Entity Ability](#entity-ability)
- [Create an Entity Ability](#create-entity-ability)
- [Update an Entity Ability](#update-entity-ability)
- [Delete an Entity Ability](#delete-entity-ability)

<a name="all-entity-abilities"></a>
## All Entity Abilities

You can get a list of all the entity-abilities of an entity by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaigns/{campaign.id}/`.


| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/entity_abilities` | Default |

### Results
```json
{
    "data": [
        {
            "ability_id": 33,
            "created_at": "2019-01-28 19:42:33.000000Z",
            "created_by": 1,
            "entity_id": 70,
            "id": 31,
            "visibility": "all",
            "updated_at": "2019-01-28 19:42:33.000000Z",
            "updated_by": 1,
            "charges": 3
        }
    ]
}
```


<a name="entity-ability"></a>
## Entity Ability

To get the details of a single entity-ability, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/entity_abilities/{entity_ability.id}` | Default |

### Results
```json
{
    "data": {
        "ability_id": 33,
        "created_at": "2019-01-28 19:42:33.000000Z",
        "created_by": 1,
        "entity_id": 70,
        "id": 31,
        "visibility": "all",
        "updated_at": "2019-01-28 19:42:33.000000Z",
        "updated_by": 1,
        "charges": 3
    }
}
```


<a name="create-entity-ability"></a>
## Create an Entity Ability

To create an entity-ability, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| POST | `entities/{entity.id}/entity_abilities` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `ability_id` | `integer` (Required) | The ability id |
| `visibility` | `string` | The visibility: `all`, `self`, `admin` or `self-admin`. |
| `charges` | `integer` | How many times the ability was used. |

### Results

> {success} Code 200 with JSON body of the new entity-ability.


<a name="update-entity-ability"></a>
## Update an Entity Ability

To update an entity-ability, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `entities/{entity.id}/entity_abilities/{entity_ability.id}` | Default |

### Body

The same body parameters are available as for when creating an entity-ability.

### Results

> {success} Code 200 with JSON body of the updated entity-ability.


<a name="delete-entity-ability"></a>
## Delete an Entity Ability

To delete an entity-ability, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| DELETE | `entities/{entity.id}/entity_abilities/{entity_ability.id}` | Default |

### Results

> {success} Code 200 with JSON.
