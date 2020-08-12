<?php

// Support hiding Event Additional Information Fields via the Community Events add/edit form.

$fields = tribe_get_option( 'custom-fields' );
$hidden = get_post_meta( get_the_ID(), Tribe__Extension__Hide_Additional_Fields::$field_key, true );

do_action( 'tribe_before_community_hidden_fields' );
?>

	<div class="community-hidden-fields">
		<table class="tribe-section-content">
			<colgroup>
				<col class="tribe-colgroup tribe-colgroup-label">
				<col class="tribe-colgroup tribe-colgroup-field">
			</colgroup>
			<tr class="tribe-section-content-row tribe-field-type-checkbox">
				<td class="tribe-section-content-label">
					<label for="<?php echo Tribe__Extension__Hide_Additional_Fields::$field_key; ?>>"><?php esc_html_e( 'Hide fields:', 'tribe-ext-hide-additional-fields' ); ?></label>
				</td>
				<td class="tribe-section-content-field">
					<?php foreach ( $fields as $field ) :
						$field_name = esc_attr( $field['name'] ); ?>
						<label>
							<input
								type="checkbox"
								value="<?php echo $field_name; ?>"
								<?php checked( is_array( $hidden ) && in_array( $field_name, $hidden ) ); //update this to check the meta
								?>
								name="<?php echo Tribe__Extension__Hide_Additional_Fields::$field_key; ?>>[]"
							>
							<?php echo stripslashes( $field['label'] ); ?>
						</label>
					<?php endforeach; ?>
				</td>
			</tr>
		</table>
	</div>

<?php do_action( 'tribe_after_community_hidden_fields' );