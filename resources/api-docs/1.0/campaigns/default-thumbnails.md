# Campaign Thumbnails

---

- [All Default Thumbnails](#all-thumbnails)
- [Create a Image](#create-image)
- [Delete a Image](#delete-image)

<a name="all-thumbnails"></a>
## All Thumbnails

You can get a list of all the default thumbnails of a campaign by using the following endpoint. This is a premium campaign feature! If the campaign isn't premium, this API endpoint will result in a 404.


| Method | URI                                                      | Headers |
| :- |:---------------------------------------------------------|  :-  |
| GET/HEAD | `{{version}}/campaigns/{id}/default-thumbnails` | Default |

### Results
```json
{
    "data": [
        {
            "entity_type": "abilities",
            "url": "...logo.png",
        },
        {
            "entity_type": "gods",
            "url": "...logo.png",
        }
    ]
}
```

<a name="create-image"></a>
## Create a Default Image

To create a default image, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `default-thumbnails` | Default |

### Body

| Parameter              | Type | Detail |
|:-----------------------|   :-   |  :-  |
| `entity_type_id`       | `integer`(required) | The entity type id |
| `default_entity_image` | `file` | File uploaded |


### Results

> {success} Code 200 with JSON.

<a name="delete-image"></a>
## Delete a Default Image

To delete a default image, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `default-thumbnails` | Default |

### Body

| Parameter   | Type | Detail |
|:------------|   :-   |  :-  |
| `entity_type_id` | `integer`(required) | The entity type id |

### Results

> {success} Code 200 with JSON.
