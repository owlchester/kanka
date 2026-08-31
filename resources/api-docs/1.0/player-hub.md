# Player Hub

---

## Entity Details

Get the details of an entity available to the authenticated player hub claim.

| Method | URI | Headers |
| :- | :- | :- |
| GET | `player-hub/entities/{entity.id}?entity_claim_id={claim.id}` | Default |

The response includes the entity's role, entry, image, and locations. Character entities also include races, families, and organisations loaded from the character child. These relationships contain compact entity summaries. Interactions are collected across the claim's sessions and returned as a paginated collection inside `data.interactions`. Each interaction includes `created_by_name` with the name of the user who created the observation.

GM-only interactions are not returned to players. Use `data.interactions.links.next` and `data.interactions.meta` to navigate the interaction pages.

## My Player Hub Entity

Get the entity linked to one of the authenticated player's active claims, including its relations and latest observations.

| Method | URI | Headers |
| :- | :- | :- |
| GET | `player-hub/me?claim_id={claim.id}` | Default |

The response includes the same entity details as the Entity Details endpoint, plus `data.relations` and up to 30 newest visible `data.observations`. Each observation includes its player session name.

## Search

Search an active claim's campaign with `GET player-hub/search?entity_claim_id={claim.id}&q={term}`. Entity results include the entity's stored `type`, module code as `entity_type`, and all linked locations as compact entity summaries.
