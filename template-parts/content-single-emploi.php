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
					<h2 style="font-weight: 900;" style="width: auto%;"><?php echo get_the_title(); ?></h2>
					<div class="" style="position: absolute; right: 0; top: 5px; display: flex; width: auto%;">
                        <?php $current_user = wp_get_current_user(); ?>
		                <?php $user_meta = get_userdata($current_user->ID); ?>
		                <?php $user_role = $user_meta->roles[0]; ?>
		                <?php if($user_role == 'employeur'){ ?>
                            <div class="edit-job-emplois">
                                <a href="<?php echo get_site_url(); ?>/ajouter-un-emploi/?postid=<?php the_ID(); ?>"><span class="material-icons">edit</span></a>
							</div>
						<?php if ( get_post_status () === 'publish' ) { ?>
							<div class="draft-job-emplois" data-object-id="<?php the_ID(); ?>">
								<span class="material-icons">archive</span>
							</div>
						<?php } elseif ( get_post_status () === 'draft' ) { ?>
							<div class="job-draft-to-publish" data-object-id="<?php the_ID(); ?>">
								<span class="material-icons">publish</span>
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
		
		<?php $start_job_scheduled = get_post_meta( get_the_ID(), 'my_start_job_scheduled_key', true); ?>
		<?php $end_job_scheduled = get_post_meta( get_the_ID(), 'my_end_job_scheduled_key', true); ?>
		
		<?php $publish_start_date = date('Y-m-d H:i:s', $start_job_scheduled); ?>
		<?php $publish_end_date = date('Y-m-d H:i:s', $end_job_scheduled); ?>
			
		<?php $strtotime_now = date('Y-m-d H:i:s', current_time('timestamp'));  ?>
				
		<div class="entry-meta-scheduled-info">
	    			
	    		<?php if ($start_job_scheduled != '' && $end_job_scheduled != ''){ ?>
	    			<p style="font-weight: 900; ">Début et fin de l&#39;annonce</p>
    			<?php } ?>
    			
    			<?php if ($start_job_scheduled != ''){ ?>
	    			<span>Date et heure du début de l&#39;annonce</span>
	    			<br>
	    			<?php echo get_the_date('Y-m-d H:i:s'); ?>
	    			<br>
    			<?php } ?>
    			   
    			<?php if ($end_job_scheduled != ''){ ?>
	    			<span>Date et heure de la fin de l&#39;annonce</span>
	    			<br>
	    			<?php echo $publish_end_date ?>
	    			<br>
    			<?php } ?>
    			
    			<?php $getmodifieddate = get_the_modified_date('Y-m-d H:i:s'); ?>
    			<?php if($getmodifieddate != ''){ ?>
	    			<span>Date et heure de la derniere modification de l&#39;annonce</span>
	    			<br>
		    		<?php echo get_the_modified_date('Y-m-d H:i:s'); ?>
		    		<br>
		    	<?php } ?>
		
		</div>
	
		<div class="entry-meta-employer-info" style="padding-bottom:15px;">
		
		    <p style="font-weight: 900; ">Coordonner de l&#39;employeur</p>
		
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
		
			<p style="font-weight: 900;">Adresse de l&#39;emploi</p>
		
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
		
			<p style="font-weight: 900;">Description de l&#39;emploi</p>
		
			<?php the_content(); ?>
		
		</div>
		
		<p style="font-weight: 600;">Postulé sur l&#39;emploi</p>
		
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
		
		echo '<p style="font-weight: 600;">Salaire</p>';
		echo '<div class="entry-meta-education" style="padding-bottom:15px;">';
		    	$salaire = get_post_meta( get_the_ID(), 'my_salaire_key', true );
		    	$nombre_dheures = get_post_meta( get_the_ID(), 'my_add_heures_key', true );
			echo $salaire . '$ de l&#39;heure.';
			echo '<br>';
			echo $nombre_dheures * $salaire . '$ par semaine.';
			echo '<br>';
			echo ($nombre_dheures * $salaire) * 2 . '$ par 2 semaines.';
			echo '<br>';
			echo ($nombre_dheures * $salaire) * 52 . '$ par année.';
			
		echo '</div>';	
		
		echo '<p style="font-weight: 600;">Niveaux d&#39;éducation</p>';
		echo '<div class="entry-meta-education" style="padding-bottom:15px;">';
			$education_id = get_post_meta( get_the_ID(), 'my_education_key', true );
			$term = get_term( $education_id );
			echo $term->name;
		echo '</div>';
		
		echo '<p style="font-weight: 600;">Année d&#39;experiance</p>';
	    	echo '<div class="entry-meta-annees_dexperience" style="padding-bottom:15px;">';
		    	$annees_dexperience = get_post_meta( get_the_ID(), 'my_annees_dexperience_key', true );	
		    	
		    	if($annees_dexperience == 1){
				echo 'Auccun';
			} elseif($annees_dexperience == 2){
				echo '1 an';
			} elseif($annees_dexperience == 3){
				echo '2-3 ans';
			} elseif($annees_dexperience == 4){
				echo '4-5 ans';
			} elseif($annees_dexperience == 5){
				echo '6-9 ans';
			} elseif($annees_dexperience == 6){
				echo '10 ans+';
			}
		echo '</div>';
		
		echo '<p style="font-weight: 600;">Nombre d&#8216;heures par semaine</p>';
		echo '<div class="entry-meta-nombre-dheures" style="padding-bottom:15px;">';
		    	$nombre_dheures = get_post_meta( get_the_ID(), 'my_add_heures_key', true );
		    	echo $nombre_dheures . 'h par semaine';	
		echo '</div>';
		
		echo '<p style="font-weight: 600;">Type d&#8216;emploi</p>';
		echo '<div class="entry-meta-type-demploi" style="padding-bottom:15px;">';
		    	$type_demploi = get_post_meta( get_the_ID(), 'my_type_demploi_key', true );
		    	if($type_demploi == 1){
		    		echo 'Temps plein';
		    	}elseif($type_demploi == 2){
		    		echo 'Temps partiel';
		    	}
		echo '</div>';
		
		echo '<p style="font-weight: 600;">Type d&#8216;horaire</p>';
		echo '<div class="entry-meta-type-dhoraire" style="padding-bottom:15px;">';
		    	$type_dhoraire = get_post_meta( get_the_ID(), 'my_type_dhoraire_key', true );
		    	if($type_dhoraire == 1){
		    		echo 'Jour';
		    	}elseif($type_dhoraire == 2){
		    		echo 'Soire';
		    	}elseif($type_dhoraire == 3){
		    		echo 'Nuit';
		    	}
		echo '</div>';
		
		echo '<p style="font-weight: 600;">Type de disponibilités</p>';
		echo '<div class="entry-meta-type-disponibilites" style="padding-bottom:15px;">';
		    	$disponibilites1 = get_post_meta( get_the_ID(), 'my_disponibilites1_key', true );
		    	$disponibilites2 = get_post_meta( get_the_ID(), 'my_disponibilites2_key', true );
		    	if($disponibilites1 == 1){
		    		echo 'Semaine';
		    		echo '<br>';
		    	}
		    	if($disponibilites2 == 1){
		    		echo 'Fin de semaine';
		    	}
		echo '</div>';
		
		
		echo '<p style="font-weight: 600;">Durée de l&#8216;emploi</p>';
		echo '<div class="entry-meta-type-dhoraire" style="padding-bottom:15px;">';
		    	$duree_emploi = get_post_meta( get_the_ID(), 'my_duree_emploi_key', true );
		    	if($duree_emploi == 1){
		    		echo 'Permanent';
		    	}elseif($duree_emploi == 2){
		    		echo 'Contrat';
		    	}elseif($duree_emploi == 3){
		    		echo 'Sur appel';
		    	}
		echo '</div>';
		
		
		echo '<p style="font-weight: 600;">Besoin d&#8216;un permis de conduire</p>';
		echo '<div class="entry-meta-type-dhoraire" style="padding-bottom:15px;">';
		    	$permis_conduire = get_post_meta( get_the_ID(), 'my_permis_conduire_key', true );
		    	if($permis_conduire == 1){
		    		echo 'Non';
		    	}elseif($permis_conduire == 2){
		    		echo 'Oui';
		    	}
		echo '</div>';
		
		
		echo '<p style="font-weight: 600;">Besoin d&#8216;une voiture</p>';
		echo '<div class="entry-meta-type-dhoraire" style="padding-bottom:15px;">';
		    	$besoin_voiture = get_post_meta( get_the_ID(), 'my_besoin_voiture_key', true );
		    	if($besoin_voiture == 1){
		    		echo 'Non';
		    	}elseif($besoin_voiture == 2){
		    		echo 'Oui';
		    	}
		echo '</div>';
		
	echo '</div>';

?>

</article><!-- #post-## -->
