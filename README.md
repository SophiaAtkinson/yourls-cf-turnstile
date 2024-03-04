Cloudflare Turnstile for YOURLS Admin
====================

Plugin for [YOURLS](https://yourls.org) `v1.19.2`. 

*I haven't tested it with older versions so tread with caution :)*

**This plugin is roughly based off [this plugin](https://github.com/axilaris/admin-yourls-recaptcha-v3/)**

Description
-----------
Adds Cloudflare Turnstile to the YOURLS Admin login.

Installation
------------
1. In `/user/plugins`, create a new folder named `yourls-cf-turnstile`.
2. Drop these files in that directory.
3. Change `YOUR_CF_TURNSTILE_SITE_KEY` and `YOUR_CF_TURNSTILE_SECRET_KEY` to the keys found on the [Turnstile Page](https://dash.cloudflare.com/?to=/:account/turnstile)
4. Go to the Plugins administration page ( *eg* `http://sho.rt/admin/plugins.php` ) and activate the plugin.

Thats all folks 
------------