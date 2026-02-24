# Conversations

---

- [All Conversations](#all-conversations)
- [Conversation](#conversation)
- [Conversation Participants](#conversation-participants)
- [Conversation Messages](#conversation-messages)
- [Create a Conversation](#create-conversation)
- [Update a Conversation](#update-conversation)
- [Delete a Conversation](#delete-conversation)

<a name="all-conversations"></a>
## All Conversations

You can get a list of all the conversations of a campaign by using the following endpoint.

> {warning} Remember that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `conversations` | Default |

### URL Parameters

The list of returned entities can be filtered. The available filters are [available here](/api-docs/{{version}}/misc/filters)

### Results
```json
{
    "data": [
         {
            "id": 1,
            "name": "Bob's Tavern",
            "entry": null,
            "image": "conversations/ORn3vytRVIGkWHAAfdLqgf4xN9NHdtgjRxQbf0ef.jpeg",
            "image_full": "http://kanka.loc/storage/conversations/ORn3vytRVIGkWHAAfdLqgf4xN9NHdtgjRxQbf0ef.jpeg",
            "image_thumb": "http://kanka.loc/storage/conversations/ORn3vytRVIGkWHAAfdLqgf4xN9NHdtgjRxQbf0ef_thumb.jpeg",
            "is_closed": false,
            "is_private": false,
            "entity_id": 335,
            "tags": [],
            "created_at":  "2019-01-30T00:01:44.000000Z",
            "created_by": 1,
            "updated_at":  "2019-08-29T13:48:54.000000Z",
            "updated_by": 1,
            "type": "In Game",
            "target": "members",
            "target_id": 1,
            "participants": 3,
            "messages": 6
        }
    ]
}
```

<a name="conversation"></a>
## Conversation

To get the details of a single conversation, use the following endpoint.

| Method | URI                               | Headers |
| :- |:----------------------------------|  :-  |
| GET/HEAD | `conversations/{conversation.id}` | Default |

### Results
```json
{
    "data": {
        "id": 1,
        "name": "Bob's Tavern",
        "entry": null,
        "image": "conversations/ORn3vytRVIGkWHAAfdLqgf4xN9NHdtgjRxQbf0ef.jpeg",
        "image_full": "http://kanka.loc/storage/conversations/ORn3vytRVIGkWHAAfdLqgf4xN9NHdtgjRxQbf0ef.jpeg",
        "image_thumb": "http://kanka.loc/storage/conversations/ORn3vytRVIGkWHAAfdLqgf4xN9NHdtgjRxQbf0ef_thumb.jpeg",
        "is_closed": false,
        "is_private": false,
        "entity_id": 335,
        "tags": [],
        "created_at":  "2019-01-30T00:01:44.000000Z",
        "created_by": 1,
        "updated_at":  "2019-08-29T13:48:54.000000Z",
        "updated_by": 1,
        "type": "In Game",
        "target": "members",
        "target_id": 1,
        "participants": 3,
        "messages": 6
    }
}
```


<a name="conversation-participants"></a>
## Conversation Participants

To get the participants of an conversation, use the following endpoint.

| Method | URI                                                         | Headers |
| :- |:------------------------------------------------------------|  :-  |
| GET/HEAD | `conversations/{conversation.id}/conversation_participants` | Default |

### Results
```json
{
    "data": [
        {
            "conversation_id": 1,
            "created_by": null,
            "character_id": null,
            "user_id": 1
        },
        {
            "conversation_id": 1,
            "created_by": null,
            "character_id": null,
            "user_id": 31
        },
        {
            "conversation_id": 1,
            "created_by": null,
            "character_id": null,
            "user_id": 2
        }
    ]
}
```

> {info} Adding (`POST`), Updating (`PUT`, `PATCH`) and Deleting (`DELETE`) a participant from an conversation can also be done using the same patterns as for other endpoints.


<a name="conversation-messages"></a>
## Conversation Messages

To get the messages of an conversation, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `conversations/{conversation.id}/conversation_messages` | Default |

### Results
```json
{
    "data": [
        {
            "conversation_id": 1,
            "created_by": null,
            "character_id": 63,
            "user_id": null,
            "message": "Hey! I'm thirsty."
        },
        {
            "conversation_id": 1,
            "created_by": null,
            "character_id": null,
            "user_id": null,
            "message": "Wadayawant?"
        },
        {
            "conversation_id": 1,
            "created_by": null,
            "character_id": 70,
            "user_id": null,
            "message": "Cookies!"
        },
    ]
}
```

> {info} Adding (`POST`), Updating (`PUT`, `PATCH`) and Deleting (`DELETE`) a messages from an conversation can also be done using the same patterns as for other endpoints.


<a name="create-conversation"></a>
## Create a Conversation

To create a conversation, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `conversations` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the conversation |
| `type` | `string` | Type of conversation |
| `target_id` | `int` | Available options: 1 for `users` and 2 for `characters`  |
| `tags` | `array` | Array of tag ids |
| `is_closed` | `boolean` | If the conversation is closed |
| `entity_image_uuid` | `string` | Gallery image UUID for the entity image                                 |
| `entity_header_uuid` | `string` | Gallery image UUID for the entity header (premium campaign feature) |
| `tooltip`            | `string` | The conversation's tooltip (premium campaign feature)                   |
| `is_private` | `boolean` | If the conversation is only visible to `admin` members of the campaign |

### Results

> {success} Code 200 with JSON body of the new conversation.


<a name="update-conversation"></a>
## Update a Conversation

To update a conversation, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `conversations/{conversation.id}` | Default |

### Body

The same body parameters are available as for when creating a conversation.

### Results

> {success} Code 200 with JSON body of the updated conversation.


<a name="delete-conversation"></a>
## Delete a Conversation

To delete a conversation, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `conversations/{conversation.id}` | Default |

### Results

> {success} Code 200 with JSON.
