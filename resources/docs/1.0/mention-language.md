# Mention Language

When getting an entity from the API, the `parsed_entry` field will translate an entity mention to a Kanka Link. By default, the locale in the URL is always use the campaign's `locale` propery.

You can change this option by providing the following header.

> `kanka-locale`: `en-US`, `fr`, `es` or another
