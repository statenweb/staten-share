<?php

namespace StatenShare;

use StatenShare\Helpers\WP\Thing;
use StatenShare\Settings\Global_Settings;


class Actions extends Thing {

	protected static $output_on_current_page = null;


	public function attach_hooks() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
		add_filter( 'the_content', array( $this, 'output_icons' ) );
		add_filter( 'get_the_excerpt', array( $this, 'output_icons' ) );
		add_action( 'wp_head', array( $this, 'head' ) );
	}

	public function head() {
		if ( ! self::output_media() ) {
			return;
		}
		self::output_css();
		self::output_js();
	}

	public function enqueue() {

		$plugin_path = plugin_dir_url( dirname( __FILE__ ) );
		wp_enqueue_script( 'story-share', $plugin_path . 'js/story.share.js',
			[ 'jquery' ] );


	}

	public function output_icons( $content ) {

		if ( ( is_archive() || is_home() || is_single() ) && Global_Settings::get( 'statenshare_post_type_' . get_post_type() ) ) {


			$social_properties          = [];
			$social_properties_to_check = [ 'facebook', 'twitter', 'pinterest', 'linkedin', 'google_plus' ];
			foreach ( $social_properties_to_check as $social_property_to_check ) {
				if ( Global_Settings::get( 'statenshare_' . $social_property_to_check ) ) {
					$social_properties[] = $social_property_to_check;
				}
			}


			ob_start();
			?>
			<div class="statenshare %s %s">
				%s
				<?php
				foreach ( $social_properties as $social_property ):
					$social_data = statenshare_get_svg( $social_property );
					$social_anchor = statenshare_get_data( $social_property );
					echo $social_anchor['open'];
					?>


					<svg viewBox="<?php echo esc_attr( $social_data['viewBox'] ); ?>">
						<path d="<?php echo esc_attr( $social_data['path-d'] ); ?>"></path>
					</svg>
					<?php
					echo $social_anchor['close'];
				endforeach;

				?>
			</div>
			<?php


			$social_content = ob_get_clean();

			if ( ( is_home() || is_archive() ) && Global_Settings::get( 'statenshare_after_content_archive' ) ) {
				$label   = self::get_share_label( Global_Settings::get( 'statenshare_share_label_archive' ) );
				$align   = 'statenshare-' . Global_Settings::get( 'statenshare_align_social_archive' );
				$content = $content . sprintf( $social_content, 'statenshare-after', esc_attr( $align ),
						$label /* escaped below */ );
			}

			if ( is_single() && Global_Settings::get( 'statenshare_after_content_single' ) ) {
				$label   = self::get_share_label( Global_Settings::get( 'statenshare_share_label_single' ) );
				$align   = 'statenshare-' . Global_Settings::get( 'statenshare_align_social_single' );
				$content = $content . sprintf( $social_content, 'statenshare-after', esc_attr( $align ),
						$label /* escaped below */ );
			}

			if ( ( is_home() || is_archive() ) && Global_Settings::get( 'statenshare_before_content_archive' ) ) {
				$label   = self::get_share_label( Global_Settings::get( 'statenshare_share_label_archive' ) );
				$align   = 'statenshare-' . Global_Settings::get( 'statenshare_align_social_archive' );
				$content = sprintf( $social_content, 'statenshare-before', esc_attr( $align ),
						$label /* escaped below */ ) . $content;
			}

			if ( is_single() && Global_Settings::get( 'statenshare_before_content_single' ) ) {
				$label   = self::get_share_label( Global_Settings::get( 'statenshare_share_label_single' ) );
				$align   = 'statenshare-' . Global_Settings::get( 'statenshare_align_social_single' );
				$content = sprintf( $social_content, 'statenshare-before', esc_attr( $align ),
						$label /* escaped below */ ) . $content;
			}


		}

		return $content;
	}

	protected static function get_share_label( $label ) {
		if ( ! trim( $label ) ) {
			return null;
		}

		return sprintf( '<span class="statenshare__label">%s</span>', esc_html( $label ) );

	}

	protected static function output_media() {

		if ( ! is_null( self::$output_on_current_page ) ) {
			return self::$output_on_current_page;
		}

		self::$output_on_current_page = false;

		if (
			( ( is_archive() || is_home() || is_single() ) && Global_Settings::get( 'statenshare_post_type_' . get_post_type() ) ) &&
			( ( ( is_home() || is_archive() ) && ( Global_Settings::get( 'statenshare_before_content_archive' ) || Global_Settings::get( 'statenshare_after_content_archive' ) ) ) ||
			  ( is_single() && ( Global_Settings::get( 'statenshare_after_content_single' ) || Global_Settings::get( 'statenshare_before_content_single' ) ) ) )
		) {
			self::$output_on_current_page = true;

		}

		return self::$output_on_current_page;


	}


	protected static function sanitize_hex_color( $color ) {
		if ( '' === $color ) {
			return '';
		}

		// 3 or 6 hex digits, or the empty string.
		if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			return $color;
		}
	}

	protected static function output_css() {
		?>
		<style>

			.statenshare {
				text-align: center;
				display: flex;
				align-items: center;
				justify-content: center;
				color: <?php echo self::sanitize_hex_color(Global_Settings::get('statenshare_label_color')); ?>
			}

			.statenshare.statenshare-left {
				justify-content: flex-start;
			}

			.statenshare.statenshare-right {
				justify-content: flex-end;
			}

			.statenshare-before {
				margin-bottom: 20px;
			}

			@media screen and (min-width: 480px) {
				.statenshare__label {
					margin-right: 25px;
				}
			}

			.statenshare svg {
				height: 32px;
				width: 32px;

			}

			<?php if (Global_Settings::get('statenshare_icon_color')  ): ?>

			.statenshare svg path {
				fill: <?php echo self::sanitize_hex_color(Global_Settings::get('statenshare_icon_color')); ?>
			}

			<?php endif; ?>

			<?php if (Global_Settings::get('statenshare_icon_color_hover')  ): ?>

			.statenshare svg:hover path {
				transition: fill .4s ease;
				fill: <?php echo self::sanitize_hex_color(Global_Settings::get('statenshare_icon_color_hover')); ?>
			}

			<?php endif; ?>

			.statenshare a.share {
				text-decoration: none;
				margin-right: 25px;
				display: flex;
			}
		</style>
		<?php
	}

	protected static function output_js() {


		?>
		<script>
          jQuery(document).ready(function($) {
            var $statenShareLink = $('.statenshare a');
            $statenShareLink.storyShare();
            $statenShareLink.on('click', function(e) {
              e.preventDefault();
            });
          });
		</script>
		<?php


	}


}