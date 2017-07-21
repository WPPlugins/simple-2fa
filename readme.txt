=== Simple 2FA ===
Contributors: popularsizzle
Tags: 2fa, totp, two-factor, login, authentication
Requires at least: 4.8
Tested up to: 4.8
Stable tag: 1.0.0
License: MIT
License URI: https://opensource.org/licenses/MIT

A lightweight, zero-config TOTP 2FA plugin with automatic rate limiting. PHP 7 and WP 4.8 or later.

== Description ==

A two-step verification plugin using the Time-based One-time Password Algorithm (TOTP), which can be used with an app or service like Google Authenticator.

* Lightweight and fast: no classes are instantiated until required
* No reliance or affiliation with any third-party service
* No setup or config required: immediately enabled for all uses upon plugin activation
* Automatically throttles multiple failed login attempts
* Uses filters to allow modifying functionality or output
* Requires PHP 7 or later
* Built for WordPress 4.8 or later

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/simple-2fa` directory, or install the plugin through the WordPress plugins screen directly
2. Activate the plugin through the 'Plugins' screen in WordPress
3. You will be required to activate 2FA for your account immediately
4. All other user will be required to activate 2FA when they next visit the WordPress admin area


== Frequently Asked Questions ==

= What if a user loses access to their app/secret? =

An administrator can reset their 2FA secret, and a new one will be created when they next log in.

= What if the administrator loses access to their app/secret? =

Reset your secret if you are logged in, otherwise disable the plugin using WP CLI or in the DB.

== Screenshots ==

1. Login screen showing the additional 2FA code field
2. An example 2FA onboarding process screen

== Changelog ==

= 1.0.0 =
* First release.

== Upgrade Notice ==

= 1.0.0 =
* First release.
