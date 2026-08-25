# Overview

---

- [What the API is for](#what-the-api-is-for)
- [What you can build](#what-you-can-build)
- [What the API does not do](#what-the-api-does-not-do)
- [How access works](#how-access-works)
- [Key Concepts](#key-concepts)

<a name="what-the-api-is-for"></a>
## What the API is for

Kanka is a worldbuilding and RPG campaign management tool. The Kanka REST API lets you read and modify the campaign data that your Kanka user can access.

All accounts have free API access. The API is intended for integrations such as personal scripts, campaign backups, Discord bots, custom dashboards, VTT integrations, and tools that synchronize campaign data with another service.

API requests act as the authenticated Kanka user. A token does not bypass campaign membership, roles, visibility settings, or entity permissions.

<a name="what-you-can-build"></a>
## What you can build

| Capability | Availability |
|:-----------|:-------------|
| Read campaigns and campaign entries | Yes, subject to the user's access |
| Create, update, and delete campaign entries | Yes, when the user has the required permission |
| Synchronize campaign data with another tool | Yes |
| Build a personal script or bot | Yes, using a personal access token |
| Build an application for multiple Kanka users | Use OAuth only if your application has an approved OAuth flow |
| Read private campaigns or entries the user cannot access | No |

<a name="what-the-api-does-not-do"></a>
## What the API does not do

The authenticated API primarily manages campaign data. It is not a general account-management API and does not provide documented endpoints for passwords, billing, or subscription management.

The API operates on live Kanka data. There is no dry-run mode. Use a disposable campaign when testing write or delete requests. Deleted entities and posts can be recovered only for eligible premium campaigns; see [Recovery](/api-docs/{{version}}/entities/recovery).

<a name="how-access-works"></a>
## How access works

For a script or integration that runs for your own account, create a [personal access token](/api-docs/{{version}}/setup#personal-access-token). For an application that needs to be authorized by other Kanka users, see [OAuth applications](/api-docs/{{version}}/setup#oauth-applications) and confirm that your OAuth flow is supported before building against it.

Tokens are bearer credentials. Store them like passwords, never commit them to source control, and never place them in a URL or browser-side code.

<a name="key-concepts"></a>
## Key Concepts

Kanka revolves around core `entities`. Characters, locations, items, and custom campaign categories are represented as entities. An entity can also have related resources such as posts, properties, reminders, tags, and connections.

The API mostly follows REST principles. Resource-specific variations, request fields, and permissions are described on each reference page.

Start with the [Setup and quickstart](/api-docs/{{version}}/setup), then read [Requests and responses](/api-docs/{{version}}/misc/requests) before using the endpoint reference.

---
Next up: [Setup](/api-docs/{{version}}/setup)
