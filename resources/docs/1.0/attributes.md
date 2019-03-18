# Attributes

---

- [All Attributes](#all-attributes)
- [Single Attribute](#attribute)
- [Create an attribute](#create-attribute)
- [Update an attribute](#update-attribute)
- [Delete an attribute](#delete-attribute)

<a name="all-attributes"></a>
## All Attributes

You can get a list of all the attributes of an entity by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaign/{campaign.id}/`.


| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/attributes` | Default |

### Results
```json
{
    "data": [
        {
            "created_at": {
                "date": "2018-06-25 06:07:51.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "created_by": null,
            "default_order": 0,
            "entity_id": 4,
            "id": 151,
            "is_private": false,
            "name": "Force Strength",
            "type": "block",
            "updated_at": {
                "date": "2018-06-25 06:07:51.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_by": null,
            "value": "5"
        }
    ]
}
```


<a name="attribute"></a>
## Attribute

To get the details of a single attribute, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/attributes/{attribute.id}` | Default |

### Results
```json
{
    "data": {
        "created_at": {
            "date": "2018-06-25 06:07:51.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "created_by": null,
        "default_order": 0,
        "entity_id": 4,
        "id": 151,
        "is_private": false,
        "name": "Force Strength",
        "type": "block",
        "updated_at": {
            "date": "2018-06-25 06:07:51.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "updated_by": null,
        "value": "5"
    }
}
```


<a name="create-attribute"></a>
## Create an attribute

To create an attribute, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| POST | `entities/{entity.id}/attributes` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the attribute |
| `value` | `string` | The attribute's value |
| `default_order` | `string` | The attribute's order |
| `type` | `string` | The attribute's type (`block` or `checkbox`) |
| `entity_id` | `integer` (Required) | The attribute's parent entity |
| `is_private` | `boolean` | If the attribute is only visible to `admin` members of the campaign |

### Results

> {success} Code 200 with JSON body of the new attribute.


<a name="update-attribute"></a>
## Update an attribute

To update an attribute, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `entities/{entity.id}/attributes/{attribute.id}` | Default |

### Body

The same body parameters are available as for when creating an attribute.

### Results

> {success} Code 200 with JSON body of the updated attribute.


<a name="delete-attribute"></a>
## Delete an attribute

To delete an attribute, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| DELETE | `entities/{entity.id}/attributes/{attribute.id}` | Default |

### Results

> {success} Code 200 with JSON.
