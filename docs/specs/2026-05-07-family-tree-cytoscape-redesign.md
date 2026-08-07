# Family Tree Graph Redesign

**Date:** 2026-05-07
**Status:** Approved

## Problem

The current family tree is implemented as 9 hand-rolled Vue components that manually calculate pixel coordinates (`drawX`, `drawY`, `column`, `row`) for every node. The data structure is a deeply nested JSON tree that can only represent a single founder with partners and shared children. It cannot represent complex family graphs — e.g. a character's partner who has their own ex-spouse and children from a previous relationship. The code is full of bugs and very difficult to extend.

## Solution

Replace the nested JSON config with a flat, versioned `{ nodes, edges }` graph format. Keep the family-tree renderer as first-party Vue/DOM/SVG so each person remains a real HTML element and campaign CSS can target it with `data-*` attributes. Use a deterministic layout module rather than the old recursive width calculations.

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
      "partner_status": "current",
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
      "child_type": 1,
      "role": null,
      "colour": "",
      "cssClass": "",
      "visibility": 1
    }
  ]
}
```

**Edge types:**
- `child` — directed, drives the dagre top-down hierarchy (parent → child)
- `partner` — displayed on the same rank; `partner_status` distinguishes current and former partners

**Child types:**
- `1` — biological
- `2` — adopted
- `3` — step
- `4` — foster
- `5` — custom, requiring a role label

**Unknown people** — a node with `entity_id: null` and `isUnknown: true`, rendered as a question-mark avatar.

**Node fields:** `id` (UUID), `entity_id` (int or null), `isUnknown` (bool), `cssClass` (string), `colour` (string), `visibility` (int).

**Edge fields:** `id` (UUID), `source` (node UUID), `target` (node UUID), `type` (`partner|child`), `partner_status` (`current|former`), `child_type` (1-5), `role` (string), `colour` (string), `cssClass` (string), `visibility` (int).

---

## Component Architecture

**Replaces:** `FamilyTree.vue`, `FamilyNode.vue`, `FamilyEntity.vue`, `FamilyRelation.vue`, `FamilyRelations.vue`, `FamilyChildren.vue`, `ChildrenLine.vue`, `RelationLine.vue`, `FamilyParentChildrenLine.vue` (9 files)

**New files:**
- `resources/js/components/families/FamilyTree.vue` — main component (replaces in-place)
- `resources/js/family-tree-layout.js` — deterministic graph layout and connector geometry

The 8 supporting components are no longer registered. Layout logic moves to the pure graph layout module and connectors are rendered in SVG behind DOM cards.

### FamilyTree.vue

Responsibilities:

- On mount: fetch the API payload, calculate coordinates, and render DOM cards plus SVG connectors
- **View mode:** cards show names, dates, child-type icons, labels, and former-partner styling
- **Edit mode:** each card exposes Add Partner, Add Child, Edit, and Delete actions; connector paths edit relationship metadata
- Save: POST flat `{ nodes, edges }` to existing save endpoint

### FamilyTree modal

The main component owns a single `<dialog>` handling all edit interactions:
- Add/edit a node: character picker (tomselect), unknown toggle, colour, CSS class, visibility
- Add/edit an edge: role label, colour, visibility, type selector (partner/child)
- Reuses existing dialog patterns (`window.openDialog`, `window.closeDialog`, tomselect)

---

## Backend Changes

### FamilyTreeService

**`api()` / load:**
- Entity data format unchanged: `id, name, url, thumb, birth, death, status, tags`
- Visibility filtering operates on flat nodes and edges

**`save()`:**
- Accepts `{ version: 2, nodes: [...], edges: [...] }` instead of the old nested array
- UUID assignment is applied to both arrays while preserving edge references
- Visibility and missing-entity cleanup operate on nodes and edges instead of recursive `relations[]`

**No new routes or controller changes** — same endpoints, same auth.

---

## Layout

- Fixed-width DOM slots are calculated by `family-tree-layout.js`
- `child` edges drive rank assignment
- `partner` edges are grouped on the same rank
- SVG connectors use orthogonal child paths and horizontal partner paths
- The layout has no recursive width adjustment or branch-specific spacing hack

---

## Out of Scope

- Migration of existing saved trees — handled by `migrate:family-trees`, with `--dry-run` support
- Drag-repositioning of nodes (auto-layout only, positions not persisted)
- Non-character entities in the tree (same restriction as today)
