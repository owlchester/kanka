# Campaigns

---

- [User's Campaigns](#user-campaigns)
- [Single Campaign](#campaign)
- [Campaign Roles](#campaign-roles)

<a name="user-campaigns"></a>
## User's Campaigns

You can get a list of all the campaigns the user has access to using the following endpoint.

| Method | URI         | Headers |
| :- |:------------|  :-  |
| GET | `{{version}}/campaigns` | Default |

### Results
```json
{
    "data": [
        {
            "id": 1,
            "name": "Thaelia",
            "locale": "en",
            "entry": "\r\n<p>Aenean sit amet vehicula.</p>\r\n",
            "image": "{path}",
            "image_full": "{url}",
            "image_thumb": "{url}",
            "visibility": "public",
            "visibility_id": 2,
            "created_at": "2017-11-02T16:29:34.000000Z",
            "updated_at": "2020-05-23T22:00:02.000000Z",
            "members": [
                {
                    "id": 1,
                    "user": {
                        "id": 1,
                        "name": "Ilestis",
                        "avatar": "{url}"
                    }
                }
            ],
            "setting": [],
            "ui_settings": [],
            "default_images": [],
            "css": "..."
        }
    ],
    "links": {
        "first": "https://api.kanka.io/{{version}}/campaigns?page=1",
        "last": "https://api.kanka.io/{{version}}/campaigns?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "http://api.kanka.io/{{version}}/campaigns",
        "per_page": 15,
        "to": 3,
        "total": 3
    }
}
```

<a name="campaign"></a>
## Single Campaign

Getting a single campaign is straightforward. `{id}` is to be replaced with the campaign's id returned in the `campaigns` call.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET | `{{version}}/campaigns/{id}` | Default |

This endpoint also includes the `entry_parsed` property, which transforms `[entity:123]` mentions into `<a href="">` link elements.

### Results
```json
{
    "data": {
        "id": 1,
        "name": "Thaelia",
        "locale": "fr",
        "entry": "<p>Aenean sit amet vehicula [entity:10].</p>",
        "entry_parsed": "<p>Aenean sit amet vehicula <a href=\"...\">Lorem Ipsum</a>.</p>",
        "image": "{path}",
        "image_full": "{url}",
        "image_thumb": "{url}",
        "visibility": "public",
        "visibility_id": 2,
        "created_at": "2017-11-02T16:29:34.000000Z",
        "updated_at": "2020-05-23T22:00:02.000000Z",
        "members": [
            {
                "id": 1,
                "user": {
                    "id": 1,
                    "name": "Ilestis",
                    "avatar": "{url}"
                }
            }
        ],
        "setting": [],
        "ui_settings": [],
        "default_images": [],
        "css": "..."
    }
}
```


<a name="campaign-roles"></a>
## Campaign roles

To get a list of all the roles of a campaign, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET | `{{version}}/campaigns/{id}/roles` | Default |

### Results
```json
{
    "data": [
        {
            "id": 114,
            "name": "Admin",
            "is_admin": true
        },
        {
            "id": 115,
            "name": "Public",
            "is_admin": false
        },
        {
            "id": 116,
            "name": "Player",
            "is_admin": false
        }
    ]
}
```
