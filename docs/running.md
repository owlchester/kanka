# Running kanka

## Preface

Kanka is built to run on an Nginx and MariaDB stack with the help of Docker. If you have troubles or issues, contact us on the Kanka [Discord](https://discord.gg/rhsyZJ4) #development-talk channel.

> :warning: **Warning**
>
> This docker setup is meant for developers working on Kanka. **Do not use** this docker setup to host Kanka on the web! It come with 0 security (no root password and all ports open). It is also slower than the normal Kanka as it doesn't include any performance improvements and advanced caching.
>
> This setup works as is for our team running with Docker on Linux and MacOS. We only provide limited support for helping people host Kanka locally on Discord from Monday to Friday 9am-4pm (GMT-5).


## Docker

Kanka is setup to run with Docket and [Laravel Sail](https://laravel.com/10.x/sail). It comes with four machines.
* Kanka for running the Kanka PHP application
* Mariadb for the database
* Redis for the cache
* Minio for file storage

### Prerequisite
You need [docker](https://www.docker.com/) installed on your machine.

This Github repository needs to be installed (`git clone`) on your local machine. All commands are to be executed in the kanka folder.

When on Linux, Docker needs to run with your user and not with sudo! This is important for file permissions to properly work. To setup docker to run with your user, [follow these instructions](https://docs.docker.com/engine/install/linux-postinstall/).

### Set up your config

The first step is to copy `.env.example` to `.env`. This will set up Kanka's default config to run with docker.

> **Hidden by default**
>
> Most operating systems hide files starting with a dot by default. You can either change this in your operating system's file explorer, or by accessing the files in the terminal.

Optionally, if you want to change some configs, edit the new `.env` file. In most cases, you don't need to touch anything.

### Installing dependencies

Run the following command to install all the depenencies to run Kanka needs to run. This command will start up a small docker to install everthing through [composer](https://getcomposer.org).

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

#### Easier life

To make your life easier, we recommend setting an alias to the `sail` command.
```bash
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

Otherwise, whenever this setup mentions a sail command, replace it with `./vendor/bin/sail`.

### Running Kanka

Everything should now be ready to run all those docker images. Passing the `-d` parameter starts it in the background.

```bash
sail up -d
```

#### Bucket setup

Image uploading in the app is stored on a *minio* service. This mimics the amazon S3 storage, and makes it easier to handle images rather than hosting them directly in the docker responsible for PHP.

First, go to [localhost:9000](http://localhost:9000). This is where your files will be stored. Login with `sail` as the user and `password` as the password.

Create a new bucket called `kanka`. This will redirect you to the new `kanka` bucket. Click on the top right cogwheel icon to access the bucket's config interface. On this page, change the `Access Policy` from `private` to `public`. Without this, uploaded file won't be visible in the browser.

Next up, create a second bucket called `thumbnails`. Same as before, go back and set it's `Access Policy` from `private` to `public`. This bucket will contain your thumbnails.

#### Database setup

Now that the bucket is set up, go back to your console run the following commands. The first will set up your security key used to encode session cookies.

```bash
sail artisan key:generate
```

Next is creating the whole database. This database is persistant and survives each time the docker image is restarted.

```bash
sail artisan migrate
```

Next up is setting up the application boilerplates.

```bash
sail artisan db:seed
```

Last optional command is to allow your local env to generate API tokens.

```bash
sail artisan passport:install
```

### Testing

You're now ready to test your app. Navigate to (localhost:8081)[http://localhost:8081] and you should see the Kanka application.

We recommend making an alias in your `/etc/hosts` file to point `kanka.test` to your localhost, so what (kanka.test:8081)[http://kanka.test:8081] also works.


### Shutting down

To stop the docker images, run the following command from your Kanka folder.

```bash
sail down
```

## Debugging

If you're having issues with your local instance, these two methods are your best bet.

### Debug mode

If you're having 500 errors on (localhost:8081)[http://localhost:8081], try the following.

Enable debug mode by editing the `.env` file and replacing `APP_DEBUG=false` with `APP_DEBUG=true`. This will now show the error in the browser.

### Error logs

If you want access to the detailed error logs, execute the following commands.

```bash
sail shell
tail -f storage/logs/laravel.log
```

## Sharing your local Kanka

Do not make your Kanka instance accessible to the web! To share your Kanka instance with your friends, use the `sail share` command. Follow the [official documentation](https://laravel.com/docs/10.x/sail#sharing-your-site), or set up a reverse proxy in front of it.

## Differences compared to kanka.io

These developer docker instances are quite different from [kanka.io](https://kanka.io/en-US) that we've listed below.

* No security, no backups
* No support for premium campaigns and subscriber bonuses
* No advanced caching, meaning that as the data grows, the app will become much slower
* No image server that creates thumbnails, meaning the images you uploaded are used by default
* No third-party setup like discord, google/meta/twitter logins, stripe, or analytics
* No emails and no campaign exports are generated
* No access to the third party tools Kanka pays for like FontAwesome PRO, meaning some icons in the app won't work
* And lastly, **limited support from the Kanka team to debug your local setup**

## Updating

We recommend always running from a release tag rather than the `main` branch. You can check which branch you are on by going `git branch` in the kanka root folder on your machine (not in docker).

When a new version of kanka is released, from your host machine you want to do `git pull` to get the newest updates. Updates usually include changes to the database, so run the following to run the migrations:

When updating your local installation, we recommend checkout out each tag chronologically in order to safely update your data.

> :warning: **Warning**
> Never ever checkout the `@develop` branch as it is unstable and will break your installation.

### Backup

We **strongly** recommend backing up your database data before running any upgrade. You can create a backup of your data by running the following command. Note that this backup command is only available from version 1.44 and onward.

```bash
sail artisan backup:run
```

This will create a gzip file in `storage/app/{app_name}/{date}.zip`

### Checkout out a specific tag

In your project's root folder, run the following command to checkout a specific tag, in this example version 1.42.

```bash
git checkout tags/1.42 -b 1.42
```

Then run the update instructions of version 1.42. These updates are found in the project's "Releases" on GitHub.

Once that's done, checkout version 1.43 by running:

```bash
git checkout tags/1.43 -b 1.43
```

And run the update instructions of version 1.43. Repeat until you are running the latest version.
