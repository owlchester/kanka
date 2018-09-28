# APIs

The app has RESTful APIs available to connect to.

## Authentication

Each request to the api requires an `oAuth 2.0` token to identify the user. Tokens can be generated in the user's profile page (`/en/settings/api`).

When calling the API, add the following headers:

    Authorization: Bearer user_token_here
    Accept: application/json
    
## Available APIs

### Campaigns
* GET /api/v1/campaigns
Returns a list of campaigns the authenticated user is a member of.

* STORE /api/v1/campaigns
Not yet available! To create a new campaign.

* GET /api/v1/campaigns/`campaign_id`
Returns the same data as the campaigns list.

* GET /api/v1/campaigns/`campaign_id`/users
Returns a list of users of a campaign.

### Calendars

* GET /api/v1/campaigns/`campaign_id`/calendars
Returns a list of the campaign's calendars.

* STORE /api/v1/campaigns/`campaign_id`/calendars
Create a new calendar.

* GET /api/v1/campaigns/`campaign_id`/calendars/`calendar_id`
Returns the details of a calendar.

* POST /api/v1/campaigns/`campaign_id`/calendars/`calendar_id`
Update a calendar's data.

* DELETE /api/v1/campaigns/`campaign_id`/calendars/`calendar_id`
Delete a calendar.

### Characters
Same as calendars but with `characters` instead of `calendars`.

### Dice Rolls
Same as calendars but with `dice_rolls` instead of `calendars`.

### Events
Same as calendars but with `events` instead of `calendars`.

### Families
Same as calendars but with `families` instead of `calendars`.

### Items
Same as calendars but with `items` instead of `calendars`.

### Journals
Same as calendars but with `journals` instead of `calendars`.

### Locations
Same as calendars but with `locations` instead of `calendars`.

#### Location Map Points
* GET /api/v1/campaigns/`campaign_id`/locations/`location_id`/map_points

### Organisations 
Same as calendars but with `organisations` instead of `calendars`.

#### Organisation Members 
* Get /api/v1/campaigns`campaign_id`/organisations/`organisation_id`/organisation_members

### Quest 
Same as calendars but with `quests` instead of `calendars`.

#### Quest Characters
* GET /api/v1/campaigns`campaign_id`/quest/`quest_id`/quest_characters_

#### Quest Locations
* GET /api/v1/campaigns`campaign_id`/quest/`quest_id`/quest_locations

### Sections
Same as calendars but with `sections` instead of `calendars`.

### Entity
Entities are a global concept in the app. Every character, location etc has an `entity_id` attribute that indicates the parent entity. This attribute is used to get the entity's attributes, relations etc.

#### Entity Attributes
* GET /api/v1/campaigns/`campaign_id`/entities/`entity_id`/attributes
Returns a list of the entity's attributes

* STORE /api/v1/campaigns/`campaign_id`/entities/`entity_id`/attributes
Create a new entity attribute.

* GET /api/v1/campaigns/`campaign_id`/entities/`entity_id`/attributes/`attribute_id`
Returns the details of an entity attribute.

* POST /api/v1/campaigns/`campaign_id`/entities/`entity_id`/attributes/`attribute_id`
Update an entity attribute's data.

* DELETE /api/v1/campaigns/`campaign_id`/entities/`entity_id`/attributes/`attribute_id`
Delete an entity attribute.

#### Entity Notes
Same as entity attributes but with `entity_notes` instead of `attributes`.

#### Entity Events
Same as entity attributes but with `entity_events` instead of `attributes`.

#### Entity Relations
Same as entity attributes but with `relations` instead of `attributes`.

## Search
* [Search API](search.md)