# Abilities

---

- [All Abilities](#all-abilities)
- [Single Ability](#ability)
- [Create a Ability](#create-ability)
- [Update a Ability](#update-ability)
- [Delete a Ability](#delete-ability)

<a name="all-abilities"></a>
## All Abilities

You can get a list of all the abilities of a campaign by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaigns/{campaign.id}/`.


| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `abilities` | Default |

### Results
```json
{
    "data": [
        {
            "id": 1,
            "name": "Fireball",
            "entry": "\n<p>Lorem Ipsum.</p>\n",
            "image": "{path}",
            "image_full": "{url}",
            "image_thumb": "{url}",
            "has_custom_image": false,
            "is_private": true,
            "entity_id": 17,
            "tags": [],
            "created_at": "2020-03-25T13:52:42.000000Z",
            "created_by": 1,
            "updated_at": "2020-05-15T08:35:56.000000Z",
            "updated_by": 1,
            "type": "3rd level",
            "ability_id": null,
            "charges": 3,
            "abilities": []
        }
    ]
}
```


<a name="ability"></a>
## Ability

To get the details of a single ability, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `abilities/{ability.id}` | Default |

### Results
```json
{
    "data": 
    {
        "id": 1,
        "name": "Fireball",
        "entry": "\n<p>Lorem Ipsum.</p>\n",
        "image": "{path}",
        "image_full": "{url}",
        "image_thumb": "{url}",
        "has_custom_image": false,
        "is_private": true,
        "entity_id": 17,
        "tags": [],
        "created_at": "2020-03-25T13:52:42.000000Z",
        "created_by": 1,
        "updated_at": "2020-05-15T08:35:56.000000Z",
        "updated_by": 1,
        "type": "3rd level",
        "ability_id": null,
        "charges": 3,
        "abilities": []
    }

}
```


<a name="create-ability"></a>
## Create a Ability

To create a ability, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| POST | `abilities` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the ability |
| `type` | `string` | The ability's type |
| `ability_id` | `integer` | The ability's parent ability |
| `charges` | `string` | How many charges the ability has |
| `tags` | `array` | Array of tag ids |
| `is_private` | `boolean` | If the ability is only visible to `admin` members of the campaign |
| `image` | `stream` | Stream to file uploaded to the ability |
| `image_url` | `string` | URL to a picture to be used for the ability |

### Results

> {success} Code 200 with JSON body of the new ability.


<a name="update-ability"></a>
## Update a Ability

To update a ability, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `abilities/{ability.id}` | Default |

### Body

The same body parameters are available as for when creating a ability.

### Results

> {success} Code 200 with JSON body of the updated ability.


<a name="delete-ability"></a>
## Delete a Ability

To delete a ability, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| DELETE | `abilities/{ability.id}` | Default |

### Results

> {success} Code 200 with JSON.
