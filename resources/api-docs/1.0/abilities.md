# Abilities

---

- [All abilities](#all-abilities)

- [Single ability](#ability)
- [Create an ability](#create-ability)
- [Update an ability](#update-ability)
- [Delete an ability](#delete-ability)

<a name="all-abilities"></a>
## All abilities

You can get a list of all the abilities of a campaign by using the following endpoint.

> {warning} Remember that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI            | Headers |
| :- |:---------------|  :-  |
| GET/HEAD | `abilities` | Default |

### URL parameters

The list of returned entities can be filtered. The available filters are [available here](/api-docs/{{version}}/filters)


### Results
```json
{
    "data": [
        {
            "id": 1,
            "name": "Fireball",
            "entry": "\n<p>Lorem Ipsum [character:123] .</p>\n",
            "entry_parsed": "\n<p>Lorem Ipsum <a href=\"...\">Adam Morley</a>.</p>\n",
            "tooltip": null,
            "type": "3rd level",
            "image": "{path}",
            "focus_x": null,
            "focus_y": null,
            "image_full": "{url}",
            "image_thumb": "{url}",
            "has_custom_image": false,
            "image_uuid": null,
            "header_uuid": null,
            "is_private": true,
            "is_template": false,
            "is_attributes_private": false,
            "entity_id": 17,
            "tags": [],
            "created_at": "2020-03-25T13:52:42.000000Z",
            "created_by": 1,
            "updated_at": "2020-05-15T08:35:56.000000Z",
            "updated_by": 1,
            "ability_id": null,
            "charges": 3,
            "abilities": []
        }
    ]
}
```


<a name="ability"></a>
## Single ability

To get the details of a single ability, use the following endpoint.

| Method | URI                         | Headers |
| :- |:----------------------------|  :-  |
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
## Create an ability

To create an ability, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `abilities` | Default |

### Body

| Parameter            | Type | Detail                                                              |
|:---------------------|   :-   |:--------------------------------------------------------------------|
| `name`               | `string` (Required) | Name of the ability                                                 |
| `entry`              | `string` | The html description of the ability                                 |
| `type`               | `string` | The ability's type                                                  |
| `ability_id`         | `integer` | The ability's parent ability                                        |
| `charges`            | `string` | How many charges the ability has                                    |
| `tags`               | `array` | Array of tag ids                                                    |
| `entity_image_uuid`  | `string` | Gallery image UUID for the entity image                             |
| `entity_header_uuid` | `string` | Gallery image UUID for the entity header (premium campaign feature) |
| `tooltip`            | `string` | The ability's tooltip (premium campaign feature)                   |
| `is_private`         | `boolean` | If the ability is only visible to `admin` members of the campaign   |

### Results

> {success} Code 200 with JSON body of the new ability.


<a name="update-ability"></a>
## Update an ability

To update an ability, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `abilities/{ability.id}` | Default |

### Body

The same body parameters are available as for when creating an ability.

### Results

> {success} Code 200 with JSON body of the updated ability.


<a name="delete-ability"></a>
## Delete an ability

To delete an ability, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `abilities/{ability.id}` | Default |

### Results

> {success} Code 200 with JSON.
