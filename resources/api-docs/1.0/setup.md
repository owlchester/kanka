# Setup

---

- [Before you start](#before-you-start)
- [Personal access token](#personal-access-token)
- [Quickstart](#quickstart)
- [OAuth applications](#oauth-applications)
- [Permissions and security](#permissions-and-security)
- [Endpoints](#endpoints)
- [Rate limits](#rate-limits)

<a name="before-you-start"></a>
## Before you start

You need a Kanka account and access to at least one campaign. The authenticated API uses the following base URL:

```text
https://api.kanka.io/1.0
```

All endpoint paths in this documentation are relative to that URL unless a full URL is shown.

<a name="personal-access-token"></a>
## Personal access token

Personal access tokens are the simplest option for scripts, bots, and integrations that act as your own Kanka user. Create one from [Profile > API](https://app.kanka.io/settings/api).

Tokens expire after 365 days. Never share a token with anyone, including the Kanka team. Store it in an environment variable or secrets manager rather than in source code.

Each authenticated request must include these headers:

```http
Accept: application/json
Authorization: Bearer YOUR_TOKEN
```

For requests with a JSON body, also send:

```http
Content-Type: application/json
```

`Content-Type` is not required for a bodyless `GET` request. File uploads use `multipart/form-data`; let your HTTP client generate the multipart boundary.

<a name="quickstart"></a>
## Quickstart

The following examples verify your token, find a campaign, and list its characters. Replace `YOUR_TOKEN` and `CAMPAIGN_ID` with your values.

### 1. Verify your token

```bash
export KANKA_TOKEN="YOUR_TOKEN"

curl --fail-with-body \
  "https://api.kanka.io/1.0/profile" \
  --header "Accept: application/json" \
  --header "Authorization: Bearer ${KANKA_TOKEN}"
```

A successful response contains a `data` object with your user information and your current `rate_limit`.

### 2. Find a campaign

```bash
curl --fail-with-body \
  "https://api.kanka.io/1.0/campaigns" \
  --header "Accept: application/json" \
  --header "Authorization: Bearer ${KANKA_TOKEN}"
```

Copy the `id` of a campaign from the response.

### 3. List campaign entries

```bash
curl --fail-with-body \
  "https://api.kanka.io/1.0/campaigns/CAMPAIGN_ID/characters" \
  --header "Accept: application/json" \
  --header "Authorization: Bearer ${KANKA_TOKEN}"
```

Responses are JSON and normally wrap the result in a `data` property. List endpoints also include pagination links and metadata. See [Pagination](/api-docs/{{version}}/misc/pagination).

<a name="oauth-applications"></a>
## OAuth applications

Personal access tokens are for integrations that act as one Kanka user. An OAuth application is intended for software used by multiple Kanka users, where each user authorizes access to their own campaigns.

Do not ask users to give your application their personal access tokens. Use the supported OAuth authorization flow instead. This documentation currently does not define a public OAuth authorization and callback flow, so contact the Kanka team before building a multi-user OAuth integration.

<a name="permissions-and-security"></a>
## Permissions and security

The API does not grant access beyond the authenticated user's Kanka permissions. The user must be a member of the campaign, and the user's campaign role or entity permissions must allow the requested action.

This means that a valid token can still receive a `403` response, and a resource that is not visible to the user may appear as `404` or be omitted from a list. Private entities and private properties are filtered according to Kanka's visibility rules.

Treat every token as a password:

- Never commit it to a public or private repository.
- Never include it in a URL, log message, screenshot, or client-side JavaScript bundle.
- Revoke it from [Profile > API](https://app.kanka.io/settings/api) if it is exposed.
- Use a separate token for each integration so it can be revoked independently.

Use a disposable campaign for testing. Create, update, and delete requests affect live data immediately. Recovery is available only for deleted entities and posts in eligible premium campaigns; it is not a replacement for backups.

<a name="endpoints"></a>
## Endpoints

All endpoints documented here are prefixed with `1.0/` when called against the production API. For example, `campaigns` means `https://api.kanka.io/1.0/campaigns`.

<a name="rate-limits"></a>
## Rate limits

The limit is applied per authenticated Kanka user, not per IP address or individual token. The default limit is `30` requests per minute. Subscribers receive `90` requests per minute.

The current limit is returned by the [profile endpoint](/api-docs/{{version}}/profile) as `rate_limit`. When the limit is exceeded, the API returns `429 Too Many Requests`. Clients should slow down and retry later rather than immediately retrying every request.

All tokens belonging to the same user share that user's limit.

---
Next up: [Requests and responses](/api-docs/{{version}}/misc/requests)
