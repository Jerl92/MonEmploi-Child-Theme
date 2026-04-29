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
				<?php $my_postid = get_post_meta(get_the_ID(), 'my_postid_key', true); ?>
				<h2><?php echo '<a href="' . get_permalink( $my_postid ) . '">' . get_the_title() . '</a>'; ?></h2>
				
			</div>
					
			<?php } ?>
	
		</header><!-- .entry-header -->
		
		<?php
		
		if (isset($_GET['add_comment'])) {
		        echo "<h3>Le commentaire #". $_GET['add_comment'] ." à été ajouter.</h3>";
		}
		
		if (isset($_GET['delete_comment'])) {
		        echo "<h3>Le commentaire #". $_GET['delete_comment'] ." à été supprimé.</h3>";
		}
		
		?>
		
		<div class="entry-meta-employeur-info" style="padding-bottom:15px;">
		
		    <?php 
		    echo '<h3><span class="">'. __('Coordonnées de l&#8216;employeur', 'monemploi') .'</span></h3>';
		    
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
		    $hide_adresse_candidacy = get_user_meta( $user_id, 'hide_adresse_candidacy_key', true);
		    if($hide_adresse_candidacy == 0 || $hide_adresse_candidacy == ''){
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
		    }
		    $hide_contact_candidacy = get_user_meta( $user_id, 'hide_contact_candidacy_key', true);
		    if($hide_contact_candidacy == 0 || $hide_contact_candidacy == ''){
			    echo get_user_meta($user_id, 'phone_key', true);
			    if(get_user_meta($user_id, 'poste_key', true) != ''){
			    	echo ' - ';
			    	echo get_user_meta($user_id, 'poste_key', true);
			    }
			    echo ' - ';
			    echo $get_user_by_username->user_email;	    
			    echo '<br>';
		    }
		    
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
		
			echo '<span id="user-adress" style="display: none;">' . get_user_meta($author_id, 'adresse_key', true) . ' ' . get_user_meta($author_id, 'postal_code_key', true) . '</span>';
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
			$user_id = $author_obj->ID;
			echo '<a href="'. get_site_url() .'/employee/?user='. $author_obj->user_nicename .'">' . $author_obj->user_nicename . '</a>';
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
											<h3 class="ticket-head" id="response-<?php echo esc_attr($counter); ?>" style="width: calc(100% - 75px);">
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
											<div class="delete-comment-candidacy" style="width: 75px; margin-left: auto; margin-right: auto;">
												<form action="<?php $_SERVER['REQUEST_URI'] ?>" method="post">
										                        <input type="hidden" name="commentid" value="<?php echo $response->comment_ID; ?>" />
										                        <input type="hidden" name="action" value="delete_comment_candidacy" />
										                        <button type="submit" name="submit" style="padding: 0; margin: 0;">
										                        	<i class="material-icons">
										            				delete
										            			</i>
										            		</button>
									            		</form>
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
			                            <textarea name="ns_response_msg" id="write-message" class="ns-form-control" placeholder="<?php esc_attr_e('Écrivez votre réponse...', 'monemploi'); ?>" rows="6" required></textarea>
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
			                    	<p>Vous ne pouvez pas répondre à cette candidature.</p>
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