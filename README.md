# Wordpress - Protect Hidden Files

A simple Wordpress plugin that prevents access to hidden (dot) files (such as the .git directory) on your website. Simply install the plugin and activate - you're good to go!

This plugin was developed primarily in response to the great work by Vladimir Smitka. You can check out his website here: https://smitka.me/

## Installation

Currently, the quickest method of installing is to download a zip file of this repository and upload it to your Wordpress installation as a new plugin. Once installed, just activate it to prevent access to hidden files.

## How does it work?

This plugin automatically generates and implements the following .htaccess rules for your Wordpress installation. Using a plugin for this ensures that the rules aren't accidently removed.

```apache
# Scaffold - Protect Hidden Files
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule "(^|/)\.(?!well-known\/)" - [F]
</IfModule>
```
