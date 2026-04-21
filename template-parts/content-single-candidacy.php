<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chichi
 */
 
 if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

	<?php 
	$author_id_key = get_post_meta( get_the_ID(), 'my_author_id_key', true );
	$author_id = get_the_author_meta( 'ID' ); 
	$author_obj = get_user_by('id', $author_id);
	if (  $author_id == get_current_user_id() || $author_id_key == get_current_user_id() ) {	
	?>
	
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php if ( is_single() ) { ?>
			
			<div class="entry-meta">
				
				<h2><?php echo '<a href="' . get_permalink( get_post_meta(get_the_ID(), 'my_postid_key', true) ) . '">' . get_the_title() . '</a>'; ?></h2>
				
			</div>
					
			<?php } ?>
	
		</header><!-- .entry-header -->
		
		<?php
		
		if (isset($_GET['add_comment'])) {
		        echo "<h3>Le commentaire #". $_GET['add_comment'] ." à été ajouter.</h3>";
		}
		
		?>
		
		<div class="entry-meta-employeur-info" style="padding-bottom:15px;">
		
		    <?php 
		    echo '<h3><span class="">'. __('Coordonnées de lemployeur', 'monemploi') .'</span></h3>';
		    
		    $user_id = get_post_field ('post_author', get_post_meta(get_the_ID(), 'my_postid_key', true));
		    $get_user_by_username = get_user_by('id', $user_id);
		    
    		echo '<a href="'. get_site_url() .'/employeur/?user='.  $get_user_by_username->user_nicename .'">' . $get_user_by_username->user_nicename . '</a>';
		    echo ' - ';
		    echo $get_user_by_username->user_firstname;
		    echo ' ';
		    echo $get_user_by_username->user_lastname;
		    if(get_user_meta($user_id, 'company_key', true) != ''){
			    echo ' - ';
			    echo get_user_meta($user_id, 'company_key', true);
		    }	
		    echo '<br>';
		    echo get_user_meta($user_id, 'adresse_key', true);
		    echo ' - ';
		    echo get_user_meta($user_id, 'city_key', true);
		    echo ' - ';
		    echo get_user_meta($user_id, 'province_key', true);
		    echo ' - ';
		    echo get_user_meta($user_id, 'country_key', true);
		    echo ' - ';
		    echo get_user_meta($user_id, 'postal_code_key', true);
		    echo '<br>';
		    echo get_user_meta($user_id, 'phone_key', true);
		    if(get_user_meta($user_id, 'poste_key', true) != ''){
		    	echo ' - ';
		    	echo get_user_meta($user_id, 'poste_key', true);
		    }
		    echo ' - ';
		    echo $get_user_by_username->user_email;	    
		    echo '<br>';
		    
		    ?>
		    
		</div> 
			
		<div class="entry-meta" style="padding-bottom: 15px;">
			<?php 
			echo '<h3><span class="">'. __('Adresse du poste', 'monemploi') .'</span></h3>';
		
			echo '<span id="job-adress">' . get_post_meta( get_post_meta(get_the_ID(), 'my_postid_key', true), 'my_code_postal_key', true ) . '</span>';
			echo ' - '; 
			$usermetadata = get_user_meta($author_id);
			$field_data = $usermetadata['Code_postal']; 
					 
			echo '<span class="autocompleteDeparture">';
				echo '<span class="autocompleteDeparture_0" style="display: none;">'. implode($field_data) . '</span>';
				echo '<span class="autocompleteArrival_0" style="display: none;">' . get_post_meta( get_post_meta(get_the_ID(), 'my_postid_key', true), 'my_code_postal_key', true ) . '</span>';
				echo '<span class="distance_0"></span>'; 
			echo '</span>';					
		?></div><?php
		
		?><div class="entry-meta" style="padding-bottom: 15px;"><?php
		
			echo '<h3><span class="">'. __('Itineraire', 'monemploi') .'</span></h3>';
		
			um_fetch_user( $author_id );
			echo '<span id="user-adress" style="display: none;">' . um_user('Adresse') . ' ' . um_user('Code_postal') . '</span>';
			um_reset_user();
			$travelMode = $_GET['travelMode'];
			echo '<br>';
			echo '<button><a href="?travelMode=voiture">Voiture</a></button>';
			echo '<button><a href="?travelMode=autobus">Autobus</a></button>';
            if($travelMode == 'autobus') {
                echo '<div class="departuredate" style="display: none;">' . date("Y-m-d") . '</div>';
				echo '<input type="time" class="departuretime">';
			}
			if($travelMode == null) {
				echo '<span>Voiture</span>';
			}
			if($travelMode == 'voiture') {
				echo '<span>Voiture</span>';
			}
			if($travelMode == 'autobus') {
				echo '<span>Autobus</span>';
			}
			echo '<br>';
			echo '<div id="map" style="width: 100%; height: 520px;"></div>';
		?></div><?php
		
		echo '<div class="entry-meta" style="padding-bottom: 15px;">';
		
			echo '<h3><span class="">'. __('Date de publication', 'monemploi') .'</span></h3>';
			
			echo get_the_date( "l F j, Y", $post_id) . ' - ' . get_the_time( '', $post_id );
		
		echo '</div>';
		
		$published_date_strtotime = get_the_date('c');
		$published_date = get_the_date("l F j, Y");
	        $published_time = get_the_time();
	        $modified_date_strtotime = get_the_modified_date('c');
	       	$modified_date = get_the_modified_date("l F j, Y");
	        $modified_time = get_the_modified_time();
	        
		if(strtotime($published_date_strtotime)+1 < strtotime($modified_date_strtotime)) {    
			echo '<div class="entry-meta" style="padding-bottom: 15px;">';
		        
		        echo '<h3><span class="">'. __('Dernière mise à jour', 'monemploi') .'</span></h3>';
		        echo '<span class="last-updated">' . $modified_date . ' - ' . $modified_time . '</span>';
			
			echo '</div>';
		}
		
		echo '<div>';	
			echo '<div style="width: 100%; style="padding-bottom: 15px;">';
			
			echo '<h3><span class="">'. __('Adresse & Profile', 'monemploi') .'</span></h3>';
			
			 if ( function_exists( 'um_user_profile_url' ) ) {
			    $user_id = $author_obj->ID;
			    um_fetch_user( $user_id );
			    $profile_url = um_user_profile_url();
			    echo '<a href="' .  $profile_url . '">Adresse</a>';
			    echo ' - ';
			    echo '<a href="'. get_site_url() .'/profile/?user='. $author_obj->user_nicename .'">Profile</a>';
			    um_reset_user();
			}
			echo '</div>';
			echo '<div style="width: 100%; style="padding-bottom: 15px;">';
			
				echo '<h3><span class="">'. __('Documents', 'monemploi') .'</span></h3>';
			
				$get_cv_ = get_post_meta(get_the_ID(), 'my_cv_key', true);
			
				if($get_cv_){
					foreach( $get_cv_ as $get_cv ) {
						echo '<a href="' . wp_get_attachment_url($get_cv) . '">'. basename(wp_get_attachment_url($get_cv)) .'</a>';
						echo '<br>';
					}
				}
			
			echo '</div>';
			echo '<div>';
			
				echo '<h3><span class="">'. __('Status', 'monemploi') .'</span></h3>';
			
				$i = 0;
				
				$get_status = get_post_meta(get_the_ID(), 'candidacy_status_', true);
				
				$userid = get_current_user_id();
				$current_user = wp_get_current_user();
				$user_meta = get_userdata($current_user->ID);
				$user_role = $user_meta->roles[0];
				if($user_role == 'employeur'){
				
				if($get_status == null || $get_status == 0){
					echo '<select name="status_'. $i .'" id="status_'. $i .'" data-object-id="' . get_the_ID() . '">';
						echo '<option value="0">En attente</option>';
						echo '<option value="1">Refuser</option>';
						echo '<option value="2">Entrevu accepter</option>';
						echo '<option value="3">Embaucher</option>';
					echo '</select>';
				} else {
				
					echo '<select name="status_'. $i .'" id="status_'. $i .'" data-object-id="' . get_the_ID() . '">';
					
						if($get_status == 1 ){
						 	echo '<option value="1">Refusé</option>';
						 } elseif($get_status == 2){
						 	echo '<option value="2">Entrevue accepté</option>';
						 } elseif($get_status == 3){
						 	echo '<option value="3">Embauché</option>';
						}
						
						echo '<option value="0">En attente</option>';
						echo '<option value="1">Refuser</option>';
						echo '<option value="2">Entrevu accepter</option>';
						echo '<option value="3">Embaucher</option>';
					echo '</select>';
				}
                   
                   		echo '<button class="save_status_candidacy save_status_candidacy_'. $i . '" data-object-id="' . $i . '">Sauvegarder</button>';
                   		echo '<br>';
                   		echo '<span class="save_status_candidacy_message"></span>';
                   
				} elseif ($user_role = 'employer') {
				    
				         if($get_status == 0 || $get_status == null) {
				             echo 'En attente';
				         } elseif($get_status == 1 ){
					 	echo 'Refusé';
					 } elseif($get_status == 2){
					 	echo 'Entrevue accepté';
					 } elseif($get_status == 3){
					 	echo 'Embauché';
					}
				    
				}
			
			echo '</div>';
			
		echo '</div>';
		
		echo '<div style="width: 100%; style="padding-bottom: 15px;">';
		
			echo '<h3><span class="">'. __('Questions liées à la candidature', 'monemploi') .'</span></h3>';
			
			$age_legal = get_post_meta( get_the_ID(), 'my_age_legal_key', true );
			echo '<p style="font-weight: 400;">Est-ce que vous avez l&#8216;âge légal pour travailler au Canada?</p>';
			if($age_legal == 1){
				echo 'Oui';
			} elseif ($age_legal == 2){
				echo 'Non';
			}
			
		       	$situation_canada = get_post_meta( get_the_ID(), 'my_situation_canada_key', true );
		       	echo '<p style="font-weight: 400;">Concernant votre situation au Canada, détenez-vous</p>';
		       	if($situation_canada == 1){
				echo 'La citoyenneté canadienne';
			} elseif ($situation_canada == 2){
				echo 'La résidence permanente au canada';
			} elseif ($situation_canada == 3){
				echo 'Un permis de travail valide au canada';
			} elseif ($situation_canada == 4){
				echo 'Aucun de ces éléments';
			}
		       	
		       	$permis_travail = get_post_meta( get_the_ID(), 'my_permis_travail_key', true );
		       	if($permis_travail != 0){
		       		echo '<p style="font-weight: 400;">Si vous détenez un permis de travail, quel type de permis avez-vous</p>';
		       		if($permis_travail == 1){
					echo 'Permis fermé avec votre employeur actuel';
				} elseif ($permis_travail == 2){
					echo 'Permis ouvert';
				} elseif ($permis_travail == 3){
					echo 'Permis ouvert lie au statut d&#8216;un autre personne';
				} elseif ($permis_travail == 4){
					echo 'Permis d&#8216;etudes international';
				} elseif ($permis_travail == 5){
					echo 'Autre (demandeur d&#8216;asile, visiteur)';
				}
		       	}
		       	
		       	$deja_travaille = get_post_meta( get_the_ID(), 'my_deja_travaille_key', true );
		       	echo '<p style="font-weight: 400;">Avez-vous déjà travaillé pour l&#8216;employeur ou l&#8216;une de ses sociétés affiliées?</p>';
		       	if($deja_travaille == 1){
				echo 'Oui';
			} elseif ($deja_travaille == 2){
				echo 'Non';
			}
			
			$superieur_nom = get_post_meta( get_the_ID(), 'my_superieur_nom_key', true );
			$superieur_email = get_post_meta( get_the_ID(), 'my_superieur_email_key', true );
			$superieur_numero = get_post_meta( get_the_ID(), 'my_superieur_numero_key', true );
			$superieur_poste = get_post_meta( get_the_ID(), 'my_superieur_poste_key', true );
			if($deja_travaille == 1){
				echo '<p style="font-weight: 400;">Information du supérieur</p>';
				echo 'Nom: ' . $superieur_nom . ' - ';
				echo 'Email: ' . $superieur_email . ' - ';
				echo 'Numero: ' . $superieur_numero . ' - ';
				if($superieur_poste != ''){
					echo 'Poste: ' . $superieur_poste;
				}
			}
			
			echo '<h3><span class="">'. __('Équité en emploi', 'monemploi') .'</span></h3>';
			
		       	$sexe = get_post_meta( get_the_ID(), 'my_sexe_key', true );
		       	echo '<p style="font-weight: 400;">Sexe à la naissance</p>';
			if($sexe == 1){
				echo 'Masculin';
			} elseif ($sexe == 2){
				echo 'Féminin';
			}
		       	
		       	
		       	$origine_ethnique = get_post_meta( get_the_ID(), 'my_origine_ethnique_key', true );
		       	echo '<p style="font-weight: 400;">Origine ethnique</p>';
	       		if($origine_ethnique == 1){
				echo 'Nord-américaines';
			} elseif ($origine_ethnique == 2){
				echo 'Européennes';
			} elseif ($origine_ethnique == 3){
				echo 'Caraïbes';
			} elseif ($origine_ethnique == 4){
				echo 'Amérique latine - centrale et du Sud';
			} elseif ($origine_ethnique == 5){
				echo 'Africaines';
			} elseif ($origine_ethnique == 6){
				echo 'Asiatiques';
			} elseif ($origine_ethnique == 7){
				echo 'Océanie';
			} elseif ($origine_ethnique == 8){
				echo 'Autres origines ethniques et culturelles';
			}
		       	
		       	$autochtone = get_post_meta( get_the_ID(), 'my_autochtone_key', true );
		       	echo '<p style="font-weight: 400;">Identification comme Autochtone</p>';
			if($autochtone == 1){
				echo 'Ne souhaite pas repondre';
			} elseif ($autochtone == 2){
				echo 'Oui';
			} elseif ($autochtone == 3){
				echo 'Non';
			}
		       	
		       	$handicap = get_post_meta( get_the_ID(), 'my_handicap_key', true );
		       	echo '<p style="font-weight: 400;">Personne en situation d&#8216;handicap</p>';
			if($handicap == 1){
				echo 'Ne souhaite pas repondre';
			} elseif ($handicap == 2){
				echo 'Oui';
			} elseif ($handicap == 3){
				echo 'Non';
			}
		       	
		       	$handicap_ = get_post_meta( get_the_ID(), 'my_handicap__key', true );
			if($handicap == 2){
				if($handicap_ != ''){
					echo '<p style="font-weight: 400;">Si vous avez un handicap, expliquer le</p>';
					echo $handicap_;
				}
			}
			
			echo '<h3><span class="">'. __('J&#8216;accepte la déclaration de confidentialité', 'monemploi') .'</span></h3>';
			
			$confidentialite = get_post_meta( get_the_ID(), 'my_confidentialite_key', true );
			if($confidentialite == 1){
				echo 'Oui';
			} elseif ($confidentialite == 0){
				echo 'Non';
			}
		
		echo '</div>';
		
		echo '<div style="width: 100%; style="padding-bottom: 15px;">';
		
			echo '<h3><span class="">'. __('Lettre de presentation', 'monemploi') .'</span></h3>';
			
			$my_lettre_presentation = get_post_meta( get_the_ID(), 'my_lettre_presentation_key', true );
		
			echo wpautop($my_lettre_presentation);
		
		echo '</div>';
				
		$args = array(
			'post_id'   	=> get_the_ID(),
			'post_type' 	=> 'candidacy',
			'status'    	=> 'approve',
			'order'     	=> 'ASC'
		);
		$response_array = get_comments( $args );
				
		echo '<div class="candidacy-responses" style="padding-bottom: 15px;">';
				   			    
			    	$counter = 0;
				
				echo '<h3><span class="candidacy-response-header">'. __('Réponses', 'monemploi') .'</span></h3>';
	
				echo '<div class="candidacy-response-cards" data-object-id="' . get_the_ID() . '">';

				if( $response_array ) {	
	
				        foreach( $response_array as $response ) {
				        
				  		$ramdonstring = generate_secure_string();
							
			        	?>
		
							<div class="candidacy-response-cards-wrapper <?php echo $ramdonstring; ?>">
								<div class="ns-row">
									<div class="ns-col-sm-9">
										<div class="response-head" style="display: flex;">
											<h3 class="ticket-head" id="response-<?php echo esc_attr($counter); ?>" style="width: calc(100% - 25px);">
												<?php $userid = $response->user_id; ?>
												<?php $user_meta = get_userdata($userid); ?>
												<?php $user_role = $user_meta->roles[0]; ?>
												<?php if($user_role == 'employeur'){ ?>
													<a href="<?php get_site_url(); ?>/employeur/?user=<?php echo $user_meta->user_login ?>"><?php echo $response->comment_author; ?></a> - <?php echo get_user_meta($user_meta->ID, 'company_key', true); ?>
												<?php } elseif($user_role == 'employer'){ ?>
													<a href="<?php get_site_url(); ?>/employee/?user=<?php echo $user_meta->user_login ?>"><?php echo $response->comment_author; ?></a> - <?php echo get_user_meta($user_meta->ID, 'company_key', true); ?>
												<?php } ?>
											</h3>
											<?php if (intval($response->user_id) == intval(get_current_user_id())){ ?>
											<div class="delete-comment-candidacy" style="width: 25px; padding-top: 25px;" data-object-id="<?php echo $response->comment_ID; ?>" data-object-string="<?php echo $ramdonstring; ?>">												<i class="material-icons">
													delete
												</i>
											</div>
											<?php } ?>
										</div> <!-- /.response-head -->
									</div>
									<div class="ns-col-sm-3 response-dates">
										<a href="#response-<?php echo esc_attr($counter); ?>" class="response-bookmark ns-small"><?php echo date( 'd M Y h:iA', strtotime( $response->comment_date ) ); ?></a>
									</div>
								</div> <!-- /.ns-row -->
								<div class="ticket-response">
									<?php echo wpautop( $response->comment_content ); ?>
								</div>
								
							</div> <!-- /.ticket-response-cards -->
		
							<?php
				        $counter++;
				        } //endforeach ?>
			    <?php } //endif ?>
			</div>
			    
			<!-- ++++++++++++ NEW RESPONSE FORM ++++++++++++ -->
			
				<?php $get_status = get_post_meta(get_the_ID(), 'candidacy_status_', true);
				
				if($get_status == 2 || $get_status == 3 || $user_role == 'employeur') { ?>
				    <form action=" <?php $_SERVER['REQUEST_URI'] ?>" method="post">
			                <div class="ns-cards ns-feedback">
			                    <div class="ns-feedback-form">
			
			                        <div class="ns-form-group">
			                            <textarea name="ns_response_msg" id="write-message" class="ns-form-control" placeholder="<?php esc_attr_e('Écrivez votre réponse...', 'monemploi'); ?>" rows="6"></textarea>
			                        </div> <!-- /.ns-form-group -->
		
			                        <button id="submit_response" type="submit" name="submit">
			                        	<input type="hidden" name="action" value="submit_response" />
							<input type="hidden" name="postid" value="<?php echo get_the_ID(); ?>" />
			                            <?php esc_html_e('Soumettre', 'monemploi'); ?>
			                        </button>
			
			                    </div>
			                </div> <!-- /.ns-feedback-form -->
			           </form>
				<?php } else { ?>
					<div class="ns-cards ns-feedback">
			                    <div class="ns-feedback-form">
			                    	<p>Vous ne pouvez pas commenter cette candidature.</p>
			                    </div>
			                </div> <!-- /.ns-feedback-form -->
				<?php } ?>
	
			</div> <!-- /.ticket-responses -->
		
	
	</article><!-- #post-## -->
	
<?php } else { ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>
	
		<h2>Vous navez pas les autorisation pour consulter cette page.<h2>
	
	</article><!-- #post-## -->
	
<?php }  ?>