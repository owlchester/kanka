# Date Mentions Design

## Overview

Allow users to mention a specific date on a calendar in the Tiptap editor. The date is automatically formatted using the calendar's date format and links to that month in the calendar view.

## Storage Format

Uses the existing mention config syntax:

```
[calendar:1|date:1000-3-15]
```

- `calendar:1` — existing calendar mention type and ID
- `date:1000-3-15` — new config key, value is `year-month-day`

No new mention type or syntax. The existing `MentionTrait.php` config parser handles `key:value` pairs split by `|`.

## Data Flow

### Suggestion API

`MentionController` / `MentionService` includes two additional fields for calendar-type results:

- `date` — the calendar's current date string (e.g., `"1000-3-15"`)
- `months` — the calendar's months array (`[{name, length, type}]`)

These are included in the suggestion payload so no second API call is needed when the user selects a calendar.

### Frontend: Editor Flow

1. User types `@` and searches for a calendar
2. Calendar appears in the suggestion dropdown with its existing entry
3. User selects the calendar — instead of inserting immediately, `MentionList.vue` transitions to a **date step** view
4. Date step shows:
   - Year input (number, pre-filled from calendar's current `date`)
   - Month selector using the calendar's actual month names (pre-filled)
   - Day input (number, pre-filled)
5. User confirms → `command()` inserts `[calendar:id|date:Y-M-D]`
6. A "Skip / insert without date" option is also available to fall back to a plain `[calendar:id]` mention

Post-insertion editing uses the existing mention bubble menu (edit link with `?month=X&year=Y` URL params).

### Backend: Rendering

In `MentionTrait.php`, when processing a calendar mention with a `date` config key:

1. Parse `date` value into year, month, day components
2. Load the calendar's month names and date format string
3. Format the date using the calendar's format (reuse `CalendarRenderer` logic)
4. Render an `<a>` tag linking to the calendar URL with `?month=3&year=1000`
5. Link text is the formatted date (e.g., `"15 Wintermoon, 1000 AC"`)

## Affected Files

**Frontend:**
- `resources/js/editors/tiptap/extensions/mentions/MentionList.vue` — add date step view
- `resources/js/editors/tiptap/extensions/mentions/suggestion.ts` — handle calendar selection triggering date step instead of immediate insert

**Backend:**
- `app/Http/Controllers/Search/MentionController.php` or `app/Services/Search/MentionService.php` — include `date` and `months` in calendar results
- `app/Traits/MentionTrait.php` — add `date` config handler for calendar mentions
