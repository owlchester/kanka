# Templates

---

- [All Templates](#all-templates)
- [Switch a template](#switch-template)

<a name="all-templates"></a>
## All Templates

You can get a list of entities marked as templates by calling the following API endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaigns/{campaign.id}/`.


| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/templates` | Default |

### Results
```json
{
    "data": [
        {
            "id": 1,
            "entity_id": 34,
            "item_id": 12,
            "amount": 3,
            "is_equipped": false,
            "is_private": false,
            "item": {},
            "name": null,
            "position":  "hand",
            "visibility": "all"
        }
    ]
}
```


<a name="switch-template"></a>
## Switch Template

To change the template status of an entity, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| POST | `entities/template/{entity.id}/switch` | Default |

### Body

`empty`


### Results

> {success} Code 200 with JSON body of the entity.

