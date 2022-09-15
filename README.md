# Log Search for WooCommerce

This plugin was born out of a need to search through all of the WooCommerce log files for matching content.  By default, WooCommerce stores the log files from the previous 30 days.  Tracking down a single instance of text out of those is time consuming.  This plugin helps by providing a UI to search existing log files.

## Development

To work with this plugin, you'll need to use Docker. Once it is installed clone the repository. Then you can get started with these commands.

```
npm install
npx wp-env start
npm start
```

The site will be available at http://localhost:8888 with the username: `admin` and password: `password`.

## Distribution

Once you're ready to create a distributable package use this command:

```
npm run build-zip
```

That will build a ZIP file that's ready to install as a WordPress plugin.