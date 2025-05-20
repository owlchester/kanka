# Running kanka

## Preface

Kanka is a dockerized self-hosted PHP application.

> :warning: **Warning**
>
> This docker setup is meant for developers working on Kanka. **Do not use** this docker setup to host Kanka on the web! It comes with 0 security (no root password and all ports open).
>
> This setup works as is for our team running with Docker on Linux and macOS. We only provide limited support for helping people host Kanka locally on Discord from Monday to Friday 9am-3pm (GMT-5). We currently do not provide any paid support for helping people self-host Kanka or enabling premium features.

## Differences compared to kanka.io

These developer docker instances are quite different from [kanka.io](https://kanka.io/) that we've listed below.

* No security, no automatic backups.
* No support for premium campaigns and subscriber bonuses.
* No advanced caching, meaning that as the data grows, the app will become much slower.
* No third-party setup like discord, google/meta/x (formerly twitter) logins, stripe, or analytics.
* No emails or notifications.
* No access to the third party tools Kanka pays for like FontAwesome PRO, meaning some icons in the app won't work.
* And lastly, **limited support from the Kanka team to debug your local setup**.


## Docker

Kanka is set up to run with Docker and [Laravel Sail](https://laravel.com/docs/10.x/sail). It comes with several machines.
* Laravel Sail for running the Kanka PHP application
* [Mariadb](https://mariadb.org/) for the database
* [Redis](https://redis.com/) for the cache
* [Minio](https://min.io/) for file storage
* [Thumbor](https://www.thumbor.org/) for image thumbnails
* [Mailpit](https://mailpit.axllent.org/) for email testing

### Prerequisite

Kanka has minimal hardware requirements and can run adequately on a €4/month Hetzner virtual machine. The machine will need the following software to run Kanka:
* [Docker](https://www.docker.com/)
* [Github CLI](https://cli.github.com/)

This GitHub repository needs to be Cloned (`git clone`) on your local machine. All commands are to be executed in the Kanka folder.

When on Linux, Docker needs to run with your user and not with sudo! This is important for file permissions to properly work. To set up docker to run with your user, [follow these instructions](https://docs.docker.com/engine/install/linux-postinstall/).

## Installation

### 1. Checkout the project

Checkout Kanka on your local machine

```bash
gh repo clone owlchester/kanka
```
or 
```bash
git clone https://github.com/owlchester/kanka.git
```
### 2. Configure the database

Once the project has finished downloading, copy the `.env.example` file and save it under `.env` at the root of your new Kanka installation. This file contains all the configuration settings to run Kanka, like the database details, the project's name, options for max file upload sizes, etc.

> **Hidden by default**
>
> Most operating systems hide files starting with a dot by default. You can either change this in your operating system's file explorer, or by accessing the files in the terminal.

Optionally, if you want to change some configs, edit the new `.env` file. In most cases, you don't need to touch anything.

### 3. Installing dependencies

Run the following command to install all the dependencies needed by Kanka. This command will start up a small docker to install everything through [composer](https://getcomposer.org).

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

#### Easier life

To make your life easier, we recommend setting an alias to the `sail` command.
```bash
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

Otherwise, whenever this setup mentions a sail command, replace it with `./vendor/bin/sail`.

### 4. Run docker

Everything should now be ready to run all those docker images. Passing the `-d` parameter starts it in the background.

```bash
sail up -d
```

### 5. Bucket setup

Image uploading in the app is stored on a *minio* service. This mimics the amazon S3 storage, and makes it easier to handle images rather than hosting them directly in the docker responsible for PHP.

First, go to [localhost:9000](http://localhost:9000). This is where your files will be stored. Login with `sail` as the user and `password` as the password.

Create a new bucket called `kanka`. This will redirect you to the new `kanka` bucket. Click on the top right cogwheel icon to access the bucket's config interface. On this page, change the `Access Policy` from `private` to `public`. Without this, uploaded file won't be visible in the browser.

Next up, create a second bucket called `thumbnails`. Same as before, go back and set it's `Access Policy` from `private` to `public`. This bucket will contain your thumbnails.

### 6. Run the installer

Now that the bucket is set up, go back to your console run the following commands. This will take care of setting up Kanka's database with all the boilerplate content to make it work.

```bash
sail artisan kanka:install
```

Lastly, set up the full-text search engine with the following line.

```bash
sail artisan setup:meilisearch
```

## Next up

Your local development instance of Kanka is now ready to go! Navigate to [localhost:8081](http://localhost:8081), and you should see the Kanka application and be able to create an account.

We recommend making an alias in your `/etc/hosts` file to point `kanka.test` to your localhost, so what (kanka.test:8081)[http://kanka.test:8081] also works.

Here are a few extra resources:
* Our [documentation](https://docs.kanka.io) covers how to use Kanka.
* Having trouble? Check out the [debugging](/docs/debugging.md).
* Learn how to [update](/docs/updating.md) your version of Kanka.


### Shutting down

To stop the docker images, run the following command from your Kanka folder.

```bash
sail down
```

### Sharing your local Kanka

Do not make your Kanka instance accessible to the web! To share your Kanka instance with your friends, use the `sail share` command. Follow the [official documentation](https://laravel.com/docs/10.x/sail#sharing-your-site), or set up a reverse proxy in front of it.
