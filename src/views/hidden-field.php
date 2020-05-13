<td>
	<div>
		<?php $hidden = (array) get_post_meta( get_the_ID(), 'custom-hidden', true );
		$field_name = esc_attr( $customField['name'] );
		?>
		<label><?php esc_html_e( 'Hide field', 'tribe-ext-hide-additional-fields' ); ?><input type="checkbox" value="<?php echo $field_name ?>" name="custom-hidden[]" <?php checked( in_array( $field_name, $hidden, true ) ); ?> />
		</label></div>
</td>
