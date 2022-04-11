# Dashboard Widgets

---

- [All Dashboard Widgets](#all-dashboard-widgets)
- [Single Dashboard Widget](#dashboard-widget)
- [Create a Dashboard Widget](#create-dashboard-widget)
- [Update a Dashboard Widget](#update-dashboard-widget)
- [Delete a Dashboard Widget](#delete-dashboard-widget)

<a name="all-dashboard-widgets"></a>
## All Dashboard Widgets

You can get a list of all the dashboard Widgets of a campaign by using the following endpoint.

> {warning} Don't forget that all endpoints documented here need to be prefixed with `api/{{version}}/campaigns/{campaign.id}/`.


| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `campaign_dashboard_widgets` | Default |

### Results
```json
{
    "data": [
        {
            "id": 1,
            "campaign_id": 1,
            "entity_id": 6,
            "widget": "preview",
            "config": {
              "full": "1"
            },
            "width": 6,
            "position": 2,
            "tags": [],
            "created_at": "2020-06-03T11:04:31.000000Z",
            "updated_at": "2020-09-06T08:59:07.000000Z"
        }
    ]
}
```


<a name="dashboard-widget"></a>
## Dashboard Widget

To get the details of a single dashboard Widget, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET/HEAD | `campaign_dashboard_widgets/{campaign-dashboard-widget.id}` | Default |

### Results
```json
{
    "data": {
        "id": 1,
        "campaign_id": 1,
        "entity_id": 6,
        "widget": "preview",
        "config": {
          "full": "1"
        },
        "width": 6,
        "position": 2,
        "tags": [],
        "created_at": "2020-06-03T11:04:31.000000Z",
        "updated_at": "2020-09-06T08:59:07.000000Z"
    }

}
```


<a name="create-dashboard Widget"></a>
## Create a Dashboard Widget

To create a dashboard Widget, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| POST | `campaign_dashboard_widgets` | Default |

### Body

| Parameter | Type | Detail |
| :- |   :-   |  :-  |
| `widget` | `string` (Required) | The widget type: `preview`, `recent`, `random`, `calendar`, `header` or `campaign`'  |
| `entity_id` | `int` | The related entity ID (required for and calendar) |
| `config` | `object` | Config of the widget: boolean `singular`, boolean `full`, boolean `entity-header` |
| `position` | `int` | Position of the widget. If empty, placed at end |
| `tags` | `array` | Array of tag ids |
| `save_tags` | `boolean` | Required to save tags |
Widget |

### Results

> {success} Code 200 with JSON body of the new dashboard Widget.


<a name="update-dashboard-widget"></a>
## Update a Dashboard Widget

To update a dashboard widget, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| PUT/PATCH | `campaign_dashboard_widgets/{campaign-dashboard-widget.id}` | Default |

### Body

The same body parameters are available as for when creating a dashboard Widget.

### Results

> {success} Code 200 with JSON body of the updated dashboard Widget.


<a name="delete-dashboard Widget"></a>
## Delete a Dashboard Widget

To delete a dashboard widget, use the following endpoint.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| DELETE | `campaign_dashboard_widgets/{campaign-dashboard-widget.id}` | Default |

### Results

> {success} Code 200 with JSON.
