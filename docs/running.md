# Running kanka

## Preface

Kanka is built to run on an Apache/Nginx and MariaDB stack. Community contributors have provided docker scripts to run with Kanka, but these aren't kept up to date and frequently stop working for users.

Support for Docker and Vagrant isn't provided by the Kanka core team, but you might be able to get help on the Kanka [Discord](https://discord.gg/rhsyZJ4)'s #development-talk channel.


## Docker
You can start kanka with docker. The only prerequisite is [docker](https://www.docker.com/).
Edit the docker env file to your needs, then copy it to the root of the project dir:

```bash
nano .docker/web/variables.env
cp .docker/web/variables.env .env
chmod -R a+w public
```

Next remove the following file (Fixes "Column already exists: 1060 Duplicate column name 'provider'"):

```bash
rm database/migrations/2021_02_09_214435_update_oauth_clients.php
```

Then Edit the docker-compose.yml file. Uncomment DB_CONNECTION,DB_DATABASE,DB_USERNAME, & DB_PASSWORD. Make sure they match the variables in `.docker/web/variables.env`

```bash
nano docker-compose.yml
```

Start the containers with the following command:

```bash
docker-compose up --build
```

Open the url <http://localhost:8001> (8001 is the port by environment variable DOCKER_WEB_PORT).

## Vagrant

Community contributors have provided vagrant scripts to run with kanka, but these aren't kept up to date and frequently stop working for users.

Todo: someone to detail how to set it up?
