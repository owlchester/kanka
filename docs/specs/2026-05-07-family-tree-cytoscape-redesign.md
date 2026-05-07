# Family Tree Cytoscape Redesign

**Date:** 2026-05-07
**Status:** Approved

## Problem

The current family tree is implemented as 9 hand-rolled Vue components that manually calculate pixel coordinates (`drawX`, `drawY`, `column`, `row`) for every node. The data structure is a deeply nested JSON tree that can only represent a single founder with partners and shared children. It cannot represent complex family graphs — e.g. a character's partner who has their own ex-spouse and children from a previous relationship. The code is full of bugs and very difficult to extend.

## Solution

Replace the entire frontend with a Cytoscape.js-based graph renderer, following the same patterns established in `Web.vue` (the entity relations web). Replace the nested JSON config with a flat `{ nodes, edges }` graph format that Cytoscape consumes directly.

---

## Data Model

The `family_trees.config` column changes from a nested array to a flat object:

```json
{
  "nodes": [
    { "id": "uuid-1", "entity_id": 10 },
    { "id": "uuid-2", "entity_id": 20 },
    { "id": "uuid-3", "entity_id": null, "isUnknown": true }
  ],
  "edges": [
    {
      "id": "uuid-4",
      "source": "uuid-1",
      "target": "uuid-2",
      "type": "partner",
      "role": "Wife",
      "colour": "#cc0000",
      "cssClass": "",
      "visibility": 1
    },
    {
      "id": "uuid-5",
      "source": "uuid-1",
      "target": "uuid-6",
      "type": "child",
      "role": "",
      "colour": "",
      "cssClass": "",
      "visibility": 1
    }
  ]
}
```

**Edge types:**
- `child` — directed, drives the dagre top-down hierarchy (parent → child)
- `partner` — undirected, encouraged to stay at the same rank via `weight: 0`

**Unknown people** — a node with `entity_id: null` and `isUnknown: true`, rendered as a question-mark avatar.

**Node fields:** `id` (UUID), `entity_id` (int or null), `isUnknown` (bool), `cssClass` (string), `colour` (string), `visibility` (int).

**Edge fields:** `id` (UUID), `source` (node UUID), `target` (node UUID), `type` (`partner|child`), `role` (string), `colour` (string), `cssClass` (string), `visibility` (int).

---

## Component Architecture

**Replaces:** `FamilyTree.vue`, `FamilyNode.vue`, `FamilyEntity.vue`, `FamilyRelation.vue`, `FamilyRelations.vue`, `FamilyChildren.vue`, `ChildrenLine.vue`, `RelationLine.vue`, `FamilyParentChildrenLine.vue` (9 files)

**New files:**
- `resources/js/components/families/FamilyTree.vue` — main component (replaces in-place)
- `resources/js/components/families/FamilyTreeModal.vue` — single modal for all edit actions

The 8 supporting components are deleted entirely. All layout logic moves to Cytoscape/dagre.

### FamilyTree.vue

Follows the composition API + lazy import pattern from `Web.vue`. Responsibilities:

- Init Cytoscape with `cytoscape-dagre` (new dependency) and `cytoscape-panzoom` (already installed)
- On mount: fetch from the API, build Cytoscape elements, run layout
- **View mode:** nodes as circle avatars + name labels; hover shows tippy tooltip with full entity card; child edges as solid downward arrows; partner edges as dashed lines; edge role shown on hover
- **Edit mode:** activated by toolbar "Edit" button; tap node → action panel (Add Partner / Add Child / Edit / Delete); tap edge → edit/delete modal; edge-drawing mode triggered by choosing "Add partner" or "Add child" (tap source, then tap target)
- Save: POST flat `{ nodes, edges }` to existing save endpoint

### FamilyTreeModal.vue

Single `<dialog>` handling all edit interactions:
- Add/edit a node: character picker (tomselect), unknown toggle, colour, CSS class, visibility
- Add/edit an edge: role label, colour, visibility, type selector (partner/child)
- Reuses existing dialog patterns (`window.openDialog`, `window.closeDialog`, tomselect)

---

## Backend Changes

### FamilyTreeService

**`api()` / load:**
- Load **all** family members (not just top 10) and return them as staging nodes
- Also load any characters referenced by `entity_id` in the saved config that are not family members (e.g. a partner from another family) — same as the current `prepareEntities()` logic
- Merge both sets: nodes in the saved config are returned with their saved metadata; family members not yet in the config appear as unconnected staging nodes
- Entity data format unchanged: `id, name, url, thumb, birth, death, status, tags`
- Visibility filtering moves from nested relation traversal to flat edge iteration

**`save()`:**
- Accepts `{ nodes: [...], edges: [...] }` instead of the old nested array
- UUID assignment via `prepareForSave()` — same logic, just applied to both arrays
- Visibility and missing-entity cleanup operate on `edges[]` instead of recursive `relations[]`

**No new routes or controller changes** — same endpoints, same auth.

---

## Layout

- Library: `cytoscape-dagre` (new dependency, ~15kb gzipped)
- `rankDir: 'TB'` (top-to-bottom)
- `child` edges drive rank assignment
- `partner` edges use `weight: 0` to encourage same-rank placement
- Unconnected staging nodes (family members with no edges) shown as a row at the top of the canvas

---

## Out of Scope

- Migration of existing saved trees — separate task / migration command
- Drag-repositioning of nodes (auto-layout only, positions not persisted)
- Non-character entities in the tree (same restriction as today)
