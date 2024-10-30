# Cubecolour Caboodle

Contributors: numeeja
Requires: 6.0
Tested up to: 6.6
Stable tag: 1.1.0
Donate link: [https://cubecolour.co.uk/wp](https://cubecolour.co.uk/wp)
Requires PHP: 7.4
License: GPLv2 or later
License URI: [https://www.gnu.org/licenses/gpl-2.0.html](https://www.gnu.org/licenses/gpl-2.0.html)  
Tags: login, admin, content, media, footer

A collection of over fifty modules containing useful functions in a single plugin.

## Description

This plugin was created for use in cubecolour website projects to include a collection of modules, each of which can be enabled and configured in the Caboodle panel in the WordPress customizer.

This plugin is designed to be as lightweight as possible, and none of the modules load jQuery on the front end.

The plugin's configuration can be exported/imported as a JSON file, so once you have a preferred configuration, this can be used on multiple websites.

[youtube https://youtu.be/FeEithfYb9w]

## Modules

### Additional date and time formats
Adds new options for date and time formats in the general settings admin page

### Private site
Redirect unauthenticated visitors to the login page

### Login background
Apply a simple coloured background pattern to the login page

### No login by email address
Must log in by username, not by email address

### Mask password
Do not momentarily show password characters when entered on iPad, iPhone and android

### Single login error message
If login fails, a single error message is returned rather than different messages for wrong username or wrong password

### Login warning message
Adds a configurable message to the login form

### Password visualization
Visually confirm you have input the correct password before pressing the submit button by checking a pattern of coloured bars based on a hash of your input

### Open site in new tab
The view site link in the admin toolbar opens the page in a new tab

### Replace WP logo
Replace the WP logo in the admin toolbar with the site icon if one is configured

### Dashboard notes
Adds a simple notepad to the dashboard

### No avatars
Remove support for gravatars or user avatars

### Show IDs
Show the ID for posts, pages, custom post types, taxonomies, media and user IDs in the admin pages

### Show current WP version
Show the current WP version in the admin footer when an upgrade is available

### No howdy
Replace the howdy greeting with one of four configurable salutations appropriate to the time of day

### Revisions
Limit the number of saved revisions

### Developer link
Developer link in admin footer and **[developer]** shortcode for the front end

### Show settings
List the WordPress options with their values from the admin settings menu

### New plugins
Add "New" & "Beta" links to the add plugins page

### Preloading
Speed up browsing between pages

### Force vertical scrollbar
Prevent layout shift between long and short pages

### Scroll to anchor
Smoothly animate the vertical movement after clicking a link targeting an anchored position

### Text selection
Color and background color of selected text

### Page slug body class
Add a page slug class to the body tag

### Dash spacing
Replace spaces around en-dashes & em-dashes with hairspaces

### Admin Menu Order
Change admin menu order so that Dashboard, Pages, Posts, Media are at the top

### Posts
Keep, remove or rename the posts post type

### Page excerpts
Add support for manual excerpts to pages

### Unlink parent menu items
Enable drop down menus to work more intuitively

### Indicate external links
Add an arrow icon to identify external links within the site content

### Wavy links
Add a wavy underline to links within the site content

### Lightbox
Adds a lightweight lightbox to images and galleries

### Show media file size
Adds a file size column in the media library list view

### Media attachment pages
Enables media attachment pages *(removed in WP v6.4)* to be reinstated

### Add dashicons
Additional dashicons

### No lazy loading
No WordPress lazy loading

### Scroll to top
Add a dynamic scroll to top button in the website footer

### Fix footer
Fix the footer element to the bottom of the viewport on short pages

### Footer years range
Copyright years shortcode **[years]** to use in footer

### Anti spambot
Shortcode to add mailto link to email addresses in content, whilst protecting from spambots: **[email]**hello@domain.com**[/email]**

### Anti clickjack
Prevent the site from loading inside an external frame or iframe

### No admin bar
Remove the admin bar from the front end for all users or all users except administrators

### No file editors
Removes the theme and plugin editor pages from admin

### No author archives
Requests for author archive pages will redirect to the homepage

### No generator
Remove the WordPress generator meta tag

### No RSD
Remove the Really Simple Discovery endpoint

### No feeds
Remove the RSS,RDF and atom feeds

### No shortlinks
Remove the shortlink header tags

### No pingbacks
Prevent self-pingbacks

### Embed bandcamp
Enable the [bandcamp] shortcode  generated by bandcamp to embed an audio player

### Search placeholder text
Use translatable default text in header cover search *(for Astra theme only)*

### Responsive breakpoints
Set custom responsive breakpoints *(for Astra theme only)*

### Polylang SVG flags
Only available when the Polylang plugin is active on the site. Use scalable vector graphics for flags in the language switcher

### Gravity forms
Only available when the Gravity forms plugin is active on the site. Add basic styles to forms created with Gravity Forms

## FAQ

### Is Caboodle free?

Yes, the plugin is free to use.

### What support is available?

You can ask support questions on the plugin's support forum on [WordPress.org](https://wordpress.org). If you require a customized version of the plugin, or premium support as a paid service, please contact the developer via the contact form on [cubecolour.co.uk](https://cubecolour.co.uk).

### Will any new modules be added in the future?

Yes, that is the plan.

### Will the plugin be updated when necessary so it will continue to work in the future?

Yes, that is the other plan.

### Can I add a new translation?

Yes, the plugin is translation ready.

### I am using the plugin and love it, or it has saved me time and/or money. How can I show my appreciation?

You can donate via [my donation page](http://cubecolour.co.uk/wp/ "cubecolour donation page"). If you find the plugin useful I would also appreciate a glowing five star review on the [plugin review page](https://wordpress.org/support/plugin/cubecolour-caboodle/reviews/#new-post "Cubecolour Caboodle plugin review page")

### Who or what is cubecolour?

Cubecolour is the web development business run by Michael Atkins in London, UK, specialising in building and supporting WordPress websites and plugins.

### Why is the plugin called caboodle?

The plugin was originally going to be named 'fannypack', however that doesn't have quite the same meaning in the UK.

## Screenshots

1. Settings can be configured in the WordPress Customizer
2. Scroll to top module
3. Indicate external links module
4. Save and load the configuration.

## Changelog

### 1.1.0

* 'Admin menu order' module
* 'No admin bar' module
* 'Preloading' module
* 'Lightbox' module
* 'No feeds' module
* 'Wavy links' module
* 'Embed bandcamp' module
* 'Replace WordPress logo' module
* 'Unlink parent menu items' module
* 'Additional date & time format option' module
* 'No file editors' module
* Removed 'Plugin readme links' module
* Removed 'Prevent runts' module
* Add target="_blank" and rel="noopener noreferrer nofollow" attributes to external links
* Namespaced functions cc_caboodle_...
* Fixes for PHP 8.2 compatibility
* Fix 'No Generator' module not appearing
* Fix 'Years' module not appearing
* Fixes for issues found with the plugin check plugin
* Other Minor bug fixes

### 1.0.4

* 'Plugin readme links' module
* 'New plugins' module
* Improved formatting of readme.txt for viewing as markdown
* Updated customizer toggle switch control for PHP 8.1 compatibility
* Fix display issue in customizer range control
* Fix 'No login by email' module not appearing

### 1.0.3

* Added 'Enable media attachment pages' module

### 1.0.2

* Remove redundant variable initialization

### 1.0.0

* Initial release
