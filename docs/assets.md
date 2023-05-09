# Compiling assets

During development, when changes to vue, js or css code are made its necesary to run `sail yarn dev` to re-compile your assets in the background and reload the page whenever something changes in the css, vue or js code.

Once you're ready for prod, stop `dev` mode and run `sail yarn build`, this takes around 5-10 seconds, builds all compiled assets and deletes old asset files that are replaced, commit those changes to git.
