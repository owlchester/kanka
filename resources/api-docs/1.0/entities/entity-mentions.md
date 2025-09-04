# Entity Mentions

---

- [All Entity Mentions](#all-entity-mentions)

<a name="all-entity-mentions"></a>
## All Entity Mentions

You can get a list of all the mentions of an entity by using the following endpoint.

> {warning} Remember that all endpoints documented here need to be prefixed with `{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `entities/{entity.id}/mentions` | Default |

### Results
```json
{
    "data": [
        {
            "entity_id": 10,
            "post_id": null,
            "campaign_id": null,
            "target_id": 36
        }
    ]
}
```


| Field | References |
| :- |   :-   |  :-  |
| `entity_id` | The current entity |
| `post_id` | The post id that mentions this entity |
| `campaign_id` | The campaign ID mentioning this entity. This will always be the entity's campaign ID |
| `target_id` | The entity ID that mentions this entity |

Only one of `post_id`, `campaign_id` or `target_id` will ever be filled out for a mention. If an entity is mentioned several times by another entity, only one mention object is saved.
