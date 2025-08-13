# Attributes

---

- [All Attributes](#all-attributes)
- [Single Attribute](#attribute)
- [Create an attribute](#create-attribute)
- [Update an attribute](#update-attribute)
- [Delete an attribute](#delete-attribute)
- [Patch attributes](#patch-attributes)
- [Put attributes](#put-attributes)

<a name="all-attributes"></a>
## All Attributes

You can get a list of all the attributes of an entity by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


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
## Attribute

To get the details of a single attribute, use the following endpoint.

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
## Create an attribute

To create an attribute, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `entities/{entity.id}/attributes` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the attribute |
| `value` | `string` | The attribute's value |
| `default_order` | `integer` | The attribute's order |
| `type_id` | `int` | The attribute's type ID: `1` for standard, `2` for a multiline text block, `3` for a checkbox, `4` for a section, `5` for a random number, `6` for a number, `7` for a list choice. |
| `is_private` | `boolean` | If the attribute is only visible to `admin` members of the campaign |
| `is_pinned` | `boolean` | If the attribute is "pinned" on the entity view |
| `api_key` | `string` (max 20) | A custom field only shown in the API for you to link attributes to your system ids. |

### Results

> {success} Code 200 with JSON body of the new attribute.


<a name="update-attribute"></a>
## Update an attribute

To update an attribute, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `entities/{entity.id}/attributes/{attribute.id}` | Default |

### Body

The same body parameters are available as for when creating an attribute. The `name` field is required.

### Results

> {success} Code 200 with JSON body of the updated attribute.


<a name="delete-attribute"></a>
## Delete an attribute

To delete an attribute, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `entities/{entity.id}/attributes/{attribute.id}` | Default |

### Results

> {success} Code 200 with JSON.

<a name="patch-attributes"></a>
## Patch attributes

To PATCH attributes, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PATCH | `entities/{entity.id}/attributes` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `attribute` | `array` (Required) | Array containing attributes |
| `attribute.*.name` | `string` (Required) | Name of the attribute |
| `attribute.*.id` | `int` | The attribute's id if it exists |
| `attribute.*.value` | `string` | The attribute's value |
| `attribute.*.default_order` | `integer` | The attribute's order |
| `attribute.*.type_id` | `int` | The attribute's type ID: `1` for standard, `2` for a multiline text block, `3` for a checkbox, `4` for a section, `5` for a random number, `6` for a number, `7` for a list choice. |
| `attribute.*.is_private` | `boolean` | If the attribute is only visible to `admin` members of the campaign |
| `attribute.*.is_pinned` | `boolean` | If the attribute is "pinned" on the entity view |
| `attribute.*.api_key` | `string` (max 20) | A custom field only shown in the API for you to link attributes to your system ids. |

### Results

> {success} Code 200 with JSON body of the all of the entity's attributes.

<a name="put-attributes"></a>
## Put attributes

To PUT attributes, use the following endpoint, keep in mind that any other attributes for the corresponding entity will be deleted unless they are included on the body of the request, sending an empty PUT request will result in the deletion every attribute of the entity.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT | `entities/{entity.id}/attributes` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `attribute` | `array` (Required) | Array containing attributes |
| `attribute.*.name` | `string` (Required) | Name of the attribute |
| `attribute.*.id` | `int` | The attribute's id if it exists |
| `attribute.*.value` | `string` | The attribute's value |
| `attribute.*.default_order` | `integer` | The attribute's order |
| `attribute.*.type_id` | `int` | The attribute's type ID: `1` for standard, `2` for a multiline text block, `3` for a checkbox, `4` for a section, `5` for a random number, `6` for a number, `7` for a list choice. |
| `attribute.*.is_private` | `boolean` | If the attribute is only visible to `admin` members of the campaign |
| `attribute.*.is_pinned` | `boolean` | If the attribute is "pinned" on the entity view |
| `attribute.*.api_key` | `string` (max 20) | A custom field only shown in the API for you to link attributes to your system ids. |

### Results

> {success} Code 200 with JSON body of the all of the entity's attributes.
