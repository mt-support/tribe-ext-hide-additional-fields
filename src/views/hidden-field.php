<td>
	<div>
		<?php
		$hidden     = (array) get_post_meta( get_the_ID(), Tribe__Extension__Hide_Additional_Fields::$field_key, true );
		$field_name = esc_attr( $customField['name'] );

		/**
		 * Allow filtering whether the checkboxes should be checked by default.
		 *
		 * @since 1.1.0
		 *
		 * @var bool $start_hidden
		 */
		$start_hidden = (booL) apply_filters( 'tribe_ext_hide_additional_fields_default_hidden', false );

		if (
			$start_hidden
			&& 'auto-draft' === get_post_status()
		) {
			$hide_field_status = 'checked="checked"';
		}
		else {
			$hide_field_status = checked( in_array( $field_name, $hidden, true ), true, false );
		}
		?>
		<label style="vertical-align: top; line-height: 1em;"><?php esc_html_e( 'Hide field', 'tribe-ext-hide-additional-fields' ); ?>
			<input type="checkbox" value="<?php echo $field_name ?>" name="<?php echo Tribe__Extension__Hide_Additional_Fields::$field_key; ?>[]" <?php echo $hide_field_status ?> />
		</label>
	</div>
</td>
