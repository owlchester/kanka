# Recovery

---

- [Deleted entities](#deleted-entities)
- [Recover entities](#recover-entities)
- [Deleted posts](#deleted-posts)
- [Recover posts](#recover-posts)

Recovery is available to users who can recover content in a premium campaign. The authenticated user must also have the campaign permission required to recover deleted content.

Recovery is not a substitute for a backup. Use a disposable campaign when testing destructive API requests.

<a name="deleted-entities"></a>
## Deleted entities

List the deleted entities that can be recovered from a campaign.

| Method | URI | Headers |
| :- | :- | :- |
| GET | `campaigns/{campaign.id}/recovery` | Default |

The response is a paginated collection of entity resources. The `id` in each result is the entity ID to send to the recovery endpoint.

<a name="recover-entities"></a>
## Recover entities

Recover one or more deleted entities by sending their entity IDs in the `entities` array.

| Method | URI | Headers |
| :- | :- | :- |
| POST | `campaigns/{campaign.id}/recover` | Default |

### Body

```json
{
    "entities": [123, 456]
}
```

| Parameter | Type | Description |
| :- | :- | :- |
| `entities` | `array` (required) | Distinct entity IDs to recover |

The endpoint returns a success message when recovery is performed. On a campaign that is not eligible for recovery, it returns `204 No Content`.

<a name="deleted-posts"></a>
## Deleted posts

List the deleted posts that can be recovered from a campaign.

| Method | URI | Headers |
| :- | :- | :- |
| GET | `campaigns/{campaign.id}/recovery/posts` | Default |

The response is a paginated collection of post resources. The `id` in each result is the post ID to send to the post recovery endpoint.

<a name="recover-posts"></a>
## Recover posts

Recover one or more deleted posts by sending their post IDs in the `posts` array.

| Method | URI | Headers |
| :- | :- | :- |
| POST | `campaigns/{campaign.id}/recover/posts` | Default |

### Body

```json
{
    "posts": [789, 790]
}
```

| Parameter | Type | Description |
| :- | :- | :- |
| `posts` | `array` (required) | Distinct post IDs to recover |

The endpoint returns a success message when recovery is performed. On a campaign that is not eligible for recovery, it returns `204 No Content`.
