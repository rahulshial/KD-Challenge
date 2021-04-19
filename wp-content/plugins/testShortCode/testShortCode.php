<?php
/**
 * @package Akismet
 */
/*
Plugin Name: test Shortcode
Plugin URI: N/A
Description: The testshortcode plugin will output "TEST SUCCEEDED!" when used on a page
Author: Rahul Shial
Author URI: https://github.com/rahulshial
License: GPLv2 or later
Text Domain: test
*/

// Add Shortcode
function test_shortcode($attr) {
  $msg = 'TEST SUCCEEDED!';
  shortcode_atts(array(
    'repeat' => 1
  ), $attr);
  return str_repeat($msg,$attr['repeat']);
}

add_shortcode( 'test', 'test_shortcode' );
