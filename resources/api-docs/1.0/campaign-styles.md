# Campaign Styles

---

- [All Campaign Styles](#all-campaign-styles)
- [Single Campaign Style](#campaign-style)
- [Create a Campaign Style](#create-campaign-style)
- [Update a Campaign Style](#update-campaign-style)
- [Delete a Campaign Style](#delete-campaign-style)

<a name="all-campaign-styles"></a>
## All Campaign Styles

You can get a list of all the campaign styles of a campaign by using the following endpoint. Note that this feature is reserved to premium campaigns.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `campaign_styles` | Default |

### Results
```json
{
    "data": [
        {
            "id": 1,
            "name": "Campaign style",
            "content": "css content",
            "is_enabled": 1,
            "is_theme": 0,
            "created_by": "1",
            "created_at": "2021-09-27T11:04:31.000000Z",
            "updated_at": "2021-09-27T11:04:31.000000Z"
        }
    ]
}
```


<a name="campaign-style"></a>
## Campaign Style

To get the details of a single campaign Style, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `campaign_styles/{campaign-campaign-style.id}` | Default |

### Results
```json
{
    "data": {
        "id": 1,
        "name": "Campaign style",
        "content": "css content",
        "is_enabled": 1,
        "is_theme": 0,
        "created_by": "1",
        "created_at": "2021-09-27T11:04:31.000000Z",
        "updated_at": "2021-09-27T11:04:31.000000Z"
    }

}
```


<a name="create-campaign Style"></a>
## Create a Campaign Style

To create a campaign Style, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `campaign_styles` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | The style name |
| `content` | `string` (Required) | The css rules |
| `is_enabled` | `boolean` | If the style is enabled or not  |

### Results

> {success} Code 200 with JSON body of the new campaign Style.


<a name="update-campaign-style"></a>
## Update a Campaign Style

To update a campaign style, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `campaign_styles/{campaign-campaign-style.id}` | Default |

### Body

The same body parameters are available as for when creating a campaign Style.

### Results

> {success} Code 200 with JSON body of the updated campaign Style.


<a name="delete-campaign Style"></a>
## Delete a Campaign Style

To delete a campaign style, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `campaign_styles/{campaign-campaign-style.id}` | Default |

### Results

> {success} Code 200 with JSON.
