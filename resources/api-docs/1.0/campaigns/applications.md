# Campaign Applications

---

- [Campaign Applications](#campaign-applications)
- [Campaign Application](#campaign-application)
- [Approve an Application](#approve-an-application)
- [Reject an Application](#reject-an-application)

<a name="campaign-applications"></a>
## Campaign applications

To get a list of all the current applications to a campaign, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET | `{{version}}/campaigns/{id}/applications` | Default |

### Results
```json
{
    "data": [
        {
            "id": 114,
            "user_id": 1526,
            "text": "I'm someone who plays a lone wolf rogue with a dark past",
            "created_at": "2020-11-15T10:42:38.000000Z",
            "updated_at": "2020-11-15T10:42:38.000000Z",
        },
        {
            "id": 117,
            "user_id": 5325,
            "text": "Can I join?",
            "created_at": "2020-11-15T10:42:38.000000Z",
            "updated_at": "2020-11-15T10:42:38.000000Z",
        },
        {
            "id": 118,
            "user_id": 6326,
            "text": "I'm your old mate bob, pls approve",
            "created_at": "2020-11-15T10:42:38.000000Z",
            "updated_at": "2020-11-15T10:42:38.000000Z",
        }
    ]
}
```
<a name="campaign-application"></a>
## Campaign application

To get a single application to a campaign, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET | `{{version}}/campaigns/{id}/applications/{application.id}` | Default |

### Results
```json
{
    "data": [
        {
            "id": 114,
            "user_id": 1526,
            "text": "I'm someone who plays a lone wolf rogue with a dark past",
            "created_at": "2020-11-15T10:42:38.000000Z",
            "updated_at": "2020-11-15T10:42:38.000000Z",
        },
    ]
}
```


<a name="approve-an-application"></a>
## Approve an Application

To approve an application, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `{{version}}/campaigns/{id}/applications/{application.id}/approve` | Default |

### Body

| Parameter         | Type     | Detail                   |
|:------------------|:---------|:-------------------------|
| `role_id`       | `int`    | The role to be assigned to the approved user   |
| `reason`        | `string` | Message for the user who was approved  |


### Results

> {success} Code 200 with JSON message.


<a name="reject-an-application"></a>
## Reject an Application

To reject an application, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `{{version}}/campaigns/{id}/applications/{application.id}/approve` | Default |

### Body

| Parameter         | Type     | Detail                   |
|:------------------|:---------|:-------------------------|
| `reason`        | `string` | Message for the user who was rejected  |


### Results

> {success} Code 200 with JSON message.
