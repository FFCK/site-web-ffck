<?php if ( ! is_tax( 'job_listing_type' ) && empty( $job_types ) ) : ?>
	<ul class="job_types">
		<?php foreach ( get_job_listing_types() as $type ) : ?>
			<li>
        <label for="job_type_<?php echo $type->slug; ?>" class="<?php echo sanitize_title( $type->name ); ?>">
          <input type="checkbox" name="filter_job_type[]" value="<?php echo $type->slug; ?>" <?php checked( in_array( $type->slug, $selected_job_types ), true ); ?> id="job_type_<?php echo $type->slug; ?>" />
            <?php
              if ($type->slug == 'cel') { echo 'Course en Ligne'; }
              else if ($type->slug == 'drb') { echo 'Dragon Boat'; }
              else if ($type->slug == 'kap') { echo 'Kayak-Polo'; }
              else if ($type->slug == 'man') { echo 'Multi-activités nautiques'; }
              else if ($type->slug == 'mar') { echo 'Marathon'; }
              else if ($type->slug == 'rec') { echo 'Randonnée en eau calme'; }
              else if ($type->slug == 'rev') { echo 'Randonnée en eau vive'; }
              else if ($type->slug == 'des') { echo 'Descente'; }
              else if ($type->slug == 'khr') { echo 'Kayak haute rivière'; }
              else if ($type->slug == 'nev') { echo 'Nage en eau vive'; }
              else if ($type->slug == 'raf') { echo 'Raft'; }
              else if ($type->slug == 'fre') { echo 'Freestyle'; }
              else if ($type->slug == 'sla') { echo 'Slalom'; }
              else if ($type->slug == 'rem') { echo 'Randonnée en mer'; }
              else if ($type->slug == 'ocr') { echo 'Ocean-Racing'; }
              else if ($type->slug == 'vaa') { echo 'Va\'a'; }
              else if ($type->slug == 'was') { echo 'Waveski-Surfing'; }
              else if ($type->slug == 'vav') { echo 'Va\'a Vitesse'; }
              else if ($type->slug == 'par') { echo 'Paracanoë'; }
              else if ($type->slug == 'msr') { echo 'Multisports et Raids'; }
              else {
                echo 'Inconnu';
              }
            ?>
        </label>
      </li>
		<?php endforeach; ?>
	</ul>
	<input type="hidden" name="filter_job_type[]" value="" />
<?php elseif ( $job_types ) : ?>
	<?php foreach ( $job_types as $job_type ) : ?>
		<input type="hidden" name="filter_job_type[]" value="<?php echo sanitize_title( $job_type ); ?>" />
	<?php endforeach; ?>
<?php endif; ?>