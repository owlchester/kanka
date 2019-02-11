# Entities

---

- [Entities](#entities)
- [Related Entities](#related-entities)

<a name="entities"></a>
## Entities

Nearly all models in Kanka are based on the concept of entities. A character is an entity, but because of historical choices, there are two actual models.
A `character` is a singular model and endpoint, and a character has both an `id` and an `entity_id` value. The `id` identifies the character against all other **characters**, while the `entity_id` identifies the character against all other **entities**. This can be confusing at first, but should not be an issue with the help of this documentation.

> {warning} Please note that all endpoints documented here need to be prefixed with `api/{{version}}/campaigns/{id}`. For example, if an endpoint is listed as `characters`, you should use `kanka.io/api/{{version}}/campaigns/{id}/characters`.

Some common entities include:

* [Characters](/docs/{{version}}/characters)
* [Locations](/docs/{{version}}/locations)

### Common Attributes

Most entities have the following attributes.

| Attribute | Type | Description
| :- | :- | :- |
| `id` | `integer` | The id identifying the object against all other objects of the same type. |
| `name` | `string` | The name representing the object. |
| `entry` | `string` | The html description of the object. |
| `image` | `string` | The local path to the picture of the object. |
| `image_full` | `string` | The url to the picture of the object. |
| `image_thumb` | `string` | The url to the thumbnail of the object. |
| `is_private` | `boolean` | Determines if the object is only visible by `admin` members of the campaign.<br /> If the user requesting the API isn't a member of the `admin` role, such objects won't be returned. |
| `entity_id` | `integer` | The id identifying the objects against all other entities.
| `tags` | `array` | An array of tags that the object is related to. |
| `created_at` | `object` | An object representing when the object was created (server time) |
| `created_by` | `integer` | The `users`.`id` who created the object.
| `updated_at` | `object` | An object representing when the object was updated (server time) |
| `updated_by` | `integer` | The `users`.`id` who last updated the object.

<a name="related-entities"></a>
## Related Entities

There are several models in Kanka which represent objects attached to `entities`.

* [Attributes](/docs/{{version}}/attributes)
* [Entity Events](/docs/{{version}}/entity-events)
* [Entity Files](/docs/{{version}}/entity-files)
* [Entity Mentions](/docs/{{version}}/entity-mentions)
* [Entity Notes](/docs/{{version}}/entity-notes)
* [Entity Tags](/docs/{{version}}/entity-tags)
* [Entity Relations](/docs/{{version}}/entity-relations)