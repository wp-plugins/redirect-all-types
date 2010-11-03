=== Plugin Name ===
Contributors: kegentile
Donate link: 
Tags: login, redirect, admin, administration, dashboard, users, authentication
Requires at least: 2.7
Tested up to: 3.1
Stable tag: trunk

Adds a field to the user's profile for redirection upon login.  

== Description ==

This plugin will add a field to users' profiles specifically for redirecting the user upon a successful login.  If no redirect is specified the standard login rules will apply.  It doesn't currently support bulk redirects as in the instance of redirecting users with a specific role.  Simple Login Redirect does support local redirects and redirects that point to another site.  

== Installation ==

Download and unzip to your WordPress Plugin folder.  Then simple activate the plugin.  The field for redirection will be added to the end of the user's profiles.  Input the full URL's including http:// and the save the profile.  The next time this user logs in they will be redirected to the URL you have specified.  

== Screenshots ==

1. User profile field for redirection

== Frequently Asked Questions ==

If you have questions or comments please post them in the comment section of http://www.wpinsideout.com/plugins/a-simple-redirect

== Changelog ==

* 9/6/2010 - Launch of version 1.0

* 11/3/2010 - Fixed but with function get_user_meta not existing with versions of WordPress less than 3.0