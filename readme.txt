=== Plugin Name ===
Contributors: mbvwebdev
Tags: shortcode, google maps
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 0.2
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Google Maps Shortcode Integration

== Description ==

This Plugin uses [GMAP3 Plugin for jQuery](http://gmap3.net)

It's generating HTML/Javascript/jQuery to load a small Google Maps container. 

Usage Example: [gmaps center="{latitude},{longitude}" zoom={zoom} marker="{lat},{long}"]
	
You can split up the route form from your google maps with [groute]

[groute] requires a [gmaps] before!

= The following arguments are possible: =
* center: view of the map in "lat,long"
* zoom: zoom step
* marker: you can set an alternative marker, that is not centered
* height: height of the maps div
* width: width of the maps div
* with-route: add a route planner

for more details about the arguments, see the [documentation of jQuery gmap3](http://gmap3.net/en/catalog/)

= Developers =
[This Plugin is also available in GitHub](https://github.com/mbv-webdev/wp-gmaps3)

== Installation ==

just upload and activate the plugin

== Changelog ==

= 0.2 =
* Route Form added