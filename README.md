# Tracking Origin

## Description

Tracking Origin is a simple WordPress plugin designed to collect and catalog site visits using the GET method "origin". This plugin allows you to track the origin of site visits, making it perfect for redirecting portfolio sites to your main site and tracking their origins without the need for cookies like Google Analytics, which require user consent.

## How It Works

To use Tracking Origin, simply install the plugin and reference your site with the "origin" parameter in the URL, for example: `yourdomain.com/?origin=github`. The origins will be cataloged based on the value provided in the "origin" parameter. You can delete irrelevant records, clear the table, and export the data in CSV format.

## Features

- Collect and catalog visits based on the "origin" parameter in the URL.
- Display origin statistics in the WordPress admin panel.
- Delete specific origin records.
- Reset all counters while preserving origins.
- Export origin data as a CSV file.
- Automatically reset counters every N days, configurable by the user.

## Installation

1. Upload the plugin files to the `/wp-content/plugins/tracking-origin` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Use the `origin` parameter in the URL to start tracking visits, e.g., `yourdomain.com/?origin=github`.

## Usage

- To track a visit, include the `origin` parameter in your URL, e.g., `yourdomain.com/?origin=github`.
- Navigate to the "Tracking Origin" menu in the WordPress admin panel to view the collected data.
- Use the provided buttons to delete records, reset counters, or export data as a CSV file.
- Configure the automatic reset interval in the "Options" tab.

## Support and Contribution

For feature requests, please use the (coming soon) on WordPress.org or contact us via email at luizreimann@gmail.com. Feel free to create branches and modify this plugin to suit your needs.

## Changelog

**1.0.2**
- Fixed saving buttons and options.
- Fixed Last Visit not showing timezone-based.
- Other minor fixes.
- Improved organization of folders and files for future updates.

**1.0.1**
- Added automatic reset functionality.
- Improved user interface with tabbed navigation.
- Fixed timezone handling using gmdate().
- Other security improvements.

**1.0**
- Initial release.

## License

This plugin is licensed under the GPLv3 or later.