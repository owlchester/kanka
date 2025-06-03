# Entity Inventory

---

- [All Entity Inventories](#all-entity-inventory)
- [Create an Entity Inventory](#create-inventory)
- [Update an Entity Inventory](#update-inventory)
- [Delete an Entity Inventory](#delete-inventory)

<a name="all-entity-inventory"></a>
## All Entity Inventories

You can get a list of all objects of an entity's inventory by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
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


<a name="create-inventory"></a>
## Create an Entity Inventory

To create an inventory, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `entities/{entity.id}/inventory` | Default |

### Body

| Parameter | Type | Detail                                           |
| :- |   :-   |:-------------------------------------------------|
| `entity_id` | `integer` (Required) | The inventory's parent entity                    |
| `item_id` | `integer` (Required without `name`) | The inventory's object id                          |
| `name` | `string` (Required without `item_id`) | The inventory's object name                        |
| `amount` | `string` (Required) | The amount of times the object is in the inventory |
| `position` | `string` | Where the object is being stored                 |
| `visiblity` | `string` | `all`, `admin`, `self` Who can view              |
| `is_equipped` | `boolean` | If the object is equipped                          |


### Results

> {success} Code 200 with JSON body of the new inventory.


<a name="update-inventory"></a>
## Update an Entity Inventory

To update an inventory, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `entities/{entity.id}/inventory/{entity.inventory.id}` | Default |

### Body

The same body parameters are available as for when creating an inventory.

### Results

> {success} Code 200 with JSON body of the updated inventory.


<a name="delete-inventory"></a>
## Delete an Entity Inventory

To delete an inventory, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `entities/{entity.id}/entity_inventory/{entity.inventory.id}` | Default |

### Results

> {success} Code 200 with JSON.
