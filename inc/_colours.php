<?php

/*******************************************************************************
 * This file is auto generated from theme_config.json
 * All changes must be made there and then run npm build
 *
 *
 * @param $palette
 *
 * @return array|mixed
 ******************************************************************************/

function idkomm_get_colour_palette( $palette ) {

	$palettes = [
		'BasicColours' => [
			[
					'name'  => __( 'White', 'idkomm' ),
					'slug'  => 'color-white',
					'color' => 'white',
			],
			[
					'name'  => __( 'White Smoke', 'idkomm' ),
					'slug'  => 'color-whitesmoke',
					'color' => 'whitesmoke',
			],
			[
					'name'  => __( 'Light Gray', 'idkomm' ),
					'slug'  => 'color-lightgray',
					'color' => 'lightgray',
			],
			[
					'name'  => __( 'Gray', 'idkomm' ),
					'slug'  => 'color-gray',
					'color' => 'gray',
			],
			[
					'name'  => __( 'Black', 'idkomm' ),
					'slug'  => 'color-black',
					'color' => 'black',
			],
			[
					'name'  => __( 'Blue', 'idkomm' ),
					'slug'  => 'color-blue',
					'color' => 'blue',
			],
			[
					'name'  => __( 'Red', 'idkomm' ),
					'slug'  => 'color-red',
					'color' => 'red',
			],
			[
					'name'  => __( 'Yellow', 'idkomm' ),
					'slug'  => 'color-yellow',
					'color' => 'yellow',
			],
			[
					'name'  => __( 'Green', 'idkomm' ),
					'slug'  => 'color-green',
					'color' => 'green',
			],
			[
					'name'  => __( 'Purple', 'idkomm' ),
					'slug'  => 'color-purple',
					'color' => 'purple',
			],
			[
					'name'  => __( 'Orange', 'idkomm' ),
					'slug'  => 'color-orange',
					'color' => 'orange',
			],
			[
					'name'  => __( 'Pink', 'idkomm' ),
					'slug'  => 'color-pink',
					'color' => 'pink',
			],
			[
					'name'  => __( 'Cyan', 'idkomm' ),
					'slug'  => 'color-cyan',
					'color' => 'cyan',
			],
		],
		'ThemeColours' => [
			[
					'name'  => __( 'White', 'idkomm' ),
					'slug'  => 'color-theme-white',
					'color' => 'white',
			],
			[
					'name'  => __( 'Black', 'idkomm' ),
					'slug'  => 'color-theme-black',
					'color' => 'black',
			],
			[
					'name'  => __( 'Gray', 'idkomm' ),
					'slug'  => 'color-theme-gray',
					'color' => 'gray',
			],
		],
		'FontColours' => [
			[
					'name'  => __( 'Font colour', 'idkomm' ),
					'slug'  => 'font-color-base',
					'color' => 'black',
			],
		],
		'LinkColours' => [
			[
					'name'  => __( 'Link colour', 'idkomm' ),
					'slug'  => 'a-color-base',
					'color' => '#0000FF',
			],
			[
					'name'  => __( 'Link hover', 'idkomm' ),
					'slug'  => 'a-color-hover',
					'color' => '#191970',
			],
			[
					'name'  => __( 'Link visited', 'idkomm' ),
					'slug'  => 'a-color-visited',
					'color' => '#800080',
			],
			[
					'name'  => __( 'Link active', 'idkomm' ),
					'slug'  => 'a-color-active',
					'color' => '#FF0000',
			],
		],
		'BackgroundColors' => [
			[
					'name'  => __( 'Header background', 'idkomm' ),
					'slug'  => 'background-color-header',
					'color' => 'gray',
			],
			[
					'name'  => __( 'Content background', 'idkomm' ),
					'slug'  => 'background-color-content',
					'color' => 'whitesmoke',
			],
			[
					'name'  => __( 'Footer background', 'idkomm' ),
					'slug'  => 'background-color-footer',
					'color' => 'gray',
			],
		],
		'EditorColourPalette' => [
			[
					'name'  => __( 'Dusty', 'idkomm' ),
					'slug'  => 'dusty',
					'color' => '#96858F',
			],
			[
					'name'  => __( 'Lavender', 'idkomm' ),
					'slug'  => 'lavender',
					'color' => '#6D7993',
			],
			[
					'name'  => __( 'Overcast', 'idkomm' ),
					'slug'  => 'overcast',
					'color' => '#9099A2',
			],
			[
					'name'  => __( 'Paper', 'idkomm' ),
					'slug'  => 'paper',
					'color' => '#D5D5D5',
			],
			[
					'name'  => __( 'Yellow', 'idkomm' ),
					'slug'  => 'yellow',
					'color' => '#FFFF00',
			],
			[
					'name'  => __( 'Mauve', 'idkomm' ),
					'slug'  => 'mauve',
					'color' => '#AA00FF',
			],
			[
					'name'  => __( 'Puke', 'idkomm' ),
					'slug'  => 'puke',
					'color' => '#55FF00',
			],
		],
		
	];

	if (isset($palettes[$palette])) {
		return $palettes[$palette];
	}

	return [];
}
