# Tags

---

- [All Tags](#all-tags)

- [Single Tag](#tag)
- [Create a Tag](#create-tag)
- [Update a Tag](#update-tag)
- [Delete a Tag](#delete-tag)

<a name="all-tags"></a>
## All Tags

You can get a list of all the tags of a campaign by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `tags` | Default |

### URL Parameters

The list of returned entities can be filtered. The available filters are [available here](/api-docs/{{version}}/filters)

### Results
```json
{
    "data": [
        {
            "id": 1,
            "name": "Religion",
            "entry": "\n<p>Lorem Ipsum.</p>\n",
            "image": "{path}",
            "image_full": "{url}",
            "image_thumb": "{url}",
            "has_custom_image": false,
            "is_private": true,
            "entity_id": 11,
            "tags": [],
            "created_at":  "2019-01-30T00:01:44.000000Z",
            "created_by": 1,
            "updated_at":  "2019-08-29T13:48:54.000000Z",
            "updated_by": 1,
            "type": "Lore",
            "tag_id": null,
            "colour": "green",
            "entities": [
              352,
              440
            ],
            "is_auto_applied": false,
            "is_hidden": false

        }
    ]
}
```

<a name="tag"></a>
## Tag

To get the details of a single tag, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `tags/{tag.id}` | Default |

### Results
```json
{
    "data": {
        "id": 1,
        "name": "Religion",
        "entry": "\n<p>Lorem Ipsum.</p>\n",
        "image": "{path}",
        "image_full": "{url}",
        "image_thumb": "{url}",
        "has_custom_image": false,
        "is_private": true,
        "entity_id": 11,
        "tags": [],
        "created_at":  "2019-01-30T00:01:44.000000Z",
        "created_by": 1,
        "updated_at":  "2019-08-29T13:48:54.000000Z",
        "updated_by": 1,
        "type": "Lore",
        "colour": "green",
        "tag_id": null,
        "entities": [
          352, 440
        ],
        "is_auto_applied": false,
        "is_hidden": false

    }

}
```


<a name="create-tag"></a>
## Create a Tag

To create a tag, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `tags` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the tag |
| `entry` | `string` | The html description of the tag |
| `type` | `string` | The tag's type |
| `colour` | `string` | The tag's colour |
| `tag_id` | `integer` | The parent tag |
| `tags` | `array` | Array of tag ids |
| `entity_image_uuid` | `string` | Gallery image UUID for the entity image                                 |
| `entity_header_uuid` | `string` | Gallery image UUID for the entity header (premium campaign feature) |
| `tooltip`            | `string` | The ability\'s tooltip (premium campaign feature)                   |
| `is_private` | `boolean` | If the tag is only visible to `admin` members of the campaign |
| `is_auto_applied` | `boolean` | If the tag is automatically applied to new entities in the campaign |
| `is_hidden` | `boolean` | If the tag won't be displayed in an entity's header or tooltip |
### Results

> {success} Code 200 with JSON body of the new tag.


<a name="update-tag"></a>
## Update a Tag

To update a tag, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `tags/{tag.id}` | Default |

### Body

The same body parameters are available as for when creating a tag.

### Results

> {success} Code 200 with JSON body of the updated tag.


<a name="delete-tag"></a>
## Delete a Tag

To delete a tag, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `tags/{tag.id}` | Default |

### Results

> {success} Code 200 with JSON.
