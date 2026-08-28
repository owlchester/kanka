# Player Hub

---

## Entity Details

Get the details of an entity available to the authenticated player hub claim.

| Method | URI | Headers |
| :- | :- | :- |
| GET | `player-hub/entities/{entity.id}?entity_claim_id={claim.id}` | Default |

The response includes the entity's role, entry, image, locations, families, and organisations. Locations, families, and organisations contain compact entity summaries. Interactions are collected across the claim's sessions and returned as a paginated collection inside `data.interactions`.

GM-only interactions are not returned to players. Use `data.interactions.links.next` and `data.interactions.meta` to navigate the interaction pages.
