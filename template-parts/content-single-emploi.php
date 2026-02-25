<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chichi
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-meta-job-wrapper">
		<header class="entry-header">
			<?php if ( is_single() ) { ?>
			
			<div class="entry-meta">
			
				<div class="" style="position: relative;">
					<h3><?php echo get_the_title(); ?></h3>
					<div class="" style="position: absolute; right: 0; top: 5px; display: flex;">
                        <?php $current_user = wp_get_current_user(); ?>
		                <?php $user_meta = get_userdata($current_user->ID); ?>
		                <?php $user_role = $user_meta->roles[0]; ?>
		                <?php if($user_role == 'um_employeur'){ ?>
						<div class="draft-or-publish">
						<?php if ( get_post_status () === 'publish' ) { ?>
							<div class="draft-job-emplois" data-object-id="<?php the_ID(); ?>">
								<span class="material-icons">archive</span>
							</div>
						</div>
						<?php } elseif ( get_post_status () === 'draft' ) { ?>
							<button class="job-draft-to-publish" data-object-id="<?php the_ID(); ?>">Publier</button>
						</div>
						<?php } ?>
						<div class="delete-job-emplois" data-object-id="<?php the_ID(); ?>">
							<span class="material-icons">delete</span>
						</div>
						<?php } ?>
					</div>
				</div>
				
			</div>
					
			<?php } ?>
	
		</header><!-- .entry-header -->
	
		<div class="entry-meta-employer-info" style="padding-bottom:15px;">
		
		    <?php $user_id = get_post_field ('post_author', get_the_ID());
		    $get_user_by_username = get_user_by('id', $user_id);
	
		    um_fetch_user( $user_id );
		    echo '<a href="'. get_site_url() .'/employeur/?user='.  $get_user_by_username->user_nicename .'">' . $get_user_by_username->user_nicename . '</a>';
		    echo ' - ';
		    echo um_user('name_org');
		    echo ' - ';
	 	    echo um_user('first_name');
	 	    echo ' ';
		    echo um_user('last_name');
		    echo ' - ';
	 	    echo um_user('user_email');
		    echo '<br>';
		    echo um_user('Adresse');
		    echo ' - ';
		    echo um_user('Province');
		    echo ' - ';
		    echo um_user('Pays');
		    echo ' - ';
		    echo um_user('Code_postal');
		    echo ' - ';
		    echo um_user('number_phone');
		    if(!um_user('poste') == ''){
			    echo ' - ';
			    echo um_user('poste');
		    }
		    um_reset_user(); ?>
		    
		</div> 
		
		<div class="entry-meta-job-adresse" style="padding-bottom:15px;">
		
			<?php echo get_post_meta( get_the_ID(), 'my_code_postal_key', true ); ?>
			
			<?php $usermetadata = get_user_meta(get_current_user_id());
			$field_data = $usermetadata['Code_postal']; 
			 
			echo '<span class="autocompleteDeparture">';
				echo '<span class="autocompleteDeparture_0" style="display: none;">'. implode($field_data) . '</span>';
				echo '<span class="autocompleteArrival_0" style="display: none;">' . get_post_meta(get_the_ID() , 'my_code_postal_key', true ) . '</span>';
				echo ' - <span class="distance_0"></span>'; 
			echo '</span>';
			
			echo '<br>';
			
			echo get_post_meta( get_the_ID(), 'my_city_key', true );
			
			?>
		
		</div>
		
		<div class="entry-meta" style="padding-bottom:15px;">
		
			<?php the_content(); ?>
		
		</div>
		
		<?php $userid = get_current_user_id();
		$current_user = wp_get_current_user();
		$user_meta = get_userdata($current_user->ID);
		$user_role = $user_meta->roles[0];
		if($user_role == 'employer'){ ?>
			<div class="entry-meta-apply" style="padding-bottom:15px;">
				<button id="ns_submit" name="ns_submit" class="ns-btn ns-btn-primary ns-btn-ticket" style="padding-top: 15px;" data-object-id="<?php the_ID(); ?>">
					<?php esc_html_e( 'Postuler', 'monemploi' ); ?>
				</button>	
			</div>
		<?php } ?>
		
		<div class="entry-meta-allready" style="padding-bottom:15px;"><?php
		
			$get_candidacys_args = array( 
				'post_type' => 'candidacy',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'meta_key' => 'my_postid_key',
				'meta_value' => get_the_ID(),
				'orderby'        => 'date',
				'order' => 'DESC'
			);
		
			$get_candidacys = get_posts( $get_candidacys_args );
			
			echo count($get_candidacys);
			if(count($get_candidacys) > 2){ 
				echo ' candidas qui ont postuler';
			} else { 
				echo ' candida qui ont postuler';
			}
					
		?></div>
	    
		<?php
		
		echo '<div class="entry-meta-education" style="padding-bottom:15px;">';
		    	$salaire = get_post_meta( get_the_ID(), 'my_salaire_key', true );
			echo $salaire . '$ de lheure';
		echo '</div>';	
		
		echo '<div class="entry-meta-education" style="padding-bottom:15px;">';
			$education_id = get_post_meta( get_the_ID(), 'my_education_key', true );
			$term = get_term( $education_id );
			echo $term->name;
		echo '</div>';
		
	    	echo '<div class="entry-meta-annees_dexperience" style="padding-bottom:15px;">';
		    	$annees_dexperience = get_post_meta( get_the_ID(), 'my_annees_dexperience_key', true );	
		    	
		    	if($annees_dexperience == 1){
				echo 'Auccun';
			} elseif($annees_dexperience == 2){
				echo '1 an';
			} elseif($annees_dexperience == 3){
				echo '4-5 ans';
			} elseif($annees_dexperience == 4){
				echo '2-3 ans';
			} elseif($annees_dexperience == 5){
				echo '6-9 ans';
			} elseif($annees_dexperience == 6){
				echo '10 ans+';
			}
		echo '</div>';
	echo '</div>';

?>

</article><!-- #post-## -->