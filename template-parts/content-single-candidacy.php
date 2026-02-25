<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package chichi
 */

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
		
		<div class="entry-meta-employeur-info" style="padding-bottom:15px;">
		
		    <?php 
		    echo '<h3><span class="">'. __('Coordonnées de lemployeur', 'monemploi') .'</span></h3>';
		    
		    $user_id = get_post_field ('post_author', get_post_meta(get_the_ID(), 'my_postid_key', true));
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
			
		<div class="entry-meta" style="padding-bottom: 15px;">
			<?php 
			echo '<h3><span class="">'. __('Adresse du poste', 'monemploi') .'</span></h3>';
		
			echo get_post_meta( get_post_meta(get_the_ID(), 'my_postid_key', true), 'my_code_postal_key', true );
			echo ' - '; 
			$usermetadata = get_user_meta($user_id);
			$field_data = $usermetadata['Code_postal']; 
					 
			echo '<span class="autocompleteDeparture">';
				echo '<span class="autocompleteDeparture_0" style="display: none;">'. implode($field_data) . '</span>';
				echo '<span class="autocompleteArrival_0" style="display: none;">' . get_post_meta( get_post_meta(get_the_ID(), 'my_postid_key', true), 'my_code_postal_key', true ) . '</span>';
				echo '<span class="distance_0"></span>'; 
			echo '</span>';
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
				if($user_role == 'um_employeur'){
				
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
		
			echo '<h3><span class="">'. __('Lettre de presentation', 'monemploi') .'</span></h3>';
			
			$my_lettre_presentation = get_post_meta( get_the_ID(), 'my_lettre_presentation_key', true );
		
			echo wpautop($my_lettre_presentation);
		
		echo '</div>';
				
		echo '<div class="candidacy-responses" style="padding-bottom: 15px;">';
		
			$args = array(
			        'post_id'   	=> get_the_ID(),
			        'post_type' 	=> 'candidacy',
			        'status'    	=> 'approve',
			        'order'     	=> 'ASC'
			    );
			    $response_array = get_comments( $args );
			   			    
			    	$counter = 0;
				
				echo '<h3><span class="">'. __('Réponses', 'monemploi') .'</span></h3>';
	
				echo '<div class="candidacy-response-cards">';

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
												<?php um_fetch_user( $userid ); ?>
												<?php if($user_role == 'um_employeur'){ ?>
													<a href="<?php get_site_url(); ?>/employeur/?user=<?php echo $user_meta->user_login ?>"><?php echo $response->comment_author; ?></a> - <?php echo um_user('name_org'); ?>
													<?php um_reset_user(); ?>
												<?php } elseif($user_role == 'employer'){ ?>
													<a href="<?php get_site_url(); ?>/employee/?user=<?php echo $user_meta->user_login ?>"><?php echo $response->comment_author; ?></a> - <?php echo um_user('name_org'); ?>
													<?php um_reset_user(); ?>
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
				
				if($get_status == 2 || $get_status == 3 || $user_role == 'um_employeur') { ?>
			                <div class="ns-cards ns-feedback">
			                    <div class="ns-feedback-form">
			
			                        <div class="ns-form-group">
			                            <textarea name="ns_response_msg" id="write-message" class="ns-form-control" placeholder="<?php esc_attr_e('Écrivez votre réponse...', 'monemploi'); ?>" rows="6" aria-label="<?php esc_attr_e('
Écrivez votre réponse...', 'monemploi'); ?>"><?php echo isset($_POST['ns_response_msg']) ? $_POST['ns_response_msg'] : ''; ?></textarea>
			                        </div> <!-- /.ns-form-group -->
		
			                        <button id="submit_response" data-object-id="<?php echo get_the_ID(); ?>">
			                            <?php esc_html_e('Soumettre', 'monemploi'); ?>
			                        </button>
			
			                    </div>
			                </div> <!-- /.ns-feedback-form -->
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