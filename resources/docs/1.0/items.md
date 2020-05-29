# Items

---

- [All Items](#all-items)
- [Single Item](#item)
- [Create a Item](#create-item)
- [Update a Item](#update-item)
- [Delete a Item](#delete-item)

<a name="all-items"></a>
## All Items

You can get a list of all the items of a campaign by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaigns/{campaign.id}/`.


| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `items` | Default |

### Results
```json
{
    "data": [
        {
            "id": 1,
            "name": "Spear",
            "entry": "\n<p>Lorem Ipsum.</p>\n",
            "image": "{path}",
            "image_full": "{url}",
            "image_thumb": "{url}",
            "has_custom_image": false,
            "is_private": true,
            "entity_id": 7,
            "tags": [],
            "created_at":  "2019-01-30T00:01:44.000000Z",
            "created_by": 1,
            "updated_at":  "2019-08-29T13:48:54.000000Z",
            "updated_by": 1,
            "location_id": 4,
            "character_id": 2,
            "type": "Weapon",
            "price": "25 gp",
            "size": "1 lb."
        }
    ]
}
```


<a name="item"></a>
## Item

To get the details of a single item, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `items/{item.id}` | Default |

### Results
```json
{
    "data": {
        "id": 1,
        "name": "Spear",
        "entry": "\n<p>Lorem Ipsum.</p>\n",
        "image": "{path}",
        "image_full": "{url}",
        "image_thumb": "{url}",
        "has_custom_image": false,
        "is_private": true,
        "entity_id": 7,
        "tags": [],
        "created_at":  "2019-01-30T00:01:44.000000Z",
        "created_by": 1,
        "updated_at":  "2019-08-29T13:48:54.000000Z",
        "updated_by": 1,
        "location_id": 4,
        "character_id": 2,
        "type": "Weapon",
        "price": "25 gp",
        "size": "1 lb."
    }
    
}
```


<a name="create-item"></a>
## Create a Item

To create a item, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| POST | `items` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the item |
| `type` | `string` | The item's type |
| `location_id` | `integer` | The item's location |
| `character_id` | `integer` | The item's owner |
| `price` | `string` | The item's price |
| `size` | `string` | The item's size |
| `tags` | `array` | Array of tag ids |
| `is_private` | `boolean` | If the item is only visible to `admin` members of the campaign |
| `image` | `stream` | Stream to file uploaded to the item |
| `image_url` | `string` | URL to a picture to be used for the item |

### Results

> {success} Code 200 with JSON body of the new item.


<a name="update-item"></a>
## Update a Item

To update a item, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `items/{item.id}` | Default |

### Body

The same body parameters are available as for when creating a item.

### Results

> {success} Code 200 with JSON body of the updated item.


<a name="delete-item"></a>
## Delete a Item

To delete a item, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| DELETE | `items/{item.id}` | Default |

### Results

> {success} Code 200 with JSON.
