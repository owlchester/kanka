# Search

---

A search API is available at the following endpoint.


| Method | Endpoint| Headers |
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
                "created_at": {
                    "date": "2017-10-30 21:44:51.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "created_by": null,
                "updated_at": {
                    "date": "2018-09-25 14:57:53.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "updated_by": null
            }
        ]
    }
```