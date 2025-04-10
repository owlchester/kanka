# Organisations

---

- [All Organisations](#all-organisations)

- [Single Organisation](#organisation)
- [Organisation Members](#organisation-members)
- [Create an organisation](#create-organisation)
- [Update an organisation](#update-organisation)
- [Delete an organisation](#delete-organisation)

<a name="all-organisations"></a>
## All Organisations

You can get a list of all the organisations of a campaign by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `organisations` | Default |

### URL Parameters

The list of returned entities can be filtered. The available filters are [available here](/api-docs/{{version}}/filters)

### Results
```json
{
    "data": [
        {
            "id": 1,
            "name": "Tiamat Cultists",
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
            "organisation_id": 4,
            "type": "Kingdom",
            "is_defunct": true,
            "members": [],
            "locations": [
                67,
                66,
                65
            ]
        }
    ]
}
```

<a name="organisation"></a>
## Organisation

To get the details of a single organisation, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `organisations/{organisation.id}` | Default |

### Results
```json
{
    "data": {
        "id": 1,
        "name": "Tiamat Cultists",
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
        "organisation_id": 4,
        "type": "Kingdom",
        "is_defunct": true,
        "members": [],
        "locations": [
                67,
                66,
                65
        ]
    }

}
```


<a name="organisation-members"></a>
## Organisation Members

To get the members of an organisation, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `organisations/{organisation.id}/organisation_members` | Default |

### Results
```json
{
    "data": {
        "character_id": 11,
        "created_at":  "2019-01-30T00:01:44.000000Z",
        "created_by": 1,
        "id": 6,
        "is_private": false,
        "organisation_id": 1,
        "role": "Leader",
        "pin_id": null,
        "status_id": 1,
        "updated_at":  "2019-08-29T13:48:54.000000Z",
        "updated_by": 1
    }
}
```

> {info} Adding (`POST`), Updating (`PUT`, `PATCH`) and Deleting (`DELETE`) a member from an organisation can also be done using the same patterns as for other endpoints.


<a name="create-organisation"></a>
## Create an organisation

To create an organisation, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `organisations` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the organisation |
| `entry` | `string` | The html description of the organisation |
| `type` | `string` | Type of organisation |
| `organisation_id` | `integer` | The parent organisation |
| `locations` | `array` | Array of location ids |
| `tags` | `array` | Array of tag ids |
| `is_defunct` | `boolean` | If the organisation is defunct |
| `entity_image_uuid` | `string` | Gallery image UUID for the entity image                                 |
| `entity_header_uuid` | `string` | Gallery image UUID for the entity header (premium campaign feature) |
| `tooltip`            | `string` | The ability\'s tooltip (premium campaign feature)                   |
| `is_private` | `boolean` | If the organisation is only visible to `admin` members of the campaign |

### Results

> {success} Code 200 with JSON body of the new organisation.


<a name="update-organisation"></a>
## Update an organisation

To update an organisation, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `organisations/{organisation.id}` | Default |

### Body

The same body parameters are available as for when creating an organisation.

### Results

> {success} Code 200 with JSON body of the updated organisation.


<a name="delete-organisation"></a>
## Delete an organisation

To delete an organisation, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `organisations/{organisation.id}` | Default |

### Results

> {success} Code 200 with JSON.
