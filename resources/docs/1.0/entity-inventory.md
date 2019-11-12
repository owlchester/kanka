# Entity Tags

---

- [All Entity Tags](#all-entity-inventory)
- [Create an Entity Tag](#create-inventory)
- [Update an Entity Tag](#update-inventory)
- [Delete an Entity Tag](#delete-inventory)

<a name="all-entity-inventory"></a>
## All Entity Tags

You can get a list of all items of an entity's inventory by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaigns/{campaign.id}/`.


| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/inventory` | Default |

### Results
```json
{
    "data": [
        {
            "id": 1,
            "entity_id": 34,
            "item_id": 12,
            "amount": 3,
            "is_private": false,
            "item": {},
            "position":  "hand",
            "visibility": "all"
        }
    ]
}
```


<a name="create-inventory"></a>
## Create an Entity Inventory

To create an inventory, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| POST | `entities/{entity.id}/inventory` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `entity_id` | `integer` (Required) | The inventory's parent entity |
| `item_id` | `integer` (Required) | The inventory's item id |
| `amount` | `string` (Required) | The amount of times the item is in the inventory |
| `position` | `string` | Where the item is being stored |
| `visiblity` | `string` | `all`, `admin`, `self` Who can view |


### Results

> {success} Code 200 with JSON body of the new inventory.


<a name="update-inventory"></a>
## Update an Entity Tag

To update an inventory, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `entities/{entity.id}/inventory/{entity.inventory.id}` | Default |

### Body

The same body parameters are available as for when creating an inventory.

### Results

> {success} Code 200 with JSON body of the updated inventory.


<a name="delete-inventory"></a>
## Delete an Entity Inventory

To delete an inventory, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| DELETE | `entities/{entity.id}/entity_inventory/{entity.inventory.id}` | Default |

### Results

> {success} Code 200 with JSON.
