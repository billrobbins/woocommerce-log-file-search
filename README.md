# Log Search for WooCommerce

This plugin was born out of a need to search through all of the WooCommerce log files for matching content.  By default, WooCommerce stores the log files from the previous 30 days.  Tracking down a single instance of text out of those is time consuming.  This plugin helps by providing a UI to search existing log files.

It searches for a single string and will return the names of any matching files along with a link to open their contents.  At the present time it can't search multiple strings or highlight the occurences of the string within the file.  

![demo](https://user-images.githubusercontent.com/1138631/190652445-2c3a0d2e-8585-4c27-9513-95e4d3c2d23a.gif)

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