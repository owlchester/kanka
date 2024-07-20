# Journals

---

- [All Journals](#all-journals)
- [Single Journal](#journal)
- [Create a Journal](#create-journal)
- [Update a Journal](#update-journal)
- [Delete a Journal](#delete-journal)

<a name="all-journals"></a>
## All Journals

You can get a list of all the journals of a campaign by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `journals` | Default |

### URL Parameters

The list of returned entities can be filtered. The available filters are [available here](/api-docs/{{version}}/filters)

### Results
```json
{
    "data": [
        {
            "id": 3,
            "name": "Session 2 - Descent into the Abyss",
            "entry": "\n<p>Lorem Ipsum</p>\n",
            "image": "{path}",
            "image_full": "{url}",
            "image_thumb": "{url}",
            "has_custom_image": false,
            "is_private": true,
            "journal_id": null,
            "entity_id": 42,
            "tags": [],
            "created_at":  "2019-01-30T00:01:44.000000Z",
            "created_by": null,
            "updated_at":  "2019-08-29T13:48:54.000000Z",
            "updated_by": 1,
            "author_id": 11,
            "date": "2017-11-02",
            "type": "Session"
        }
    ]
}
```


<a name="journal"></a>
## Journal

To get the details of a single journal, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `journals/{journal.id}` | Default |

### Results
```json
{
    "data": {
        "id": 3,
        "name": "Session 2 - Descent into the Abyss",
        "entry": "\n<p>Lorem Ipsum</p>\n",
        "image": "{path}",
        "image_full": "{url}",
        "image_thumb": "{url}",
        "has_custom_image": false,
        "is_private": true,
        "entity_id": 42,
        "journal_id": null,
        "tags": [],
        "created_at":  "2019-01-30T00:01:44.000000Z",
        "created_by": null,
        "updated_at":  "2019-08-29T13:48:54.000000Z",
        "updated_by": 1,
        "author_id": 11,
        "date": "2017-11-02",
        "type": "Session"
    }

}
```


<a name="create-journal"></a>
## Create a Journal

To create a journal, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `journals` | Default |

### Body

| Parameter | Type | Detail                                                                  |
| :- |   :-   |:------------------------------------------------------------------------|
| `name` | `string` (Required) | Name of the journal                                                     |
| `entry` | `string` | The html description of the journal                                     |
| `type` | `string` | The journal's type                                                      |
| `date` | `string` | The date of the session                                                 |
| `journal_id` | `integer` | The ID of the journal's parent journal, if it has one                   |
| `author_id` | `integer` | The "author" of the journal (entity id)                                 |
| `tags` | `array` | Array of tag ids                                                        |
| `entity_image_uuid` | `string` | Gallery image UUID for the entity image                                 |
| `entity_header_uuid` | `string` | Gallery image UUID for the entity header (limited to premium campaigns) |
| `is_private` | `boolean` | If the journal is only visible to `admin` members of the campaign       |
### Results

> {success} Code 200 with JSON body of the new journal.


<a name="update-journal"></a>
## Update a Journal

To update a journal, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `journals/{journal.id}` | Default |

### Body

The same body parameters are available as for when creating a journal.

### Results

> {success} Code 200 with JSON body of the updated journal.


<a name="delete-journal"></a>
## Delete a Journal

To delete a journal, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `journals/{journal.id}` | Default |

### Results

> {success} Code 200 with JSON.
