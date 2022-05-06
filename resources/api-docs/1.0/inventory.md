# Inventory

---

- [All Inventory](#all-inventory)
- [Create an Inventory](#create-inventory)
- [Update an Inventory](#update-inventory)
- [Delete an Inventory](#delete-inventory)

<a name="all-inventory"></a>
## All Inventory

You can get a list of the inventory of an entity by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/inventories` | Default |

### Results
```json
{
    "data": [
        {
            "created_at":  "2019-01-30T00:01:44.000000Z",
            "created_by": 1,
            "entity_id": 69,
            "id": 31,
            "item_id": 5,
            "visibility_id": 1,
            "amount": "5",
            "position": "Bank",
            "updated_at":  "2019-08-29T13:48:54.000000Z",
            "updated_by": null
        }
    ]
}
```



<a name="create-inventory"></a>
## Create an Inventory

To add an item to an entity, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `entities/{entity.id}/inventories` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `item_id` | `int` (Required) | ID of the item |
| `amount` | `string` | The amount of items |
| `position` | `string` | The position of the item in the inventory|
| `entity_id` | `int` (Required) | The inventory's parent entity |
| `visibility_id` | `int` | The visibility ID: 1 for `all`, 2 `self`, 3 `admin`, 4 `self-admin` or 5 for `members`. |

### Results

> {success} Code 200 with JSON body of the new inventory.


<a name="update-inventory"></a>
## Update an Inventory

To update an inventory, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `entities/{entity.id}/inventories/{inventory.id}` | Default |

### Body

The same body parameters are available as for when creating an inventory.

### Results

> {success} Code 200 with JSON body of the updated inventory.


<a name="delete-inventory"></a>
## Delete an Inventory

To delete an inventory, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `entities/{entity.id}/inventories/{inventory.id}` | Default |

### Results

> {success} Code 200 with JSON.
