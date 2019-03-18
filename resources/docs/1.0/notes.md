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

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaign/{campaign.id}/`.


| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `notes` | Default |

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
            "is_private": true,
            "entity_id": 7,
            "tags": [],
            "created_at": {
                "date": "2017-10-31 10:55:08.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "created_by": 1,
            "updated_at": {
                "date": "2018-09-20 09:18:58.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_by": 1,
            "type": "Lore"
        }
    ]
}
```


<a name="note"></a>
## Note

To get the details of a single note, use the following endpoint.

| Method | Endpoint| Headers |
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
        "is_private": true,
        "entity_id": 7,
        "tags": [],
        "created_at": {
            "date": "2017-10-31 10:55:08.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "created_by": 1,
        "updated_at": {
            "date": "2018-09-20 09:18:58.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "updated_by": 1,
        "type": "Lore"
    }
    
}
```


<a name="create-note"></a>
## Create a Note

To create a note, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| POST | `notes` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the note |
| `type` | `string` | The note's type |
| `tags` | `array` | Array of tag ids |
| `is_private` | `boolean` | If the note is only visible to `admin` members of the campaign |
| `image` | `stream` | Stream to file uploaded to the note |
| `image_url` | `string` | URL to a picture to be used for the note |

### Results

> {success} Code 200 with JSON body of the new note.


<a name="update-note"></a>
## Update a Note

To update a note, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `notes/{note.id}` | Default |

### Body

The same body parameters are available as for when creating a note.

### Results

> {success} Code 200 with JSON body of the updated note.


<a name="delete-note"></a>
## Delete a Note

To delete a note, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| DELETE | `notes/{note.id}` | Default |

### Results

> {success} Code 200 with JSON.
