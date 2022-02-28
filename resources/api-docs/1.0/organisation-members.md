# Organisation Members

---

- [Organisation Members](#organisation-members)
- [Create an Organisation Member](#create-organisation-member)
- [Update an Organisation Member](#update-organisation-member)
- [Delete an Organisation Member](#delete-organisation-member)


<a name="create-organisation-member"></a>
## Create an Organisation Member

To create an organisation Member, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `organisations/{organisation.id}/organisation_members` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `organisation_id` | `integer` (required) | The organisation id |
| `character_id` | `integer` (required) | The character id organisation |
| `role` | `string` | The member's role |
| `is_private` | `boolean` | If the member is only visible to `admin` members of the campaign |
| `pin_id` | `integer` | 0, 1 if the member is pinned to the character, 2 if pinned to the org, 3 if both |
| `status_id` | `integer` | 0 for active member, 1 for past, 2 for unknown |
| `parent_id` | `integer` | parent organisation member (boss) |

### Results

> {success} Code 200 with JSON body of the new organisation.


<a name="update-organisation-member"></a>
## Update a Organisation

To update a organisation, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `organisations/{organisation.id}/organisation_members/{organisation-member.id}` | Default |

### Body

The same body parameters are available as for when creating an organisation member.

### Results

> {success} Code 200 with JSON body of the updated organisation.


<a name="delete-organisation-member"></a>
## Delete an Organisation Member

To delete an organisation member, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `/{organisation.id}/organisation_members/{organisation-member.id}` | Default |

### Results

> {success} Code 200 with JSON.
