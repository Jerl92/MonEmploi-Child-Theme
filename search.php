<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package chichi
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<header class="page-header">
				<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'chichi' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->

			<?php
			$search = get_search_query();
			$users = get_users( [
			    'meta_query' => [
			        'relation' => 'OR',
			        [
			            'key'     => 'first_name',
			            'value'   => $search,
			            'compare' => 'LIKE',
			        ],
			        [
			            'key'     => 'last_name',
			            'value'   => $search,
			            'compare' => 'LIKE',
			        ],
			    ],
			] );
			foreach ($users as $user) {
			
				$user_id = $user->ID; // Replace with the desired user ID
				$user_info = get_userdata($user_id);
			        $user_roles = $user_info->roles;
			        if(implode($user_roles) == 'employeur'){
				    $company_key = get_user_meta($user->ID, 'company_key', true);
				    echo '<a href="'. get_site_url() .'/employeur/?user='. $user->user_nicename .'">'. $user->user_nicename .'</a>';
				    echo ' - ';
			 	    echo $user->user_firstname;
			 	    echo ' ';
				    echo $user->user_lastname;
				    if($company_key != ''){
					    echo ' - ';
					    echo $company_key;
				    }
				    echo ' - ';
				    echo get_user_meta($user->ID, 'city_key', true);
				    echo '<br>';
				}
				
				if(implode($user_roles) == 'employer'){
				    $company_key = get_user_meta($user->ID, 'company_key', true);
				    echo '<a href="'. get_site_url() .'/employee/?user='. $user->user_nicename .'">'. $user->user_nicename .'</a>';
				    echo ' - ';
			 	    echo $user->user_firstname;
			 	    echo ' ';
				    echo $user->user_lastname;
				    if($company_key != ''){
					    echo ' - ';
					    echo $company_key;
				    }
				    echo ' - ';
				    echo get_user_meta($user->ID, 'city_key', true);
				    echo '<br>';
				}
			 
			}	
			
			
			$current_user = wp_get_current_user();
			$user_meta = get_userdata($current_user->ID);
			$user_role = $user_meta->roles[0];
		
			if($user_role == 'employeur' || $user_role == 'administrator'){
		
				$get_jobs_args = array( 
					'post_type' => 'emploi',
					'posts_per_page' => 25,
					'post_status' => array('publish', 'draft', 'future'),
					'orderby' => 'date',
					'order' => 'DESC',
					's' => get_search_query(),
			    		'search_columns' => array( 'post_title', 'post_name', 'post_content' )
				); 
			
			} else {
			
				$get_jobs_args = array( 
					'post_type' => 'emploi',
					'posts_per_page' => 25,
					'post_status' => array('publish'),
					'orderby' => 'date',
					'order' => 'DESC',
					's' => get_search_query(),
			    		'search_columns' => array( 'post_title', 'post_name', 'post_content' )
				);
				 
			}
			
			$get_jobs = new WP_Query($get_jobs_args);
			
			$i = 0;
			echo '<div class="job-wrapper">';
	if ( $get_jobs->have_posts() ) : while ( $get_jobs->have_posts() ) : $get_jobs->the_post();
		if(get_post_status(get_the_ID()) == 'draft' || get_post_status(get_the_ID()) == 'future') {	
				if(get_current_user_id() == $get_jobs->post->post_author) {
					if($user_role == 'employeur'){
						echo '<div class="job-wrapper-box" id="job-wrapper-box-'.$i.'" style="display: block;">';
				    			echo '<a href="' . get_permalink( get_the_ID() ) .'">' . get_the_ID() . ' - ' . $get_jobs->post->post_title . '</a> - ';
							$author_id = $get_jobs->post->post_author;
							$get_user_by_username = get_user_by('ID', $author_id);
							echo '<a href="'. get_site_url() .'/employeur/?user='. $get_user_by_username->user_nicename .'">'. $get_user_by_username->user_nicename .'</a>';
							$usermetadata = get_user_meta(get_current_user_id());
								
						    echo ' - ';
						    echo get_post_meta( get_the_ID(), 'company_key', true );					    
						    echo ' - ';
					 	    echo $get_user_by_username->user_firstname;
					 	    echo ' ';
						    echo $get_user_by_username->user_lastname;
							
							$field_data_adresse = $usermetadata['Adresse'];
							$field_data = $usermetadata['Code_postal'];
							if($field_data){
								echo '<span class="autocompleteDeparture">';
									echo '<span class="autocompleteDeparture_'.  $i . '" style="display:none;">'. implode($field_data_adresse) . ' ' .implode($field_data) . '</span>';
									echo '<span class="autocompleteArrival_' . $i . '" style="display: none;">' . get_post_meta( $post->ID, 'my_code_postal_key', true ) . '</span>';
									echo ' - <span class="distance_' . $i . ' distance"></span>';
								echo '</span>';
							}
							
							if(get_post_status(get_the_ID()) == 'draft') {
								echo ' - Brouillon';
							} 
							if(get_post_status(get_the_ID()) == 'future') {
								echo ' - Programmer';
							}
							
							echo ' - ' . get_post_meta( get_the_ID(), 'my_city_key', true );							
							$from = strtotime(get_the_date('Y-m-d H:i:s', get_the_ID()));
							$today = current_time('timestamp');
							$difference = $today - $from;
							$round_difference = round($difference / 60 / 60 / 24, 0);
							if($round_difference < 1){
								echo ' - <span class="get-the-date-difference-'.$i.'">' . $round_difference . ' Jour</span>';
							} else {
								echo ' - <span class="get-the-date-difference-'.$i.'">' . $round_difference . ' Jours</span>';
							}
						echo '</div>';
					
					}
				
				}
			
			} else {
				echo '<div class="job-wrapper-box" id="job-wrapper-box-'.$i.'" style="display: block;">';
			    		echo '<a href="' . get_permalink( get_the_ID() ) .'">' . get_the_ID() . ' - ' . $get_jobs->post->post_title . '</a> - ';
						$author_id = $get_jobs->post->post_author;
						$get_user_by_username = get_user_by('ID', $author_id);
						echo '<a href="'. get_site_url() .'/employeur/?user='. $get_user_by_username->user_nicename .'">'. $get_user_by_username->user_nicename .'</a>';
						$usermetadata = get_user_meta(get_current_user_id());
								
					    echo ' - ';
					    echo get_post_meta( get_the_ID(), 'company_key', true );	
					    echo ' - ';
				 	    echo $get_user_by_username->user_firstname;
				 	    echo ' ';
					    echo $get_user_by_username->user_lastname;
						
					$field_data_adresse = $usermetadata['Adresse'];
					$field_data = $usermetadata['Code_postal'];
					if($field_data){
						echo '<span class="autocompleteDeparture">';
							echo '<span class="autocompleteDeparture_'.  $i . '" style="display:none;">'. implode($field_data_adresse) . ' ' .implode($field_data) . '</span>';
							echo '<span class="autocompleteArrival_' . $i . '" style="display: none;">' . get_post_meta( $post->ID, 'my_code_postal_key', true ) . '</span>';
							echo ' - <span class="distance_' . $i . ' distance"></span>';
						echo '</span>';
					}
					
					echo ' - ' . get_post_meta( get_the_ID(), 'my_city_key', true );
			
					$from = strtotime(get_the_date('Y-m-d H:i:s', get_the_ID()));
					$today = current_time('timestamp');
					$difference = $today - $from;
					$round_difference = round($difference / 60 / 60 / 24, 0);
					if($round_difference < 1){
						echo ' - <span class="get-the-date-difference-'.$i.'">' . $round_difference . ' Jour</span>';
					} else {
						echo ' - <span class="get-the-date-difference-'.$i.'">' . $round_difference . ' Jours</span>';
					}
	
				echo '</div>';	
			}	    		
	    	$i++;
	endwhile; endif;
	?> </div> <?php
	
	the_posts_navigation();

	?>
		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_sidebar();
get_footer();
