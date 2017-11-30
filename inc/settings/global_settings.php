<?php

namespace StatenShare\Settings;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use StatenShare\Helpers\WP\Thing;

class Global_Settings extends Thing {


	const KEY = 'statenshare_options';

	public function attach_hooks() {
		add_action( 'carbon_fields_register_fields', array( $this, 'setup_options' ) );
	}


	public function setup_options() {

		$settings = array(
			Field::make( 'separator', 'statenshare_separator_1', 'Social Sites' ),
			Field::make( 'checkbox', 'statenshare_facebook',
				_x( 'Facebook', 'share_title',
					STATENSHARE_TRANSLATION_DOMAIN ) ),
			Field::make( 'checkbox', 'statenshare_twitter',
				_x( 'Twitter', 'share_title',
					STATENSHARE_TRANSLATION_DOMAIN ) ),
			Field::make( 'checkbox', 'statenshare_pinterest',
				_x( 'Pinterest', 'share_title',
					STATENSHARE_TRANSLATION_DOMAIN ) ),
			Field::make( 'checkbox', 'statenshare_linkedin',
				_x( 'LinkedIn', 'share_title',
					STATENSHARE_TRANSLATION_DOMAIN ) ),
			Field::make( 'checkbox', 'statenshare_google_plus',
				_x( 'Google Plus', 'share_title',
					STATENSHARE_TRANSLATION_DOMAIN ) ),
			Field::make( 'separator', 'statenshare_separator_2', 'Colors' ),
			Field::make( 'color', 'statenshare_icon_color', _x( 'Social Icon Color', 'social_icon_color',
					STATENSHARE_TRANSLATION_DOMAIN )
			)->set_default_value( '#222' ),
			Field::make( 'color', 'statenshare_icon_color_hover',
				_x( 'Social Icon Hover Color', 'social_color_hover',
					STATENSHARE_TRANSLATION_DOMAIN )

			)->set_default_value( '#888' ),

			Field::make( 'color', 'statenshare_label_color',
				_x( 'Social Label Coler', 'social_label_color',
					STATENSHARE_TRANSLATION_DOMAIN )


			)->set_default_value( '#222' ),
			Field::make( 'separator', 'statenshare_separator_4', 'Single' ),

			Field::make( 'checkbox', 'statenshare_before_content_single',
				_x( 'Before Content on Single', 'where_to_show',
					STATENSHARE_TRANSLATION_DOMAIN ) ),
			Field::make( 'checkbox', 'statenshare_after_content_single',
				_x( 'After Content on Single', 'where_to_show',
					STATENSHARE_TRANSLATION_DOMAIN ) ),
			Field::make( 'select', 'statenshare_align_social_single',
				_x( 'Align social icons (single)', 'align social single', STATENSHARE_TRANSLATION_DOMAIN ) )
			     ->add_options( array(
				     'center' => 'Center',
				     'left'   => 'Left',
				     'right'  => 'Right',


			     ) )->set_default_value( 'left' ),
			Field::make( 'text', 'statenshare_share_label_single',
				_x( 'Share Label on Single', 'statenshare_share_label_single',
					STATENSHARE_TRANSLATION_DOMAIN ) )->set_default_value( 'Share' ),

			Field::make( 'separator', 'statenshare_separator_5', 'Archive' ),

			Field::make( 'checkbox', 'statenshare_before_content_archive',
				_x( 'Before Content on Archive', 'where_to_show',
					STATENSHARE_TRANSLATION_DOMAIN ) ),
			Field::make( 'checkbox', 'statenshare_after_content_archive',
				_x( 'After Content on Archive', 'where_to_show',
					STATENSHARE_TRANSLATION_DOMAIN ) ),
			Field::make( 'select', 'statenshare_align_social_archive',
				_x( 'Align social icons (archive)', 'align social archive', STATENSHARE_TRANSLATION_DOMAIN ) )
			     ->add_options( array(
				     'center' => 'Center',
				     'left'   => 'Left',
				     'right'  => 'Right',


			     ) )->set_default_value( 'left' ),

			Field::make( 'text', 'statenshare_share_label_archive',
				_x( 'Share Label on Archive', 'statenshare_share_label_archive',
					STATENSHARE_TRANSLATION_DOMAIN ) )->set_default_value( 'Share' ),

			Field::make( 'separator', 'statenshare_separator_3', 'Post Types' ),


		);

		$post_types = get_post_types( [], 'object' );
		foreach ( $post_types as $post_type ) {
			if ( in_array( $post_type->name,
				[
					'attachment',
					'revision',
					'nav_menu_item',
					'custom_css',
					'customize_changeset',
					'oembed_cache',
				] ) ) {
				continue;
			}
			$settings[] = Field::make( 'checkbox', 'statenshare_post_type_' . $post_type->name,
				_x( $post_type->label, 'post type',
					STATENSHARE_TRANSLATION_DOMAIN )

			);
		}

		Container::make( 'theme_options', 'StatenShare' )
		         ->set_page_parent( 'options-general.php' )
		         ->add_tab( __( 'StatenShare' ), $settings );


	}

	public static function get( $key ) {
		return \carbon_get_theme_option( $key );
	}

}
