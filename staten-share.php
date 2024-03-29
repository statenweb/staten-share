<?php

/*
Plugin Name: Staten Share
Plugin URI: http://statenweb.com/staten-share
Description: Easily add share buttons on your content
Author: Mat Gargano and StatenWeb
Version: 0.0.4
Author URI: http://statenweb.com
*/


use StatenShare\Settings\Global_Settings;
use StatenShare\Actions;

require __DIR__ . '/settings.php';
require __DIR__ . '/initialize-settings.php';
require __DIR__ . '/vendor/autoload.php';

$global_settings = new Global_Settings();
$global_settings->init();

$actions = new Actions();
$actions->init();



function statenshare_get_svg( $which ) {
	$array = false;
	switch ( strtolower( $which ) ):
		case 'facebook':
			$array = array(
				'viewBox' => '0 0 512 512',
				'path-d'  => 'M211.9 197.4h-36.7v59.9h36.7V433.1h70.5V256.5h49.2l5.2-59.1h-54.4c0 0 0-22.1 0-33.7 0-13.9 2.8-19.5 16.3-19.5 10.9 0 38.2 0 38.2 0V82.9c0 0-40.2 0-48.8 0 -52.5 0-76.1 23.1-76.1 67.3C211.9 188.8 211.9 197.4 211.9 197.4z',
				'name'    => 'Pinterest',
			);
			break;
		case 'twitter':
			$array = array(
				'viewBox' => '0 0 512 512',
				'path-d'  => 'M419.6 168.6c-11.7 5.2-24.2 8.7-37.4 10.2 13.4-8.1 23.8-20.8 28.6-36 -12.6 7.5-26.5 12.9-41.3 15.8 -11.9-12.6-28.8-20.6-47.5-20.6 -42 0-72.9 39.2-63.4 79.9 -54.1-2.7-102.1-28.6-134.2-68 -17 29.2-8.8 67.5 20.1 86.9 -10.7-0.3-20.7-3.3-29.5-8.1 -0.7 30.2 20.9 58.4 52.2 64.6 -9.2 2.5-19.2 3.1-29.4 1.1 8.3 25.9 32.3 44.7 60.8 45.2 -27.4 21.4-61.8 31-96.4 27 28.8 18.5 63 29.2 99.8 29.2 120.8 0 189.1-102.1 185-193.6C399.9 193.1 410.9 181.7 419.6 168.6z',
				'name'    => 'Twitter',
			);
			break;
		case 'linkedin':
			$array = array(
				'viewBox' => '0 0 512 512',
				'path-d'  => 'M186.4 142.4c0 19-15.3 34.5-34.2 34.5 -18.9 0-34.2-15.4-34.2-34.5 0-19 15.3-34.5 34.2-34.5C171.1 107.9 186.4 123.4 186.4 142.4zM181.4 201.3h-57.8V388.1h57.8V201.3zM273.8 201.3h-55.4V388.1h55.4c0 0 0-69.3 0-98 0-26.3 12.1-41.9 35.2-41.9 21.3 0 31.5 15 31.5 41.9 0 26.9 0 98 0 98h57.5c0 0 0-68.2 0-118.3 0-50-28.3-74.2-68-74.2 -39.6 0-56.3 30.9-56.3 30.9v-25.2H273.8z',
				'name'    => 'LinkedIn',
			);
			break;
		case 'google_plus':
			$array = array(
				'viewBox' => '0 0 512 512',
				'path-d'  => 'M179.7 237.6L179.7 284.2 256.7 284.2C253.6 304.2 233.4 342.9 179.7 342.9 133.4 342.9 95.6 304.4 95.6 257 95.6 209.6 133.4 171.1 179.7 171.1 206.1 171.1 223.7 182.4 233.8 192.1L270.6 156.6C247 134.4 216.4 121 179.7 121 104.7 121 44 181.8 44 257 44 332.2 104.7 393 179.7 393 258 393 310 337.8 310 260.1 310 251.2 309 244.4 307.9 237.6L179.7 237.6 179.7 237.6ZM468 236.7L429.3 236.7 429.3 198 390.7 198 390.7 236.7 352 236.7 352 275.3 390.7 275.3 390.7 314 429.3 314 429.3 275.3 468 275.3',
				'name'    => 'Google+',
			);
			break;
		case 'pinterest':
			$array = array(
				'viewBox' => '0 0 512 512',
				'path-d'  => 'M266.6 76.5c-100.2 0-150.7 71.8-150.7 131.7 0 36.3 13.7 68.5 43.2 80.6 4.8 2 9.2 0.1 10.6-5.3 1-3.7 3.3-13 4.3-16.9 1.4-5.3 0.9-7.1-3-11.8 -8.5-10-13.9-23-13.9-41.3 0-53.3 39.9-101 103.8-101 56.6 0 87.7 34.6 87.7 80.8 0 60.8-26.9 112.1-66.8 112.1 -22.1 0-38.6-18.2-33.3-40.6 6.3-26.7 18.6-55.5 18.6-74.8 0-17.3-9.3-31.7-28.4-31.7 -22.5 0-40.7 23.3-40.7 54.6 0 19.9 6.7 33.4 6.7 33.4s-23.1 97.8-27.1 114.9c-8.1 34.1-1.2 75.9-0.6 80.1 0.3 2.5 3.6 3.1 5 1.2 2.1-2.7 28.9-35.9 38.1-69 2.6-9.4 14.8-58 14.8-58 7.3 14 28.7 26.3 51.5 26.3 67.8 0 113.8-61.8 113.8-144.5C400.1 134.7 347.1 76.5 266.6 76.5z',
				'name'    => 'Facebook',
			);
			break;


	endswitch;

	return apply_filters( 'statenshare/svg', $array, $which );

}

function statenshare_get_data( $which ) {

	$array = false;

	switch ( strtolower( $which ) ):
		case 'facebook':
			$array = array(
				'open'  => '<a href="#" class="share" data-type="facebook-simple" data-url="{{current}}">',
				'close' => '</a>',
			);
			break;
		case 'twitter':
			$array = array(

				'open'  => sprintf( '<a href="#" class="share" data-type="twitter" data-text="%s" data-url="{{current}}">',
					esc_attr( get_the_title() ) ),
				'close' => '</a>',

			);
			break;
		case 'linkedin':


			global $post;
			$excerpt = $post->post_excerpt;

			$array = array(
				'open'  => sprintf( '<a href="#" %s class="share" data-type="linkedin" data-title="%s" data-url="{{current}}">',
					$excerpt,
					esc_attr( get_the_title() ) ),
				'close' => '</a>',
			);

			break;
		case 'google_plus':
			$array = array(

				'open' => '<a href="#" class="share" data-type="google-plus" data-url="{{current}}">',

				'close' => '</a>',

			);
			break;
		case 'pinterest':
			$media = '';
			if ( get_the_post_thumbnail_url() ) {
				$media = sprintf( ' data-media="%s" ', get_the_post_thumbnail_url() );
			}

			$array = array(
				'open'  => sprintf( '<a href="#" class="share" data-type="pinterest" %s data-description="%s" data-url="{{current}}">',
					$media,
					esc_attr( get_the_title() ) ),
				'close' => '</a>',
			);


			break;


	endswitch;

	return apply_filters( 'statenshare/svg/share_anchor', $array, $which );

}