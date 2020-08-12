<td>
	<div>
		<?php
		$hidden     = (array) get_post_meta( get_the_ID(), Tribe__Extension__Hide_Additional_Fields::$field_key, true );
		$field_name = esc_attr( $customField['name'] );
		?>
		<label><?php esc_html_e( 'Hide field', 'tribe-ext-hide-additional-fields' ); ?>
			<input type="checkbox" value="<?php echo $field_name ?>" name="<?php echo Tribe__Extension__Hide_Additional_Fields::$field_key; ?>[]" <?php checked( in_array( $field_name, $hidden, true ) ); ?> />
		</label>
	</div>
</td>
