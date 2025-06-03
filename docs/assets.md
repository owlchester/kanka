# 🎨 Compiling assets

During development, when changes to vue, js or css code are made its necessary to run `sail yarn dev` to re-compile your assets in the background and reload the page whenever something changes in the css, vue or js code.

Once you're ready for prod, stop `dev` mode and run `sail yarn build`, this takes around 5-10 seconds, builds all compiled assets and deletes old asset files that are replaced, commit those changes to git.

## Deploying assets to cloudfront

To deploy assets to prod, set the `ASSET_URL` env to the cloudfront URL.

Now rebuild the assets

> sail yarn build

Next, sync the build folder to s3

> aws s3 sync public/build/ s3://kanka-user-assets/build/ --include "*" --acl public-read --delete


If doing an update, first do sync without --delete.
 
For the api docs to work, the same needs to be done for the `public/vendor/binarytorch` folder.

> aws s3 sync public/vendor/binarytorch/ s3://kanka-user-assets/vendor/binarytorch/ --include "*" --acl public-read --delete

For leaflet, summernote etc, the same needs to be done for the `public/js/` folder.

> aws s3 sync public/vendor/leaflet/ s3://kanka-user-assets/vendor/leaflet/ --include "*" --acl public-read --delete

## Images

Stuff like default thumbnails, subscriber thumbnails

> aws s3 sync public/images/ s3://kanka-user-assets/images/ --include "*" --acl public-read --delete
