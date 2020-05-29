# Families

---

- [All Families](#all-families)
- [Single Family](#family)
- [Create a Family](#create-family)
- [Update a Family](#update-family)
- [Delete a Family](#delete-family)

<a name="all-families"></a>
## All Families

You can get a list of all the families of a campaign by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaigns/{campaign.id}/`.


| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `families` | Default |

### Results
```json
{
    "data": [
        {
            "id": 1,
            "name": "Adams",
            "entry": "\n<p>Lorem Ipsum.</p>\n",
            "image": "{path}",
            "image_full": "{url}",
            "image_thumb": "{url}",
            "has_custom_image": false,
            "is_private": true,
            "entity_id": 5,
            "tags": [],
            "created_at":  "2019-01-30T00:01:44.000000Z",
            "created_by": 1,
            "updated_at":  "2019-08-29T13:48:54.000000Z",
            "updated_by": 1,
            "location_id": 4,
            "type": "",
            "family_id": 2,
            "members": [
              "3"
            ]
        }
    ]
}
```


<a name="family"></a>
## Family

To get the details of a single family, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `families/{family.id}` | Default |

### Results
```json
{
    "data": {
        "id": 1,
        "name": "Adams",
        "entry": "\n<p>Lorem Ipsum.</p>\n",
        "image": "{path}",
        "image_full": "{url}",
        "image_thumb": "{url}",
        "has_custom_image": false,
        "is_private": true,
        "entity_id": 5,
        "tags": [],
        "created_at":  "2019-01-30T00:01:44.000000Z",
        "created_by": 1,
        "updated_at":  "2019-08-29T13:48:54.000000Z",
        "updated_by": 1,
        "location_id": 1,
        "type": "",
        "family_id": 2,
        "members": [
          "3"
        ]
    }
    
}
```

> {info} Additional note: `members` represents an array of `characters`.`id`.



<a name="create-family"></a>
## Create a Family

To create a family, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| POST | `families` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the family |
| `type` | `string` | The type of family |
| `location_id` | `integer` | The family's location id |
| `family_id` | `integer` | The parent family id |
| `tags` | `array` | Array of tag ids |
| `is_private` | `boolean` | If the family is only visible to `admin` members of the campaign |
| `image` | `stream` | Stream to file uploaded to the family |
| `image_url` | `string` | URL to a picture to be used for the family |

### Results

> {success} Code 200 with JSON body of the new family.


<a name="update-family"></a>
## Update a Family

To update a family, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `families/{family.id}` | Default |

### Body

The same body parameters are available as for when creating a family.

### Results

> {success} Code 200 with JSON body of the updated family.


<a name="delete-family"></a>
## Delete a Family

To delete a family, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| DELETE | `families/{family.id}` | Default |

### Results

> {success} Code 200 with JSON.
