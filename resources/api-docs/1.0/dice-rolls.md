# Dice Rolls

- [All Dice Rolls](#all-dice-rolls)
- [Single Dice Roll](#dice-roll)
- [Create a Dice Roll](#create-dice-roll)
- [Update a Dice Roll](#update-dice-roll)
- [Delete a Dice Roll](#delete-dice-roll)

<a name="all-dice-rolls"></a>
## All Dice Rolls

You can get a list of all the dice-rolls of a campaign by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `dice_rolls` | Default |

### URL Parameters

The list of returned entities can be filtered. The available filters are [available here](/api-docs/{{version}}/filters)

### Results
```json
{
    "data": [
        {
            "id": 1,
            "name": "Super Dice",
            "entry": "\n<p>Lorem Ipsum.</p>\n",
            "image": "{path}",
            "image_full": "{url}",
            "image_thumb": "{url}",
            "is_private": false,
            "entity_id": 302,
            "tags": [],
            "created_at":  "2019-01-30T00:01:44.000000Z",
            "created_by": 1,
            "updated_at":  "2019-08-29T13:48:54.000000Z",
            "updated_by": 1,
            "character_id": 1,
            "system": "standard",
            "parameters": "2d2",
            "rolls": [
              "2",
              "4",
              "2"
            ]
        }
    ]
}
```

<a name="dice-roll"></a>
## Dice Roll

To get the details of a single dice-roll, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `dice_rolls/{dice_roll.id}` | Default |

### Results
```json
{
    "data": {
        "id": 1,
        "name": "Super Dice",
        "entry": "\n<p>Lorem Ipsum.</p>\n",
        "image": "{path}",
        "image_full": "{url}",
        "image_thumb": "{url}",
        "is_private": false,
        "entity_id": 302,
        "tags": [],
        "created_at":  "2019-01-30T00:01:44.000000Z",
        "created_by": 1,
        "updated_at":  "2019-08-29T13:48:54.000000Z",
        "updated_by": 1,
        "character_id": 1,
        "system": "standard",
        "parameters": "2d2",
        "rolls": [
          "2",
          "4",
          "2"
        ]
    }

}
```


<a name="create-dice-roll"></a>
## Create a Dice Roll

To create a dice-roll, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `dice_rolls` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the dice-roll |
| `parameters` | `string` (required) | The dice-roll's parameters (dice roll config) |
| `system` | `string` | The dice-roll's system (always standard) |
| `character_id` | `integer` | The dice-roll's owner |
| `tags` | `array` | Array of tag ids |
| `entity_image_uuid` | `string` | Gallery image UUID for the entity image                                 |
| `entity_header_uuid` | `string` | Gallery image UUID for the entity header (limited to premium campaigns) |
| `is_private` | `boolean` | If the dice-roll is only visible to `admin` members of the campaign |

### Results

> {success} Code 200 with JSON body of the new dice-roll.


<a name="update-dice-roll"></a>
## Update a Dice Roll

To update a dice-roll, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `dice_rolls/{dice_roll.id}` | Default |

### Body

The same body parameters are available as for when creating a dice-roll.

### Results

> {success} Code 200 with JSON body of the updated dice-roll.


<a name="delete-dice-roll"></a>
## Delete a Dice Roll

To delete a dice-roll, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `dice_rolls/{dice_roll.id}` | Default |

### Results

> {success} Code 200 with JSON.
