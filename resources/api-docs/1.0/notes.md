# Notes

---

- [All Notes](#all-notes)

- [Single Note](#note)
- [Create a Note](#create-note)
- [Update a Note](#update-note)
- [Delete a Note](#delete-note)

<a name="all-notes"></a>
## All Notes

You can get a list of all the notes of a campaign by using the following endpoint.

> {warning} Remember that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `notes` | Default |

### URL Parameters

The list of returned entities can be filtered. The available filters are [available here](/api-docs/{{version}}/misc/filters)

### Results
```json
{
    "data": [
        {
            "id": 1,
            "name": "Legends of the World",
            "entry": "\n<p>Lorem Ipsum.</p>\n",
            "image": "{path}",
            "image_full": "{url}",
            "image_thumb": "{url}",
            "has_custom_image": false,
            "is_private": true,
            "entity_id": 7,
            "note_id": null,
            "tags": [],
            "created_at":  "2019-01-30T00:01:44.000000Z",
            "created_by": 1,
            "updated_at":  "2019-08-29T13:48:54.000000Z",
            "updated_by": 1,
            "type": "Lore",
            "is_pinned": 0
        }
    ]
}
```


<a name="note"></a>
## Note

To get the details of a single note, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `notes/{note.id}` | Default |

### Results
```json
{
    "data": {
        "id": 1,
        "name": "Legends of the World",
        "entry": "\n<p>Lorem Ipsum.</p>\n",
        "image": "{path}",
        "image_full": "{url}",
        "image_thumb": "{url}",
        "has_custom_image": false,
        "is_private": true,
        "entity_id": 7,
        "note_id": null,
        "tags": [],
        "created_at":  "2019-01-30T00:01:44.000000Z",
        "created_by": 1,
        "updated_at":  "2019-08-29T13:48:54.000000Z",
        "updated_by": 1,
        "type": "Lore",
        "is_pinned": 0
    }

}
```


<a name="create-note"></a>
## Create a Note

To create a note, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `notes` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the note |
| `entry` | `string` | The html description of the note |
| `type` | `string` | The note's type |
| `note_id` | `integer` | The parent note id |
| `tags` | `array` | Array of tag ids |
| `entity_image_uuid` | `string` | Gallery image UUID for the entity image                                 |
| `entity_header_uuid` | `string` | Gallery image UUID for the entity header (premium campaign feature) |
| `tooltip`            | `string` | The note's tooltip (premium campaign feature)                   |
| `is_private` | `boolean` | If the note is only visible to `admin` members of the campaign |

### Results

> {success} Code 200 with JSON body of the new note.


<a name="update-note"></a>
## Update a Note

To update a note, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `notes/{note.id}` | Default |

### Body

The same body parameters are available as for when creating a note.

### Results

> {success} Code 200 with JSON body of the updated note.


<a name="delete-note"></a>
## Delete a Note

To delete a note, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `notes/{note.id}` | Default |

### Results

> {success} Code 200 with JSON.
