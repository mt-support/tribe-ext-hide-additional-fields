<?php
/**
 * Plugin Name:     Events Calendar PRO Extension: Hide Additional Fields
 * Plugin URI:      https://github.com/mt-support/tribe-ext-hide-additional-fields
 * Description:     Provides the option to hide additional fields from the front end of events
 * Version:         1.0.1
 * Extension Class: Tribe__Extension__Hide_Additional_Fields
 * Author:          Modern Tribe, Inc.
 * Author URI:      http://m.tri.be/1971
 * License:         GPL version 3 or any later version
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:     tribe-ext-hide-additional-fields
 *
 *     This plugin is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     any later version.
 *
 *     This plugin is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *     GNU General Public License for more details.
 */

// Do not load unless Tribe Common is fully loaded and our class does not yet exist.
if (
	class_exists( 'Tribe__Extension' )
	&& ! class_exists( 'Tribe__Extension__Hide_Additional_Fields' )
) {
	/**
	 * Extension main class, class begins loading on init() function.
	 */
	class Tribe__Extension__Hide_Additional_Fields extends Tribe__Extension {

		/**
		 * The custom field key.
		 *
		 * @todo  Change to namespaced post meta key, such as tribe_ecp_custom_hidden or prefix with extension slug.
		 *
		 * @since 1.0.1
		 *
		 * @var string
		 */
		public static $field_key = 'custom-hidden';

		/**
		 * Setup the Extension's properties.
		 *
		 * This always executes even if the required plugins are not present.
		 */
		public function construct() {
			$this->add_required_plugin( 'Tribe__Events__Pro__Main', '4.4.23' );
		}

		/**
		 * Extension initialization and hooks.
		 *
		 * Note: Some of this extension's text uses other text domains (e.g. `tribe-events-calendar-pro`) because of
		 * straight-copying and this is OK because it's used in the same context and it'll already be translated
		 * instead of needing to be again just for this extension.
		 */
		public function init() {
			// Load plugin textdomain
			load_plugin_textdomain( 'tribe-ext-hide-additional-fields', false, basename( dirname( __FILE__ ) ) . '/languages/' );

			add_filter( 'tribe_events_event_meta_template', [ $this, 'override_event_fields_template' ] );
			add_action( 'save_post', [ $this, 'save_hidden_field' ], 999 );
			add_filter( 'tribe_get_custom_fields', [ $this, 'filter_additional_fields' ], 100 );

			if ( class_exists( 'Tribe__Events__Community__Main' ) ) {
				add_action( 'tribe_events_community_section_after_custom_fields', [ $this, 'community_events_support' ] );
			}
		}

		// overrides the additional fields admin view
		public function override_event_fields_template( $events_event_meta_template ) {
			$events_event_meta_template = plugin_dir_path( __FILE__ ) . '/src/views/event-meta.php';

			return $events_event_meta_template;
		}

		public function save_hidden_field( $post_id ) {
			// For performance.
			if (
				wp_is_post_revision( $post_id )
				|| (
					defined( 'DOING_CRON' )
					&& DOING_CRON
				)
			) {
				return;
			}

			$current_value = get_post_meta( $post_id, self::$field_key, true );

			// Cleanup after v1.0.0 possibly saving errant value.
			if ( 'hidden' === $current_value ) {
				$current_value = false;
			}

			$new_value = tribe_get_request_var( self::$field_key, '' );

			// Keep database clean, not saving empty meta values.
			if (
				! empty( $current_value )
				&& empty( $new_value )
			) {
				delete_post_meta( $post_id, self::$field_key );

				return;
			}

			// Avoid unnecessary database writes.
			if (
				! empty( $current_value )
				&& $new_value !== $current_value
			) {
				update_post_meta( $post_id, self::$field_key, $new_value );

				return;
			}

			// Set initial value.
			if (
				empty( $current_value )
				&& ! empty( $new_value )
			) {
				update_post_meta( $post_id, self::$field_key, $new_value );

				return;
			}
		}

		public function override_additional_fields_template( $file ) {
			$file_path = dirname( __FILE__ ) . '/src/views/additional-fields.php';

			if ( file_exists( $file_path ) ) {
				return $file_path;
			} else {
				return $file;
			}
		}

		public function filter_additional_fields( $data ) {
			$hidden_fields     = get_post_meta( get_the_ID(), self::$field_key, true );
			$additional_fields = tribe_get_option( 'custom-fields', false );
			$labels            = wp_list_pluck( $additional_fields, 'label', 'name' );

			if ( '' === $hidden_fields ) {
				// Cleanup after v1.0.0 saving meta field as empty value.
				delete_post_meta( get_the_ID(), self::$field_key );
			} elseif (
				tribe_is_event()
				&& is_array( $hidden_fields )
				&& ! empty( $hidden_fields )
			) {
				foreach ( $hidden_fields as $field ) {
					// Exact match.
					$field_label = $labels[ $field ];
					unset( $data[ $field_label ] );

					// Handle $data having HTML entities but $additional_fields being raw value, such as `&#039;` vs `'`.
					$field_label = esc_html( $field_label );
					unset( $data[ $field_label ] );
				}
			}

			return apply_filters( 'tribe_ext_hide_additional_fields_filtered_data', $data );
		}

		public function community_events_support() {
			$allow_ce_fields = apply_filters( 'tribe_community_events_hidden_fields', true );
			if ( $allow_ce_fields ) {
				include 'src/views/community-field-options.php';
			}
		}
	} // end class
} // end if class_exists check
