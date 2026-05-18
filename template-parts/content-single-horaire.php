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

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php 	
    $current_user = wp_get_current_user();
	$userid = $current_user->ID;
	$user_meta = get_userdata($userid);
	$user_role = $user_meta->roles[0]; 
	$current_time = current_time( 'timestamp' );
	$push_in_out = get_post_meta( get_the_ID(), 'push_in_out_key', true );
	$datepickerstarthoraire = get_post_meta( get_the_ID(), 'datepickerstarthoraire_key', true );
	$timestarthoraire = get_post_meta( get_the_ID(), 'timestarthoraire_key', true );
	$datepickerendhoraire = get_post_meta( get_the_ID(), 'datepickerendhoraire_key', true );
	$timeendhoraire = get_post_meta( get_the_ID(), 'timeendhoraire_key', true );	
	$datewithoutone = strtotime($datepickerstarthoraire.'T'.$timestarthoraire.' -1 hour');
	$dateendstrtotime = strtotime($datepickerendhoraire.'T'.$timeendhoraire);	
	if($user_role == 'employer' || $user_role == 'employeur'){ ?>
	<div class="entry-meta-job-wrapper" style="display: flex;">
	    <header class="entry-header" style="width: calc(100% - 150px);">
                <h1>Horaire</h1>
            </header>
            <?php 
            	echo '<div style="margin-right: 0; padding-top: 25px;">';
                if($push_in_out == 0 || $push_in_out == ''){
                	if($current_time > $datewithoutone && $current_time < $dateendstrtotime){ 
		                echo '<form action="'. $_SERVER['REQUEST_URI'] .'" method="post">';
		                	echo '<input type="hidden" name="userid" value="'.$userid.'" />';
		                	echo '<input type="hidden" name="postid" value="'.get_the_ID().'" />';
		                	echo '<input type="hidden" name="action" value="new_punch_in_out" />';
					echo '<button class="ns_submit" type="submit" name="submit">';
						esc_html_e( 'Pointer de départ', 'monemploi' );
					echo '</button>';
					
				echo '</form>'; 
			}
		}
		if($push_in_out == 1 && $current_time <= $dateendstrtotime){
	                echo '<form action="'. $_SERVER['REQUEST_URI'] .'" method="post">';
	                	echo '<input type="hidden" name="userid" value="'.$userid.'" />';
	                	echo '<input type="hidden" name="postid" value="'.get_the_ID().'" />';
	                	echo '<input type="hidden" name="action" value="new_punch_in_out" />';
				echo '<button class="ns_submit" type="submit" name="submit">';
					esc_html_e( 'Pointer de fin', 'monemploi' );
				echo '</button>';
				
			echo '</form>'; 
		} 
		echo '</div>';
		?>
        </div>
        <?php
            $get_author_id = get_the_author_meta('ID');
            $employee_horaire = get_post_meta( get_the_ID(), 'employee_horaire_key', true );
	    $job_horaire = get_post_meta( get_the_ID(), 'job_horaire_key', true );
	    $datepickerstarthoraire = get_post_meta( get_the_ID(), 'datepickerstarthoraire_key', true );
	    $timestarthoraire = get_post_meta( get_the_ID(), 'timestarthoraire_key', true );
	    $datepickerendhoraire = get_post_meta( get_the_ID(), 'datepickerendhoraire_key', true );
	    $timeendhoraire = get_post_meta( get_the_ID(), 'timeendhoraire_key', true );
	    $timebrake = get_post_meta( get_the_ID(), 'timebrake_key', true );
	    $salaire = get_post_meta( get_the_ID(), 'salaire_key', true );
	    
	    echo '<h2>'.get_the_title($job_horaire).'</h2>';
	    
	    echo '<h4>Employeur</h4>';
	    $get_author_by_id = get_user_by('ID', $get_author_id);
	    $hide_adresse = get_user_meta( $get_author_id, 'hide_adresse_key', true);
	    $hide_contact = get_user_meta( $get_author_id, 'hide_contact_key', true);
	    
	    echo $get_author_by_id->user_nicename;
	    echo ' - ';
	    echo $get_author_by_id->user_firstname;
	    echo ' ';
	    echo $get_author_by_id->user_lastname;
	    if(get_user_meta($get_author_id, 'company_key', true) != ''){
		    echo ' - ';
		    echo get_user_meta($get_author_id, 'company_key', true);
	    }	
	    echo '<br>';
	    if($hide_adresse == 0 || $hide_adresse == ''){
		    echo get_user_meta($get_author_id, 'adresse_key', true);
		    echo ' - ';
		    echo get_user_meta($get_author_id, 'city_key', true);
		    echo ' - ';
		    echo get_user_meta($get_author_id, 'province_key', true);
		    echo ' - ';
		    echo get_user_meta($get_author_id, 'country_key', true);
		    echo ' - ';
		    echo get_user_meta($get_author_id, 'postal_code_key', true);
		    echo '<br>';
	    }
	    if($hide_contact == 0 || $hide_contact == ''){
		    echo get_user_meta($get_author_id, 'phone_key', true);
		    if(get_user_meta($get_author_id, 'poste_key', true) != ''){
		    	echo ' - ';
		    	echo get_user_meta($get_author_id, 'poste_key', true);
		    }
		    echo ' - ';
		    echo $get_author_by_id->user_email;	    
		    echo '<br>';
	    }
	    
	    echo '<h4>Employer</h4>';
	    $get_employee_by_id = get_user_by('ID', $employee_horaire);
	    $hide_adresse = get_user_meta( $employee_horaire, 'hide_adresse_key', true);
	    $hide_contact = get_user_meta( $employee_horaire, 'hide_contact_key', true);
	    
	    echo $get_employee_by_id->user_nicename;
	    echo ' - ';
	    echo $get_employee_by_id->user_firstname;
	    echo ' ';
	    echo $get_employee_by_id->user_lastname;
	    if(get_user_meta($employee_horaire, 'company_key', true) != ''){
		    echo ' - ';
		    echo get_user_meta($employee_horaire, 'company_key', true);
	    }	
	    echo '<br>';
	    if($hide_adresse == 0 || $hide_adresse == ''){
		    echo get_user_meta($employee_horaire, 'adresse_key', true);
		    echo ' - ';
		    echo get_user_meta($employee_horaire, 'city_key', true);
		    echo ' - ';
		    echo get_user_meta($employee_horaire, 'province_key', true);
		    echo ' - ';
		    echo get_user_meta($employee_horaire, 'country_key', true);
		    echo ' - ';
		    echo get_user_meta($employee_horaire, 'postal_code_key', true);
		    echo '<br>';
	    }
	    if($hide_contact == 0 || $hide_contact == ''){
		    echo get_user_meta($employee_horaire, 'phone_key', true);
		    if(get_user_meta($employee_horaire, 'poste_key', true) != ''){
		    	echo ' - ';
		    	echo get_user_meta($employee_horaire, 'poste_key', true);
		    }
		    echo ' - ';
		    echo $get_employee_by_id->user_email;	    
		    echo '<br>';
	    }
	    
	    echo '<br>';
	    echo 'Début de l&#8216;horaire: '.$datepickerstarthoraire . ' - ' . $timestarthoraire;
	    echo '<br>';
	    echo 'Fin de l&#8216;horaire: '.$datepickerendhoraire . ' - ' . $timeendhoraire;
	    echo '<br>';
	    echo 'Vous avez droit à '.$timebrake.' minutes de pause';
	    echo '<br>';
	    echo 'Votre salaire horaire est de '.$salaire.'$ de l&#8216;heure';
	    echo '<br>';
	    
	    echo '<h4>Vos entrée/sortie</h4>';
	    $i = 0;
	    $datetimes = [];
	    $push_ = get_post_meta( get_the_ID(), 'push_key', true );
	    foreach($push_ as $push){
	    	if($push[0] == 'entrer'){
	    		echo $push[0] . ' - ' . gmdate("Y-m-d H:i:s", $push[1]);
	    		$datetimes[$i] = $push[1];
	    		echo '<br>';
	    	}
	    	if($push[0] == 'sortie'){
	    		echo $push[0] . ' - ' . gmdate("Y-m-d H:i:s", $push[1]);
	    		$datetimes[$i] = $push[1];
	    		echo '<br>';
	    	}
	    	$i++;
	    }
	    echo '<br>';
	    $pay = [];
	    if($datetimes[0] != '' && $datetimes[1] != ''){
		    $diffdatetime = $datetimes[1] - $datetimes[0];
		    echo 'Dans: '.gmdate("H:i:s", $diffdatetime);
		    echo '<br>';
		    $gethours = gmdate("H", $diffdatetime);
		    $getminutes = gmdate("i", $diffdatetime);
		    $worktime = $gethours * 60 + $getminutes;
		    $salary = $salaire/60;
		    $pay_once = $worktime * $salary;
		    $pay[] = $worktime * $salary;
		    echo 'Votre salaire brute: '.$pay_once.'$';
		    echo '<br>';
	    }
	    if($datetimes[1] != '' && $datetimes[2] != ''){
		    $diffdatetime = $datetimes[2] - $datetimes[1];
		    echo 'Sortie: '.gmdate("H:i:s", $diffdatetime);
		    echo '<br>';
	    }
	    if($datetimes[2] != '' && $datetimes[3] != ''){
		    $diffdatetime = $datetimes[3] - $datetimes[2];
		    echo 'Dans: '.gmdate("H:i:s", $diffdatetime);
		    echo '<br>';
		    $gethours = gmdate("H", $diffdatetime);
		    $getminutes = gmdate("i", $diffdatetime);
		    $worktime = $gethours * 60 + $getminutes;
		    $salary = $salaire/60;
		    $pay_once = $worktime * $salary;
		    $pay[] = $worktime * $salary;
		    echo 'Votre salaire brute: '.$pay_once.'$';
		    echo '<br>';
	    }
	    if($datetimes[3] != '' && $datetimes[4] != ''){
		    $diffdatetime = $datetimes[4] - $datetimes[3];
		    echo 'Sortie: '.gmdate("H:i:s", $diffdatetime);
		    echo '<br>';
	    }
	    if($datetimes[4] != '' && $datetimes[5] != ''){
		    $diffdatetime = $datetimes[5] - $datetimes[4];
		    echo 'Dans: '.gmdate("H:i:s", $diffdatetime);
		    echo '<br>';
		    $gethours = gmdate("H", $diffdatetime);
		    $getminutes = gmdate("i", $diffdatetime);
		    $worktime = $gethours * 60 + $getminutes;
		    $salary = $salaire/60;
		    $pay_once = $worktime * $salary;
		    $pay[] = $worktime * $salary;
		    echo 'Votre salaire brute: '.$pay_once.'$';
		    echo '<br>';
	    }
	    if($datetimes[5] != '' && $datetimes[6] != ''){
		    $diffdatetime = $datetimes[6] - $datetimes[5];
		    echo 'Sortie: '.gmdate("H:i:s", $diffdatetime);
		    echo '<br>';
	    }
	    if($datetimes[6] != '' && $datetimes[7] != ''){
		    $diffdatetime = $datetimes[7] - $datetimes[6];
		    echo 'Dans: '.gmdate("H:i:s", $diffdatetime);
		    echo '<br>';
		    $gethours = gmdate("H", $diffdatetime);
		    $getminutes = gmdate("i", $diffdatetime);
		    $worktime = $gethours * 60 + $getminutes;
		    $salary = $salaire/60;
		    $pay_once = $worktime * $salary;
		    $pay[] = $worktime * $salary;
		    echo 'Votre salaire brute: '.$pay_once.'$';
		    echo '<br>';
	    }
	    if($datetimes[7] != '' && $datetimes[8] != ''){
		    $diffdatetime = $datetimes[8] - $datetimes[7];
		    echo 'Sortie: '.gmdate("H:i:s", $diffdatetime);
		    echo '<br>';
	    }
	    if($datetimes[8] != '' && $datetimes[9] != ''){
		    $diffdatetime = $datetimes[9] - $datetimes[8];
		    echo 'Dans: '.gmdate("H:i:s", $diffdatetime);
		    echo '<br>';
		    $gethours = gmdate("H", $diffdatetime);
		    $getminutes = gmdate("i", $diffdatetime);
		    $worktime = $gethours * 60 + $getminutes;
		    $salary = $salaire/60;
		    $pay_once = $worktime * $salary;
		    $pay[] = $worktime * $salary;
		    echo 'Votre salaire brute: '.$pay_once.'$';
		    echo '<br>';
	    }
	    $pay_sum = array_sum($pay);
	    if($pay_sum != 0){
	    	    echo '<br>';
		    echo '<span>Somme des salaires</span>';
		    echo '<br>';
		    echo 'Le total de vos montants brute: '. $pay_sum .'$';
		    echo '<br>';
	    }

	    ?>
	<?php } else {
	
		echo '<h2>Vous n&#8216;avez pas l&#8216;autorisation pour consulter cette page</h2>';
	
	}
?>

</article><!-- #post-## -->
