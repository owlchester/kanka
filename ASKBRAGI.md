# Ask Bragi

This is the documentation for the Ask Bragi prototype, including set-up and usage.

## Set-up

Bragi uses Prism to interact with the AI provider's api, and a postgres vector db to store vectorized embeds, both of which require some ENV variables to be set.

For the vector DB:
* `VECTOR_DB_HOST` should be set to the host of the vector DB.
* `VECTOR_DB_PORT` should be set to the port of the vector DB.
* `VECTOR_DB_DATABASE` should be set to the name of the vector DB.
* `VECTOR_DB_USERNAME` should be set to a valid username with access to the vector DB.
* `VECTOR_DB_PASSWORD` should be set to the password for the username.
* Other configuration parameters can be seen in the `config/database.php` file

For Prism:
* `PRISM_SERVER_ENABLED` should be set to true to enable the Prsim middleware.
* `OPENAI_API_KEY` should be set to a valid api key for OpenAI (used on commands).
* Other configuration parameters can be seen in the `config/prism.php` file

Extra config:
* `APP_ASKBRAGI_LIMIT` controls the limit of questions you can ask Bragi each day, defaults to 100.
* `APP_ASKBRAGI_NEIGHBOURS` controls the number of neigbhouring entities fetched for each query, the higher the value is, the more data is sent to the AI, increasing the cost but also increasing the quality of the answer, 3 was the default value used when testing.
* `ASKBRAGI_SYSTEM_PROMPT` should be set to the system prompt, which sets up the behaviour of the AI, a valid example could be `"You are the lorekeeper of this campaign. You only answer questions, and answer based only on the following campaign content provided: "`

Once the configuration is set up, you need to enable AskBragi on your campaign, this is done by adding the `ask` campaign flag to it.
After enabling AskBragi on your campaign, you need to set up and enable your API key on the config page of your campaign, under "Api Keys" or `.../w/{campaign_id}/api-keys`.

Once set up, your campaign and any further modifications to valid data will be vectorized and added to the vector db, initially this might a slightly token expensive process, also, make sure the heavy queue is running.

Once the campaign is synced up with the AI you can start asking it questions on `.../w/{campaign_id}/ask`.

Keep in mind that currently Bragi doesnt keep context.
