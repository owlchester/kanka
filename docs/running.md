# Running kanka

## Preface

Kanka is built to run on an Apache/Nginx and MariaDB stack. Community contributors have provided docker scripts to run with Kanka, but these aren't kept up to date and frequently stop working for users.

Support for Docker and Vagrant isn't provided by the Kanka core team, but you might be able to get help on the Kanka [Discord](https://discord.gg/rhsyZJ4)'s #development-talk channel.


## Docker

You can run Kanka with docker.

### Prerequisite
You need [docker](https://www.docker.com/) installed on your machine.

### Config setup

Copy the docker env file and edit it to your needs (you can leave it as is), then copy it to the root of the project dir:

```bash
cp .docker/web/variables.env .env
nano .env
chmod -R a+w public
```

Next, Edit the docker-compose.yml` file. Uncomment DB_CONNECTION,DB_DATABASE,DB_USERNAME, & DB_PASSWORD. Make sure they match the variables in `.docker/web/variables.env`

```bash
nano docker-compose.yml
```

Start the containers with the following command:

```bash
docker-compose up --build
```

Open the url <http://localhost:8001> (8001 is the port by environment variable DOCKER_WEB_PORT).

### Updates

We recommend always running from the `master` branch. You can check which branch you are on by going `git branch` in the kanka root folder on your machine (not in docker). If you want to test new features, you can use the `develop` branch, but it tends to come with bugs and errors, and potential loss of data.

When a new version of kanka is released, from your host machine you want to do `git pull` to get the newest updates. Updates usually include changes to the database, so run the following to run the migrations:

```bash
docker-composer php artisan run:migration
```



## Vagrant

Community contributors have provided vagrant scripts to run with kanka, but these aren't kept up to date and frequently stop working for users.

Todo: someone to detail how to set it up?
