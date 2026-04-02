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
	<?php if($_GET['apply'] == null || $_GET['apply'] == false) { ?>
		<div class="entry-meta-job-wrapper">
			<header class="entry-header">
				<?php if ( is_single() ) { ?>
				
				<div class="entry-meta">
				
					<div class="" style="position: relative;">
						<h2 style="font-weight: 900;" style="width: auto;"><?php echo get_the_title(); ?></h2>
						<div class="" style="position: absolute; right: 0; top: 5px; display: flex; width: auto;">
			                        <?php $current_user = wp_get_current_user(); ?>
				                <?php $user_meta = get_userdata($current_user->ID); ?>
				                <?php $user_role = $user_meta->roles[0]; ?>
				                <?php if($user_role == 'employeur'){ ?>
	                           			 <div class="edit-job-emplois">
	                                			<a href="<?php echo get_site_url(); ?>/ajouter-un-emploi/?postid=<?php the_ID(); ?>"><span class="material-icons">edit</span></a>
							</div>
							<div class="draft-or-publish">
								<?php if ( get_post_status () === 'publish' ) { ?>
									<div class="draft-job-emplois" data-object-id="<?php the_ID(); ?>">
										<span class="material-icons">archive</span>
									</div>
								<?php } elseif ( get_post_status () === 'draft' ) { ?>
									<div class="job-draft-to-publish" data-object-id="<?php the_ID(); ?>">
										<span class="material-icons">publish</span>
									</div>
								<?php } ?>
							</div>
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
		    			
		    		<?php if (get_the_date('Y-m-d H:i:s') != '' || $end_job_scheduled != ''){ ?>
		    			<p style="font-weight: 900; ">Début et fin de l&#39;annonce</p>
	    			<?php } ?>
	    			
	    			<?php if (get_the_date('Y-m-d H:i:s') != ''){ ?>
		    			<span>Date et heure du début</span>
		    			<br>
		    			<?php echo get_the_date('Y-m-d H:i:s'); ?>
		    			<br>
	    			<?php } ?>
	    			   
	    			<?php if ($end_job_scheduled != ''){ ?>
		    			<span>Date et heure de la fin</span>
		    			<br>
		    			<?php echo $publish_end_date ?>
		    			<br>
	    			<?php } ?>
	    			
	    			<?php $getmodifieddate = get_the_modified_date('Y-m-d H:i:s'); ?>
	    			<?php if($getmodifieddate != ''){ ?>
		    			<span>Date et heure de la derniere modification</span>
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
			
			<?php
			$allready_candidacy = 0;
			
			$get_candidacys_args = array( 
				'post_type' => 'candidacy',
				'post_status'    => 'publish',
				'author'         => get_current_user_id(),
				'posts_per_page' => -1,
				'orderby'        => 'date',
				'order' => 'DESC'
			);
		
			$get_candidacys = get_posts( $get_candidacys_args );
			
			foreach($get_candidacys as $get_candidacy){
				
				$my_postid_key = get_post_meta( $get_candidacy->ID, 'my_postid_key', true );
		
				if($my_postid_key == get_the_ID()){
				
					$allready_candidacy = 1;
				
				}
			
			} 
			
			$userid = get_current_user_id();
			$current_user = wp_get_current_user();
			$user_meta = get_userdata($current_user->ID);
			$user_role = $user_meta->roles[0];
			$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://";
			$current_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			if($user_role == 'employer'){ ?>
				<?php if($allready_candidacy == 0){ ?>
					<div class="entry-meta-apply" style="padding-bottom:15px;">
						<button id="ns_submit" name="ns_submit" class="ns-btn ns-btn-primary ns-btn-ticket" style="padding-top: 15px;" data-object-id="<?php the_ID(); ?>">
							<a href="<?php echo $current_url ?>?apply=true"><?php esc_html_e( 'Postuler', 'monemploi' ); ?></a>
						</button>
							
					</div>
				<?php } else { ?>
					<p><?php esc_html_e( 'Vous avez deja postulé sur cette emploi.', 'monemploi' ); ?></p>
				<?php } ?>
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
			
			echo '<p style="font-weight: 600;">Type d&#8216;activité professionnelle</p>';
			echo '<div class="entry-meta-type-demploi" style="padding-bottom:15px;">';
			    	$activite_professionnelle = get_post_meta( get_the_ID(), 'my_activite_professionnelle_key', true );
			    	if($activite_professionnelle == 1){
			    		echo 'Travail en présentiel';
			    	}elseif($activite_professionnelle == 2){
			    		echo 'Télétravail';
			    	} elseif ($activite_professionnelle == 3){
			    		echo 'Mode hybride';
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
			    	$disponibilites = get_post_meta( get_the_ID(), 'my_disponibilites_key', true );
			    	foreach ( $disponibilites as $key => $values ) {
				    	if($key == 'week' && $values == 1){
				    		echo 'Semaine';
				    		echo '<br>';
				    	}
				    	if($key == 'weekend' && $values == 1){
				    		echo 'Fin de semaine';
				    	}
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
	} elseif($_GET['apply'] == true) {
	
		$allready_candidacy = 0;
		
		$get_candidacys_args = array( 
			'post_type' => 'candidacy',
			'post_status'    => 'publish',
			'author'         => get_current_user_id(),
			'posts_per_page' => -1,
			'orderby'        => 'date',
			'order' => 'DESC'
		);
	
		$get_candidacys = get_posts( $get_candidacys_args );
		
		foreach($get_candidacys as $get_candidacy){
			
			$my_postid_key = get_post_meta( $get_candidacy->ID, 'my_postid_key', true );
	
			if($my_postid_key == get_the_ID()){
			
				$allready_candidacy = 1;
			
			}
		
		} 
	
                $current_user = wp_get_current_user();
                $user_meta = get_userdata($current_user->ID);
                $user_role = $user_meta->roles[0];
                if($user_role == 'employer'){
			echo '<div class="entry-meta-job-apply-wrapper">';
				echo '<h2 style="font-weight: 900;" style="width: auto;">' . get_the_title() . '</h2>';
				
				echo '<br />';
				
				?>
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
				
				</div><?php
				if($allready_candidacy == 0){
					echo'<div class="entry-meta-job-question-wrapper">';
					
						echo '<h3>Questions liées à la candidature</h3>';
					
						echo '<p style="font-weight: 600;">Est-ce que vous avez l&#8216;âge légal pour travailler au Canada?</p>';
						echo '<select name="age_legal" class="age_legal" id="age_legal">';
							echo '<option value="0">' . esc_html( 'Choisissez une valeur' , 'monemploi' ) , '</option>';
							echo '<option value="1">' . esc_html( 'Oui' , 'monemploi' ) , '</option>';
							echo '<option value="2">' . esc_html( 'Non' , 'monemploi' ) , '</option>';
						echo '</select>';
						
						echo '<br />';
						
						echo '<p style="font-weight: 600;">Concernant votre situation au Canada, détenez-vous</p>';
						echo '<select name="situation_canada" class="situation_canada" id="situation_canada">';
							echo '<option value="0">' . esc_html( 'Choisissez une valeur' , 'monemploi' ) , '</option>';
							echo '<option value="1">' . esc_html( 'La citoyenneté canadienne' , 'monemploi' ) , '</option>';
							echo '<option value="2">' . esc_html( 'La résidence permanente au canada' , 'monemploi' ) , '</option>';
							echo '<option value="3">' . esc_html( 'Un permis de travail valide au canada' , 'monemploi' ) , '</option>';
							echo '<option value="4">' . esc_html( 'Aucun de ces éléments' , 'monemploi' ) , '</option>';
						echo '</select>';
						
						echo '<br />';
						
						echo '<div class="permis_travail_wrapper" style="display: none;">';
							echo '<p style="font-weight: 600;">Si vous détenez un permis de travail, quel type de permis avez-vous</p>';
							echo '<select name="permis_travail" class="permis_travail" id="permis_travail">';
								echo '<option value="0">' . esc_html( 'Choisissez une valeur' , 'monemploi' ) , '</option>';
								echo '<option value="1">' . esc_html( 'Permis fermé avec votre employeur actuel' , 'monemploi' ) , '</option>';
								echo '<option value="2">' . esc_html( 'Permis ouvert' , 'monemploi' ) , '</option>';
								echo '<option value="3">' . esc_html( 'Permis ouvert lie au statut d&#8216;un autre personne' , 'monemploi' ) , '</option>';
								echo '<option value="4">' . esc_html( 'Permis d&#8216;etudes international' , 'monemploi' ) , '</option>';
								echo '<option value="5">' . esc_html( 'Autre (demandeur d&#8216;asile, visiteur)' , 'monemploi' ) , '</option>';
							echo '</select>';
						echo '</div>';
						
						echo '<br />';
						
						echo '<p style="font-weight: 600;">Avez-vous déjà travaillé pour l&#8216;employeur ou l&#8216;une de ses sociétés affiliées?</p>';
						echo '<select name="deja_travaille" class="deja_travaille" id="deja_travaille">';
							echo '<option value="0">' . esc_html( 'Choisissez une valeur' , 'monemploi' ) , '</option>';
							echo '<option value="1">' . esc_html( 'Oui' , 'monemploi' ) , '</option>';
							echo '<option value="2">' . esc_html( 'Non' , 'monemploi' ) , '</option>';
						echo '</select>';
						
						echo '<br />';
						
						echo '<h3>Équité en emploi</h3>';
						
						echo '<br />';
						
						echo '<p style="font-weight: 600;">Sexe à la naissance</p>';
						echo '<select name="sexe" class="sexe" id="sexe">';
							echo '<option value="0">' . esc_html( 'Choisissez une valeur' , 'monemploi' ) , '</option>';
							echo '<option value="1">' . esc_html( 'Masculin' , 'monemploi' ) , '</option>';
							echo '<option value="2">' . esc_html( 'Féminin' , 'monemploi' ) , '</option>';
						echo '</select>';
						
						echo '<br />';
						
						echo '<p style="font-weight: 600;">Origine ethnique</p>';
						echo '<select name="origine_ethnique" class="origine_ethnique" id="origine_ethnique">';
							echo '<option value="0">' . esc_html( 'Choisissez une valeur' , 'monemploi' ) , '</option>';
							echo '<option value="1">' . esc_html( 'Nord-américaines' , 'monemploi' ) , '</option>';
							echo '<option value="2">' . esc_html( 'Européennes' , 'monemploi' ) , '</option>';
							echo '<option value="3">' . esc_html( 'Caraïbes' , 'monemploi' ) , '</option>';
							echo '<option value="4">' . esc_html( 'Amérique latine - centrale et du Sud' , 'monemploi' ) , '</option>';
							echo '<option value="5">' . esc_html( 'Africaines' , 'monemploi' ) , '</option>';
							echo '<option value="6">' . esc_html( 'Asiatiques' , 'monemploi' ) , '</option>';
							echo '<option value="7">' . esc_html( 'Océanie' , 'monemploi' ) , '</option>';
							echo '<option value="8">' . esc_html( 'Autres origines ethniques et culturelles' , 'monemploi' ) , '</option>';
						echo '</select>';
						
						echo '<br />';
						
						echo '<p style="font-weight: 600;">Identification comme Autochtone</p>';
						echo '<select name="autochtone" class="autochtone" id="autochtone">';
							echo '<option value="0">' . esc_html( 'Choisissez une valeur' , 'monemploi' ) , '</option>';
							echo '<option value="1">' . esc_html( 'Ne souhaite pas repondre' , 'monemploi' ) , '</option>';
							echo '<option value="2">' . esc_html( 'Oui' , 'monemploi' ) , '</option>';
							echo '<option value="3">' . esc_html( 'Non' , 'monemploi' ) , '</option>';
						echo '</select>';
						
						echo '<br />';
						
						echo '<p style="font-weight: 600;">Personne en situation d&#8216;handicap</p>';
						echo '<select name="handicap" class="handicap" id="handicap">';
							echo '<option value="0">' . esc_html( 'Choisissez une valeur' , 'monemploi' ) , '</option>';
							echo '<option value="1">' . esc_html( 'Ne souhaite pas repondre' , 'monemploi' ) , '</option>';
							echo '<option value="2">' . esc_html( 'Oui' , 'monemploi' ) , '</option>';
							echo '<option value="3">' . esc_html( 'Non' , 'monemploi' ) , '</option>';
						echo '</select>';
						
						echo '<br />';
						
						echo '<div class="handicap_wrapper" style="display: none;">';
							echo '<p style="font-weight: 600;">Si vous avez un handicap, expliquer le</p>';
							echo '<input type="text" name="handicap_" class="handicap_" id="handicap_">';
						echo '</div>';
			
							// Arguments to query media attachments
						$args = array(
						    'post_type'      => 'attachment',
						    'post_mime_type' => array('application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/msword'),
						    'post_status'    => 'inherit',
						    'author'         => get_current_user_id(),
						    'posts_per_page' => -1,
						    'orderby'        => 'date',
						    'order'          => 'DESC'
						);
						
						// Get the attachments
						$attachments = get_posts( $args );
						
						if ( $attachments ) {
						    echo '<h3>Vos documents</h3>';
						    echo '<ul class="cv-table-wrapper">';
						    
						    foreach ( $attachments as $attachment ) {
						        // Get the URL of the media file
						        $file_url = wp_get_attachment_url( $attachment->ID );
						        // Get the title
						        $file_title = apply_filters( 'the_title', $attachment->post_title );
						
						        echo '<li>';
						        
						        	echo '<input type="checkbox" id="cv" name="cv" class="cv" value="' . $attachment->ID . '">';
						        	echo ' - ';
						        	echo '<a href="' . esc_url( $file_url ) . '">' . esc_html( $file_title ) . '</a>';
						        
						        echo '</li>';
						    }
						
						    echo '</ul>';
						}
						
						echo '<h3>Votre lettre de présentation</h3>';
						echo '<textarea id="lettre_reference" name="lettre_presentation" class="lettre_presentation" rows="5" cols="30">';
						echo '</textarea>';
						echo '<br />';
						echo '<button class="submit_cv" data-object-id="' . get_the_ID() . '">Soumettre</button>';
						
					echo '</div>';
					
				} else {
	
					echo '<p>Vous avez deja postulé sur cette offre.</p>';
				
				}
						
			echo '</div>';
		} else {
		
			echo '<h2>Vous n&#8216;avez pas l&#8216;autorisation pour consulter cette page</h2>';
		
		}
		
	}

?>

</article><!-- #post-## -->