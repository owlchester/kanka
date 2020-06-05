# Characters

---

- [All Characters](#all-characters)
- [Single Character](#character)
- [Create a Character](#create-character)
- [Update a Character](#update-character)
- [Delete a Character](#delete-character)

<a name="all-characters"></a>
## All Characters

You can get a list of all the characters of a campaign by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaigns/{campaign.id}/`.


| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `characters` | Default |

### Results
```json
{
    "data": [
        {
            "id": 1,
            "name": "Jonathan Green",
            "entry": "\n<p>Lorem Ipsum.</p>\n",
            "image": "{path}",
            "image_full": "{url}",
            "image_thumb": "{url}",
            "has_custom_image": false,
            "is_private": true,
            "entity_id": 4,
            "tags": [],
            "created_at": "2019-01-29T16:40:34.000000Z",
            "created_by": 1,
            "updated_at": "2019-08-29T13:38:46.000000Z",
            "updated_by": 1,
            "location_id": 4,
            "title": null,
            "age": "39",
            "sex": "Male",
            "race_id": 3,
            "type": null,
            "family_id": 34,
            "is_dead": true,
            "traits": [
                {
                    "id": 33,
                    "name": "Goals",
                    "entry": "Become a Paladin.",
                    "section": "personality",
                    "is_private": false,
                    "default_order": 0
                }
            ]
        }
    ]
}
```


<a name="character"></a>
## Character

To get the details of a single character, use the following endpoint.


| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `characters/{character.id}` | Default |

### Results
```json
{
    "data": {
        "id": 1,
        "name": "Jonathan Green",
        "entry": "\n<p>Lorem Ipsum.</p>\n",
        "image": "{path}",
        "image_full": "{url}",
        "image_thumb": "{url}",
        "has_custom_image": false,
        "is_private": true,
        "entity_id": 4,
        "tags": [],
        "created_at": "2019-01-29T16:40:34.000000Z",
        "created_by": 1,
        "updated_at": "2019-08-29T13:38:46.000000Z",
        "updated_by": 1,
        "location_id": 4,
        "title": null,
        "age": "39",
        "sex": "Male",
        "race_id": 3,
        "type": null,
        "family_id": 34,
        "is_dead": true,
        "traits": [
            {
                "id": 33,
                "name": "Goals",
                "entry": "Become a Paladin.",
                "section": "personality",
                "is_private": false,
                "default_order": 0
            }
        ]
    }
    
}
```



<a name="create-character"></a>
## Create a Character

To create a character, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| POST | `characters` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the character |
| `entry` | `string` | The html description of the character. | 
| `title` | `string`  | Title of the character |
| `age` | `string`  | Age of the character |
| `sex` | `string`  | Gender of the character |
| `type` | `string`  | Type of the character |
| `family_id` | `integer` | Family id |
| `location_id` | `integer` | Location id |
| `race_id` | `integer` | Race id |
| `tags` | `array` | Array of tag ids |
| `is_dead` | `boolean` | If the character is dead |
| `is_private` | `boolean` | If the character is only visible to `admin` members of the campaign |
| `image` | `stream` | Stream to file uploaded to the character |
| `image_url` | `string` | URL to a picture to be used for the character |
| `personality_name` | `array` | An array representing the name of personality traits. For exemple ```["Goals", "Fears"]```  |
| `personality_entry` | `array` | An array representing the values of personality traits. For exemple ```["To become a King", "Quiet places"]```  |
| `appearance_name` | `array` | An array representing the name of appearance traits. For exemple ```["Hair", "Eyes"]```  |
| `appearance_entry` | `array` | An array representing the values of appearance traits. For exemple ```["Curly black", "Light Green"]```  |

### Results

> {success} Code 200 with JSON body of the new character.


<a name="update-character"></a>
## Update a Character

To update a character, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `characters/{character.id}` | Default |

### Body

The same body parameters are available as for when creating a character.

### Results

> {success} Code 200 with JSON body of the updated character.


<a name="delete-character"></a>
## Delete a Character

To delete a character, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| DELETE | `characters/{character.id}` | Default |

### Results

> {success} Code 200 with JSON.
