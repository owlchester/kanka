# Properties

---

- [All Properties](#all-attributes)
- [Single property](#attribute)
- [Create a property](#create-attribute)
- [Update a property](#update-attribute)
- [Delete a property](#delete-attribute)
- [Patch properties](#patch-attributes)
- [Put properties](#put-attributes)

<a name="all-attributes"></a>
## All properties

You can get a list all the properties of an entity by using the following endpoint.

> {warning} Remember that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI                                  | Headers |
| :- |:-------------------------------------|  :-  |
| GET/HEAD | `entities/{entity.id}/attributes` | Default |

### Results
```json
{
    "data": [
        {
            "api_key": "",
            "created_at": "2019-07-09T19:55:13.000000Z",
            "created_by": null,
            "default_order": 0,
            "entity_id": 4,
            "id": 151,
            "is_private": false,
            "is_pinned": false,
            "name": "Force Strength",
            "type_id": 1,
            "updated_at": "2020-03-11T13:31:34.000000Z",
            "updated_by": null,
            "created_by": 420,
            "updated_by": 422,
            "value": "5",
            "parsed": "5"
        }
    ]
}
```


<a name="attribute"></a>
## Property

To get the details of a single property, use the following endpoint.

| Method | URI                                                 | Headers |
| :- |:----------------------------------------------------|  :-  |
| GET/HEAD | `entities/{entity.id}/attributes/{attribute.id}` | Default |

### Results
```json
{
    "data": {
        "api_key": "",
        "created_at": "2019-07-09T19:55:13.000000Z",
        "created_by": 420,
        "default_order": 0,
        "entity_id": 4,
        "id": 151,
        "is_private": false,
        "is_pinned": false,
        "name": "Force Strength",
        "type_id": 1,
        "updated_at": "2020-03-11T13:31:34.000000Z",
        "updated_by": 420,
        "value": "5",
        "parsed": "5"
    }
}
```


<a name="create-attribute"></a>
## Create a property

To create a property, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `entities/{entity.id}/attributes` | Default |

### Body

| Parameter | Type | Detail                                                                                                                                                                             |
| :- |   :-   |:-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `name` | `string` (Required) | Name of the property                                                                                                                                                               |
| `value` | `string` | The property's value                                                                                                                                                               |
| `default_order` | `integer` | The property's order                                                                                                                                                               |
| `type_id` | `int` | The property's type ID: `1` for standard, `2` for a multiline text block, `3` for a checkbox, `4` for a section, `5` for a random number, `6` for a number, `7` for a list choice. |
| `is_private` | `boolean` | If the property is only visible to `admin` members of the campaign                                                                                                                 |
| `is_pinned` | `boolean` | If the property is "pinned" to the overview                                                                                                                                       |
| `api_key` | `string` (max 20) | A custom field only shown in the API for you to link properties to your system ids.                                                                                                |

### Results

> {success} Code 200 with JSON body of the new property.


<a name="update-attribute"></a>
## Update a property

To update a property, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `entities/{entity.id}/attributes/{attribute.id}` | Default |

### Body

The same body parameters are available as for when creating a property. The `name` field is required.

### Results

> {success} Code 200 with JSON body of the updated property.


<a name="delete-attribute"></a>
## Delete a property

To delete a property, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `entities/{entity.id}/attributes/{attribute.id}` | Default |

### Results

> {success} Code 200 with JSON.

<a name="patch-attributes"></a>
## Patch properties

To PATCH properties, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PATCH | `entities/{entity.id}/attributes` | Default |

### Body

| Parameter | Type | Detail                                                                                                                                                                             |
| :- |   :-   |:-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `attribute` | `array` (Required) | Array containing properties                                                                                                                                                        |
| `attribute.*.name` | `string` (Required) | Name of the property                                                                                                                                                               |
| `attribute.*.id` | `int` | The property's id if it exists                                                                                                                                                     |
| `attribute.*.value` | `string` | The property's value                                                                                                                                                               |
| `attribute.*.default_order` | `integer` | The property's order                                                                                                                                                               |
| `attribute.*.type_id` | `int` | The property's type ID: `1` for standard, `2` for a multiline text block, `3` for a checkbox, `4` for a section, `5` for a random number, `6` for a number, `7` for a list choice. |
| `attribute.*.is_private` | `boolean` | If the property is only visible to `admin` members of the campaign                                                                                                                 |
| `attribute.*.is_pinned` | `boolean` | If the property is "pinned" to the overview                                                                                                                                        |
| `attribute.*.api_key` | `string` (max 20) | A custom field only shown in the API for you to link properties to your system ids.                                                                                                |

### Example
```json
{
    "attribute": [
        {
            "id": 444,
            "name": "Mana potions",
            "value": 3,
            "type_id": 1
        },
        {
            "name": "Gold coins",
            "value": 10,
            "type_id": 1
        }
    ]
}
```

### Results

> {success} Code 200 with JSON body of the all of the entity's properties.

<a name="put-attributes"></a>
## Put properties

To PUT properties, use the following endpoint, keep in mind that any other properties for the corresponding entity will be deleted unless they are included on the body of the request, sending an empty PUT request will result in the deletion every properties of the entity.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT | `entities/{entity.id}/attributes` | Default |

### Body

| Parameter | Type | Detail                                                                                                                                                                              |
| :- |   :-   |:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `attribute` | `array` (Required) | Array containing properties                                                                                                                                                         |
| `attribute.*.name` | `string` (Required) | Name of the property                                                                                                                                                                |
| `attribute.*.id` | `int` | The property's id if it exists                                                                                                                                                     |
| `attribute.*.value` | `string` | The property's value                                                                                                                                                               |
| `attribute.*.default_order` | `integer` | The property's order                                                                                                                                                               |
| `attribute.*.type_id` | `int` | The property's type ID: `1` for standard, `2` for a multiline text block, `3` for a checkbox, `4` for a section, `5` for a random number, `6` for a number, `7` for a list choice. |
| `attribute.*.is_private` | `boolean` | If the property is only visible to `admin` members of the campaign                                                                                                                 |
| `attribute.*.is_pinned` | `boolean` | If the property is "pinned" on the entity view                                                                                                                                     |
| `attribute.*.api_key` | `string` (max 20) | A custom field only shown in the API for you to link properties to your system ids.                                                                                                 |

### Example
```json
{
    "attribute": [
        {
            "id": 444,
            "name": "Mana potions",
            "value": 3,
            "type_id": 1
        },
        {
            "name": "Gold coins",
            "value": 10,
            "type_id": 1,
            "is_pinned": true
        }
        
    ]
}
```

### Results

> {success} Code 200 with JSON body of the all of the entity's properties.
