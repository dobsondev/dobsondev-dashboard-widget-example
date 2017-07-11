# DobsonDev WordPress Dashboard Widget Example

A simple plugin for illustrating how to use the WordPress Dashboard Widget API. The example provided is extremely simple - but for more information see the Codex pages on the [Dashboard Widgets API](https://codex.wordpress.org/Dashboard_Widgets_API) and creating an [Example Dashboard Widget](https://codex.wordpress.org/Example_Dashboard_Widget). All of the code for this plugin was adapted from those pages as well as my own [DobsonDev WordPress AJAX Tester plugin](https://github.com/SufferMyJoy/dobsondev-wordpress-ajax-tester).

The dashboard widget created by this plugin provides an AJAX interface where you can call on your WordPress options table and display information about them based on their ID. The option ID, name, value and if it autoloads or not are all displayed in the table. As mentioned briefly above, the widget uses AJAX calls so you can check out as many options as you want without ever having to reload or leave the page.

The real point of this plugin is to look through the code and see how the WordPress dashboard widget API works with a real example. This plugin also demonstrates how AJAX in WordPress plugins works (which can also be seen in my [DobsonDev WordPress AJAX Tester plugin](https://github.com/SufferMyJoy/dobsondev-wordpress-ajax-tester)).

To install simply add this folder to your plugins folder (most commonly located at '/wp-content/plugins/').