# Campaigns

---

- [User Campaigns](#user-campaigns)
- [Single Campaign](#campaign)
- [Campaign Members](#campaign-members)

<a name="user-campaigns"></a>
## User Campaigns

You can get a list of all the campaigns the user has access to using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/`. For example, `campaigns` becomes `kanka.io/api/{{version}}/campaigns`.


| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET | `campaigns` | Default |

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
            ]
        }
    ],
    "links": {
        "first": "https://kanka.io/api/{{version}}/campaigns?page=1",
        "last": "https://kanka.io/api/{{version}}/campaigns?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "http://kanka.io/api/{{version}}/campaigns",
        "per_page": 15,
        "to": 3,
        "total": 3
    }
}
```

<a name="campaign"></a>
## Single Campaign

Getting a single campaign is straightforward. `{id}` is to be replaced with the campaign's id returned in the `campaigns` call.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET | `campaigns/{id}` | Default |

### Results
```json
{
    "data": {
        "id": 1,
        "name": "Thaelia",
        "locale": "fr",
        "entry": "\r\n<p>Aenean sit amet vehicula.</p>\r\n",
        "image": "{path}",
        "image_full": "{url}",
        "image_thumb": "{url}",
        "visibility": "public",
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
        ]
    }
}
```

<a name="campaign-members"></a>
## Campaign Members

To get a list of all the members of a campaign, use the following endpoint.

| Method | Endpoint| Headers |
| :- |   :-   |  :-  |
| GET | `campaigns/{id}/users` | Default |

### Results
```json
{
    "data": [
        {
            "id": 1,
            "name": "Ilestis",
            "avatar": "{url}"
        } 
    ]
}
```
