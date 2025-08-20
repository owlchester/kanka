# Posts

---

- [All Posts](#all-posts)
- [Single Post](#post)
- [Create a Post](#create-post)
- [Update a Post](#update-post)
- [Delete a Post](#delete-post)
- [Deleted Posts](#deleted-posts)
- [Recover Deleted Posts](#recover-posts)

<a name="all-posts"></a>
## All Posts

You can get a list of all the posts of an entity by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/posts` | Default |

### Results
```json
{
    "data": [
        {
            "created_at":  "2019-01-30T00:01:44.000000Z",
            "created_by": 1,
            "entity_id": 69,
            "entry": "Lorem Ipsum",
            "entry_parsed": "Lorem Ipsum",
            "id": 31,
            "position": null,
            "visibility_id": 1,
            "name": "Secret Note",
            "settings": [],
            "updated_at":  "2019-08-29T13:48:54.000000Z",
            "updated_by": null,
            "permissions": [],
            "layout_id": 3,
            "tags": [],
            "calendar_id": 102,
            "calendar_year": 2020,
            "calendar_month": 3,
            "calendar_day": 2,
            "calendar_reminder_length": 3
        }
    ]
}
```


<a name="post"></a>
## Post

To get the details of a single post, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/posts/{post.id}` | Default |

### Results
```json
{
    "data": {
        "created_at":  "2019-01-30T00:01:44.000000Z",
        "created_by": 1,
        "entity_id": 69,
        "entry": "Lorem Ipsum",
        "entry_parsed": "Lorem Ipsum",
        "id": 31,
        "position": null,
        "visibility_id": 1,
        "name": "Secret Note",
        "settings": [],
        "updated_at":  "2019-08-29T13:48:54.000000Z",
        "updated_by": null,
        "permissions": [],
        "layout_id": 3,
        "tags": [],
        "calendar_id": 102,
        "calendar_year": 2020,
        "calendar_month": 3,
        "calendar_day": 2,
        "calendar_reminder_length": 3
    }
}
```


<a name="create-post"></a>
## Create a Post

To create a post, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `entities/{entity.id}/posts` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `name` | `string` (Required) | Name of the post |
| `entry` | `string` | The post's entry (html) |
| `entity_id` | `integer` (Required) | The post's parent entity |
| `visibility_id` | `integer` | The visibility: 1 for `all`, 2 `self`, 3 `admin`, 4 `self-admin` or 5 `members`. |
| `position` | `int|null` (optional) | Position for ordering pinned posts |
| `settings` | `object` (optional) | `collapsed:1` if the pinned post should be collapsed on page load |
| `layout_id` | `integer` (optional) | The type of [Post Layout](/api-docs/{{version}}/post-layout) the post will render (Only for Premium campaigns) |
| `tags` | `array` | Array of tag ids |
| `save_tags` | `boolean` | Required to save tags |


### Results

> {success} Code 200 with JSON body of the new post.


<a name="update-post"></a>
## Update a Post

To update a post, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `entities/{entity.id}/posts/{post.id}` | Default |

### Body

The same body parameters are available as for when creating a post.

### Results

> {success} Code 200 with JSON body of the updated post.


<a name="delete-post"></a>
## Delete a Post

To delete a post, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `entities/{entity.id}/posts/{post.id}` | Default |

### Results

> {success} Code 200 with JSON.


## Permissions

Post permissions are exposed with each call. A permission typically looks like this
```json
{
    "user_id": 1,
    "role_id": null,
    "permission": 1,
    "permission-text": "update"
}
```

A permission is either attached to a `user_id` or a `role_id`, but never to both.

The permission integer is set to `0` for `Read`, `1` for `Update`, and `2` for `Deny`.

<a name="deleted-posts"></a>
## Deleted Posts

You can view the recoverable deleted posts on the `/recovery/posts` endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `/recovery/posts` | Default |

### Result

```json
{
 "data": [
        {
            "created_at": "2024-06-05T02:29:03.000000Z",
            "created_by": 1563,
            "entity_id": 193,
            "entry": null,
            "entry_parsed": "",
            "id": 4042,
            "layout_id": null,
            "name": "First Encounter",
            "permissions": [],
            "position": 1,
            "settings": {
                "collapsed": "0",
                "class": null
            },
            "updated_at": "2024-06-05T03:53:09.000000Z",
            "updated_by": 1,
            "visibility_id": 1
        }
    ],
}
```

<a name="recover-posts"></a>
## Recover Deleted Posts

You can post an array with the ids of the posts you want to recover to the `/recover/posts` endpoint to undo the deletion (this is a premium only feature).

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `/recover/posts` | Default |

| Parameter | Type | Description
| :- | :- | :- |
| `posts` | `array` | The ids of the posts to recover. |

### Result

> {success} Code 200 with JSON.
