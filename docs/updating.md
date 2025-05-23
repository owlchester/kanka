# 🔄 Updating

We recommend always running from a release tag rather than the `main` branch. You can check which branch you are on by going `git branch` in the Kanka root folder on your machine (not in docker).

When a new version of Kanka is released, from your host machine you want to do `git pull` to get the newest updates. Updates usually include changes to the database, so run the following to run the migrations:

When updating your local installation, we recommend checkout out each tag chronologically in order to safely update your data.

> :warning: **Warning**
> Never ever checkout the `@develop` branch as it is unstable and will break your installation.

## ⚡ Backup

We **strongly** recommend backing up your database data before running any upgrade. You can create a backup of your data by running the following command. Note that this backup command is only available from version 1.44 and onward.

```bash
sail artisan backup:run
```

This will create a gzip file in `storage/app/{app_name}/{date}.zip`

## 🏷️ Checkout out a specific tag

In your project's root folder, run the following command to checkout a specific tag, in this example version 1.42.

```bash
git checkout tags/2.0 -b 2.0
```

Then run the update instructions of version 1.42. These updates are found in the project's "Releases" on GitHub.

Once that's done, checkout version 1.43 by running:

```bash
git checkout tags/2.0 -b 2.0
```

And run the update instructions of version 1.43. Repeat until you are running the latest version.
