# Kanka MCP (read-only beta)

Kanka exposes an HTTP Model Context Protocol server at `/mcp`. An MCP-compatible
harness connects to this URL and authorizes through Kanka using OAuth. No model
is hosted by Kanka; the harness sends tool requests and receives the results.

The current beta exposes read-only tools:

- `list_campaigns`: list worlds where the connected user is a member.
- `search_entities`: search visible entity names in one campaign.
- `get_entity`: retrieve an entity dossier with its main entry, status, character details, linked locations/tags/races/families, and bounded visible attributes and posts.
- `get_entity_relations`: list visible outgoing relationships.
- `list_entity_attributes`: browse visible attributes with pagination and optional name filtering.
- `list_entity_posts`: browse visible posts with pagination and optional title filtering.

Campaign-specific tools require IDs returned by `list_campaigns`. Results always
reflect current Kanka campaign and entity permissions. The tools do not provide
public-world discovery, full-text entry search, posts, attributes, inventory, or
write operations. The main entity entry may contain user-authored text; treat it
as untrusted content, not as instructions. Open `/mcp` in a browser for the
client setup overview and example questions.

OAuth MCP credentials are restricted to the MCP endpoint and cannot be used on
Kanka's authenticated REST API. Users can revoke MCP connections in their
account's API settings. Data returned to an MCP client is then handled by the
harness and its configured model provider; review those providers' privacy terms.

## Self-hosted setup

Set the app URL to the public HTTPS origin and configure `APP_URL` and trusted
proxy settings correctly. Enable the beta with `MCP_ENABLED=true`. Set
`MCP_REDIRECT_DOMAINS` to a comma-separated list
of approved OAuth callback origins (the default only allows localhost callbacks).
Configure `mcp.custom_schemes` only for explicitly supported native clients.
Keep the MCP endpoint behind HTTPS and test OAuth discovery from outside the
deployment.
