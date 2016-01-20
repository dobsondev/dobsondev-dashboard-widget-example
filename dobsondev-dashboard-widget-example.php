<?php
/**
 * Plugin Name: DobsonDev WordPress Dashboards Widgets API Example
 * Plugin URI: http://dobsondev.com
 * Description: An example plugin that shows you how to use the Dashboard Widgets API.
 * Version: 0.666
 * Author: Alex Dobson
 * Author URI: http://dobsondev.com/
 * License: GPLv2
 *
 * Copyright 2016  Alex Dobson  (email : alex@dobsondev.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */


/*
 * Enqueue scripts and styles
 */
function dobsondev_dashboard_widget_example_style() {
  wp_enqueue_style( 'dobsondev-dashboard-widget-example-css', plugins_url( 'dobsondev-dashboard-widgets-example.css', __FILE__ ) );
}
add_action( 'admin_enqueue_scripts', 'dobsondev_dashboard_widget_example_style' );

/*
 * Add a widget to the dashboard.
 */
function dobsondev_add_dashboard_widget_example() {
  wp_add_dashboard_widget(
    'dobsondev_dashboard_widget_example',         // Widget slug.
    'DobsonDev Dashboard Widget',                 // Title.
    'dobsondev_dashboard_widget_example_function' // Display function.
  );
  // Globalize the metaboxes array, this holds all the widgets for wp-admin
  global $wp_meta_boxes;
  // Get the regular dashboard widgets array
  // (which has our new widget already but at the end)
  $normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
  // Backup and delete our new dashboard widget from the end of the array
  $example_widget_backup = array( 'dobsondev_dashboard_widget' => $normal_dashboard['dobsondev_dashboard_widget'] );
  unset( $normal_dashboard['dobsondev_dashboard_widget'] );
  // Merge the two arrays together so our widget is at the beginning
  $sorted_dashboard = array_merge( $example_widget_backup, $normal_dashboard );
  // Save the sorted array back into the original metaboxes
  $wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
}
add_action( 'wp_dashboard_setup', 'dobsondev_add_dashboard_widget_example' );

/*
 * The function that will display this widget.
 */
function dobsondev_dashboard_widget_example_function() {
  $html = '<div class="wrap">';
  $html .= '<h4>WordPress Options</h4>';
  $html .= '<table id="dobsondev-ajax-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Value</th>
        <th>Autoload</th>
      </tr>
    </thead>
    <tbody>';
  $html .= '</tbody></table>';
  $html .= '<input type="text" size="4" id="dobsondev-ajax-option-id" />';
  $html .= '<button id="dobsondev-wp-ajax-button">Get Option</button>';
  $html .= '</div>';
  echo $html;
}

/*
 * The JavaScript for our AJAX call
 */
function dobsondev_ajax_tester_ajax_script() {
  ?>
  <script type="text/javascript" >
  jQuery(document).ready(function($) {

    $( '#dobsondev-wp-ajax-button' ).click( function() {
      var id = $( '#dobsondev-ajax-option-id' ).val();
      $.ajax({
        method: "POST",
        url: ajaxurl,
        data: { 'action': 'dobsondev_ajax_tester_approal_action', 'id': id }
      })
      .done(function( data ) {
        console.log('Successful AJAX Call! /// Return Data: ' + data);
        data = JSON.parse( data );
        $( '#dobsondev-ajax-table' ).append('<tr><td>' + data.option_id + '</td><td>' + data.option_name + '</td><td>' + data.option_value + '</td><td>' + data.autoload + '</td></tr>');
      })
      .fail(function( data ) {
        console.log('Failed AJAX Call :( /// Return Data: ' + data);
      });
    });

  });
  </script>
  <?php
}
add_action( 'admin_footer', 'dobsondev_ajax_tester_ajax_script' );

/*
 * The AJAX handler function
 */
function dobsondev_ajax_tester_ajax_handler() {
  global $wpdb;

  $id = $_POST['id'];
  $data = $wpdb->get_row( 'SELECT * FROM ' . $wpdb->prefix . 'options WHERE option_id = ' . $id, ARRAY_A );
  echo json_encode($data);
  wp_die(); // just to be safe
}
add_action( 'wp_ajax_dobsondev_ajax_tester_approal_action', 'dobsondev_ajax_tester_ajax_handler' );


?>