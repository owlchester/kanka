# Visibilities

---

- [Concept](#concept)
- [Endpoint](#endpoint)

<a name="concept"></a>
## Concept

Most elements in Kanka that aren't [entities](/api-docs/{{version}}/entities) have a `visiblity_id` property, which indicates who can see the element.

| Integer | Code | Description |
| :- |   :-   |  :-  |
| `1` | `all` | Everyone can access this element. |
| `2` | `admin` | Only members of the campaign's admin role can access this element. |
| `3` | `admin-self` | Combination of the `admin` and `self` visibilities. |
| `4` | `self` | Only the user who created the element (`created_by`) can access this element. |
| `5` | `members` | Only members of the campaign can access this element. Useful for public campaigns. |

<a name="endpoint"></a>
### Endpoint

> {warning} Please note that all endpoints documented here need to be prefixed with `{{version}}/`. For example, if an endpoint is listed as `visibilities`, you should use `https://api.kanka.io/{{version}}/visibilities`.

To access the list of visibilities, make the following request.

| Method | URI | Headers |
| :- |   :-   |  :-  |
| GET | `visibilities` | None |

