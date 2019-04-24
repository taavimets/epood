<?php
/**
 * Plugin name: Very first plugin
 * Plugin URL: http://metstaavi.ikt.khk.ee/
 * Description: This is the first ever plugin ive cre3ated
 * Version: 1.0
 * Author: Taavi Mets
 * Authotr URL: http://metstaavi.ikt.khk.ee/
**/

function dh_modify_read_more_link() {
 return '<a class="more-link" href="' . get_permalink() . '">Click to Read!</a>';
}
add_filter( 'the_content_more_link', 'dh_modify_read_more_link' );