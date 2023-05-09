# Compiling assets

During development, when changes to vue, js or css code are made its necesary to run `sail yarn run build` to re-compile your assets in the background, a page reload is also necesary for the changes to take place on your browser.

Once you're ready for prod, run `sail yarn build`, this takes around 5-10 seconds, builds all compiled assets and deletes old asset files that are replaced, commit those changes to git.
