# Attributes

---

- [All Attribute Templates](#all-attribute-templates)
- [Single Attribute Template](#attribute-template)
- [Create an Attribute Template](#create-attribute-template)
- [Update an Attribute Template](#update-attribute-template)
- [Delete an Attribute Template](#delete-attribute-template)

<a name="all-attribute-templates"></a>
## All Attribute Templates

You can get a list of all the attribute templates of a campaign by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI                                  | Headers |
| :- |:-------------------------------------|  :-  |
| GET/HEAD | `attribute_templates` | Default |

### Results
```json
{
    "data": {
        "id": 3,
        "name": "Default Hero",
        "entry": null,
        "entry_parsed": null,
        "tooltip": null,
        "type": null,
        "image": null,
        "focus_x": null,
        "focus_y": null,
        "image_full": "",
        "image_thumb": "http://kanka.io/example.png",
        "has_custom_image": false,
        "image_uuid": null,
        "header_full": null,
        "header_uuid": null,
        "has_custom_header": false,
        "is_private": false,
        "is_template": false,
        "is_attributes_private": false,
        "entity_id": 1778,
        "tags": [],
        "created_at": "2025-04-10T07:20:02.000000Z",
        "created_by": 1,
        "updated_at": "2025-04-10T07:30:16.000000Z",
        "updated_by": 1,
        "urls": {
            "view": "http://kanka.io/w/1/entities/1778",
            "api": null
        },
        "entity_type_id": null,
        "attribute_template": null
    }
}
```


<a name="attribute-template"></a>
## Attribute Template

To get the details of a single attribute template, use the following endpoint.

| Method | URI                                                 | Headers |
| :- |:----------------------------------------------------|  :-  |
| GET/HEAD | `attribute_templates/{attribute_template.id}` | Default |

### Results
```json
{
    "data": {
        "id": 3,
        "name": "Default Hero",
        "entry": null,
        "entry_parsed": null,
        "tooltip": null,
        "type": null,
        "image": null,
        "focus_x": null,
        "focus_y": null,
        "image_full": "",
        "image_thumb": "http://kanka.io/example.png",
        "has_custom_image": false,
        "image_uuid": null,
        "header_full": null,
        "header_uuid": null,
        "has_custom_header": false,
        "is_private": false,
        "is_template": false,
        "is_attributes_private": false,
        "entity_id": 1778,
        "tags": [],
        "created_at": "2025-04-10T07:20:02.000000Z",
        "created_by": 1,
        "updated_at": "2025-04-10T07:30:16.000000Z",
        "updated_by": 1,
        "urls": {
            "view": "http://kanka.io/w/1/entities/1778",
            "api": null
        },
        "entity_type_id": null,
        "attribute_template": null
    }
}
```


<a name="create-attribute-template"></a>
## Create an attribute template

To create an attribute template, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `attribute_templates` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the attribute template |
| `attribute_template_id` | `integer` | The parent attribute template's id |
| `is_private` | `boolean` | If the attribute template is only visible to `admin` members of the campaign |
| `is_enabled` | `boolean` | If the attribute template is enabled on the campaign |
| `entity_type_id` | `int` | Automatically apply this template's attributes to new entities of the given type id. |

### Results

> {success} Code 200 with JSON body of the new attribute template.


<a name="update-attribute-template"></a>
## Update an attribute template

To update an attribute template, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `attribute_templates/{attribute_template.id}` | Default |

### Body

The same body parameters are available as for when creating an attribute template. The `name` field is required.

### Results

> {success} Code 200 with JSON body of the updated attribute template.


<a name="delete-attribute-template"></a>
## Delete an attribute template

To delete an attribute template, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `attribute_templates/{attribute_template.id}` | Default |

### Results

> {success} Code 200 with JSON.
