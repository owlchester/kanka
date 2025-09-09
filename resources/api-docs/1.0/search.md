# Search

---

A search API is available at the following endpoint.

> {warning} Remember that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET | `search/{search_term}` | Default |

### Results

```json
    {
        "data": [
            {
                "id": 5,
                "entity_id": 1,
                "name": "Tyrion Lannister",
                "image": "{url}",
                "image_thumb": "{url}",
                "type": "character",
                "tooltip": "Lorem Ipsum",
                "url": "{url}",
                "is_private": false,
                "created_at":  "2019-01-30T00:01:44.000000Z",
                "created_by": null,
                "updated_at":  "2019-08-29T13:48:54.000000Z",
                "updated_by": null
            }
        ]
    }
```
