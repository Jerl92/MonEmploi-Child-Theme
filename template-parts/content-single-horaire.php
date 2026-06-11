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
$url = $_SERVER['REQUEST_URI'];
$queryString = parse_url($url, PHP_URL_QUERY);
parse_str($queryString, $params);

if (implode($params) == ''){

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
	$employee_horaire = get_post_meta( get_the_ID(), 'employee_horaire_key', true);
	$dateminus24 = strtotime($datepickerstarthoraire.'T'.$timestarthoraire.' -24 hour');
	$datewithoutone = strtotime($datepickerstarthoraire.'T'.$timestarthoraire.' -1 hour');
	$datestartstrtotime = strtotime($datepickerstarthoraire.'T'.$timestarthoraire);
	$dateendstrtotime = strtotime($datepickerendhoraire.'T'.$timeendhoraire);	
	$datepickerstartpause = get_post_meta( get_the_ID(), 'datepickerstartpause_key', true );
	$timestartpause = get_post_meta( get_the_ID(), 'timestartpause_key', true );
	$datepickerendpause = get_post_meta( get_the_ID(), 'datepickerendpause_key', true );
	$timeendpause = get_post_meta( get_the_ID(), 'timeendpause_key', true );
	$employee_replace = get_post_meta( get_the_ID(), 'employee_replace_key', true );
	$dayoff_status = get_post_meta( get_the_ID(), 'dayoff_status_key', true );
	if($user_role == 'employer' || $user_role == 'employeur'){ ?>
	<div class="entry-meta-job-wrapper" style="display: flex;">
	    <header class="entry-header" style="width: calc(100% - 150px);">
                <h1>Horaire</h1>
            </header>
            <?php 
            	echo '<div style="right: 0; padding-top: 25px;">';
            	if($employee_replace != '' && $dayoff_status == 3){
            		$employee_horaire = 0;
            	}
            	if($employee_horaire == $userid || ($employee_replace == $userid && $dayoff_status == 3)){
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
	    
	    echo '<span>UUID - '.get_the_title(get_the_ID()).'</span>';
	    
	    echo '<br>';
	    
	    echo '<span>ID - '.get_the_ID().'</span>';
	    
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
	    	    
	    $dayoff_status = get_post_meta( get_the_ID(), 'dayoff_status_key', true );
	    $employee_replace = get_post_meta( get_the_ID(), 'employee_replace_key', true );
	    if($employee_replace != '' && $dayoff_status == 3){
		    echo '<h4>Remplacent</h4>';
		    $get_employee_replace_by_id = get_user_by('ID', $employee_replace);
		    $hide_adresse = get_user_meta( $employee_replace, 'hide_adresse_key', true);
		    $hide_contact = get_user_meta( $employee_replace, 'hide_contact_key', true);
		    
		    echo $get_employee_replace_by_id->user_nicename;
		    echo ' - ';
		    echo $get_employee_replace_by_id->user_firstname;
		    echo ' ';
		    echo $get_employee_replace_by_id->user_lastname;
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
			    echo $get_employee_replace_by_id->user_email;	    
			    echo '<br>';
		    }
	    }
	    
	    echo '<br>';
	    echo 'Début de l&#8216;horaire: '.$datepickerstarthoraire . ' - ' . $timestarthoraire;
	    echo '<br>';
	    echo 'Début de la pause: '.$datepickerstartpause . ' - ' . $timestartpause;
	    echo '<br>';
	    echo 'Fin de la pause: '.$datepickerendpause . ' - ' . $timeendpause;
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
	    if($push_ == ''){
	    	$push_ = [];
	    }
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
	    $datetimescount = count($datetimes);
	    for ($i = 0; $i < $datetimescount; $i++) {
	    	if ($i % 2 == 0) {
			if($datetimes[$i] != '' && $datetimes[$i+1] != ''){
			    $diffdatetime = $datetimes[$i+1] - $datetimes[$i];
			    $seconds = $diffdatetime;
			    $hours = floor($seconds / 3600);
			    $minutes = floor(($seconds / 60) % 60);
			    $secs = $seconds % 60;
			    echo 'Dans: '.sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
			    echo '<br>';
			    $gethours = $hours;
			    $getminutes = $minutes;
			    $worktime = ($gethours * 60) + $getminutes;
			    $salary = $salaire/60;
			    $pay_once = $worktime * $salary;
			    $pay[] = $worktime * $salary;
			    echo 'Votre salaire brute: '.round($pay_once, 2).'$';
			    echo '<br>';
		    	}
		} else {
			if($datetimes[$i] != '' && $datetimes[$i+1] != ''){
			    $diffdatetime = $datetimes[$i+1] - $datetimes[$i];
			    echo 'Sortie: '.gmdate("H:i:s", $diffdatetime);
			    echo '<br>';
		    	}
		}
	    }
	    $pay_sum = array_sum($pay);
	    if($pay_sum != 0){
	    	    echo '<br>';
		    echo '<span>Somme des salaires</span>';
		    echo '<br>';
		    echo 'Le total de vos montants brute: '. round($pay_sum, 2).'$';
		    echo '<br>';
	    }
	    
 	    $fristpush = array_first($push_);
	    if($fristpush[0] == 'entrer'){
	    	if($fristpush[1] <= $datestartstrtotime){
		    	echo '<br>';
		    	$endpushcalc = $datestartstrtotime - $fristpush[1];
		    	echo 'Nombre de temps en avance.';
		    	echo '<br>';
	           	$seconds = $endpushcalc;
			$hours = floor($seconds / 3600);
			$minutes = floor(($seconds / 60) % 60);
			$secs = $seconds % 60;
			echo sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
		    	echo '<br>';
	    	}
	    }
	   if($fristpush[0] == 'entrer'){
	    	if($fristpush[1] >= $datestartstrtotime){
		    	echo '<br>';
		    	$endpushcalc = $fristpush[1] -  $datestartstrtotime;
		    	echo 'Nombre de temps en retard.';
		    	echo '<br>';
	           	$seconds = $endpushcalc;
			$hours = floor($seconds / 3600);
			$minutes = floor(($seconds / 60) % 60);
			$secs = $seconds % 60;
			echo sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
		    	echo '<br>';
	    	}
	    }
	    $endpush = end($push_);
	    if($endpush[0] == 'entrer'){
	    	echo '<br>';
	    	$endpushcalc = $current_time - $endpush[1];
	    	echo 'Nombre de temps de pointages.';
		echo '<br>';
                $seconds = $endpushcalc;
		$hours = floor($seconds / 3600);
		$minutes = floor(($seconds / 60) % 60);
		$secs = $seconds % 60;
		echo sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
	    	echo '<br>';
	    }
	    if($endpush[0] == 'entrer'){
	    	if($current_time >= $dateendstrtotime){
		    	echo '<br>';
		    	$endpushcalc = $current_time - $dateendstrtotime;
		    	echo 'Nombre de temps en supplémentaire.';
		    	echo '<br>';
	           	$seconds = $endpushcalc;
			$hours = floor($seconds / 3600);
			$minutes = floor(($seconds / 60) % 60);
			$secs = $seconds % 60;
			echo sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
		    	echo '<br>';
		    	echo '<br>';
	    	}
	    }
	    if($endpush[0] == 'sortie'){
	    	if($endpush[1] >= $dateendstrtotime){
		    	echo '<br>';
		    	$endpushcalc = $endpush[1] - $dateendstrtotime;
		    	echo 'Nombre de temps en supplémentaire.';
		    	echo '<br>';
	           	$seconds = $endpushcalc;
			$hours = floor($seconds / 3600);
			$minutes = floor(($seconds / 60) % 60);
			$secs = $seconds % 60;
			echo sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
		    	echo '<br>';
		    	echo '<br>';
	    	}
	    }
	    if($endpush[0] == 'sortie'){
	    	if($endpush[1] <= $dateendstrtotime){
		    	echo '<br>';
		    	$endpushcalc = $dateendstrtotime - $endpush[1];
		    	echo 'Nombre de temps de depart hâtif.';
		    	echo '<br>';
	           	$seconds = $endpushcalc;
			$hours = floor($seconds / 3600);
			$minutes = floor(($seconds / 60) % 60);
			$secs = $seconds % 60;
			echo sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
		    	echo '<br>';
		    	echo '<br>';
	    	}
	    }
	    $i = 0;
	    $x = 0;
	    $pausetime = 0;
	    foreach($push_ as $push){
	    	 if($push[0] == 'entrer'){
	    		$entrer[$x] = $push[1];
	    		$x++;
	    	}
	    	if($push[0] == 'sortie'){
	    		$sortie[$i] = $push[1];
	    		$i++;
	    	}
	    }
	    
	    $entrercount = count($entrer);
	    $pausetime = 0;
	    for ($i = 1; $i < $entrercount; $i++) {
		if(($entrer[$i] != 0 || $entrer[$i] != '') && ($sortie[$i-1] != 0 || $sortie[$i-1] != '')){
	    		$pausetime = $pausetime + ($entrer[$i] - $sortie[$i-1]);
	    	}
	    }


		$seconds = $pausetime;
		$hours = floor($seconds / 3600);
		$minutes = floor(($seconds / 60) % 60);
		$secs = $seconds % 60;
		if($minutes != 0){
			echo 'Vous avez passer ce nombre de temps en pause.';
		    	echo '<br>';
			echo sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
			echo '<br>';
			echo '<br>';
		}
		
		if($minutes > $timebrake){
			$timebrakecalc = $minutes - $timebrake;
			echo 'Vous avez depasé le temps de pause de '.$timebrakecalc.' minutes.';
			echo '<br>';
			echo '<br>';
		}
		if($minutes < $timebrake){
			$timebrakecalc_ = $timebrake - $minutes;
			echo 'Il vous reste '.$timebrakecalc_.' minutes de pause.';
			echo '<br>';
			echo '<br>';
		}
	    if($current_time <= $dateendstrtotime && $current_time >= $datestartstrtotime){
		    if($endpush[0] == 'sortie'){
		    	echo '<br>';
		    	$endpushcalc = $current_time - $endpush[1];
		    	if($endpushcalc <= 12600 && $endpushcalc >= -12600){
			    	echo 'Le nombre de temps qui vous avez passé en pause.';
			    	echo '<br>';
	                	$seconds = $endpushcalc;
			        $hours = floor($seconds / 3600);
			        $minutes = floor(($seconds / 60) % 60);
			        $secs = $seconds % 60;
			        echo sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
			    	echo '<br>';
			    	echo '<br>';
		    	}
		    }
	    }
	    
	    $approve_time = get_post_meta( get_the_ID(), 'approve_time_key', true );
	    if($approve_time == 'true'){
		echo '<p>Votre feuille de temps a été approuvé.</p>';
	    }
	    if($approve_time == 'false'){
		echo '<p>Votre feuille de temps a été désapprouver.</p>';
	    }

	    if($user_role == 'employer' && $current_time <= $dateminus24){
	    	echo '<br>';
	    	$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . strtok($_SERVER['REQUEST_URI'], '?');
	    	$dayoff_status = get_post_meta( get_the_ID(), 'dayoff_status_key', true );
		$employee_replace = get_post_meta( get_the_ID(), 'employee_replace_key', true );
		if($employee_replace != $userid){
	    		echo '<button><a href="'.$current_url.'?dayoff=true">Demandes de congé</a></button>';
	    	 }
	    }

	    if($user_role == 'employeur'){
	    	echo '<br>';
	    	$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . strtok($_SERVER['REQUEST_URI'], '?');
	    	echo '<div style="display: flex;">';
		    	echo '<button><a href="'.$current_url.'?edit=true">Éditer</a></button>';
			echo '<form action="'. $_SERVER['REQUEST_URI'] .'" method="post">';
	                	echo '<input type="hidden" name="userid" value="'.$userid.'" />';
	                	echo '<input type="hidden" name="postid" value="'.get_the_ID().'" />';
	                	echo '<input type="hidden" name="action" value="new_approve_time" />';
				echo '<button class="ns_submit" type="submit" name="submit">';
					esc_html_e( 'Approuver le temps', 'monemploi' );
				echo '</button>';
			echo '</form>';
			echo '<form action="'. $_SERVER['REQUEST_URI'] .'" method="post">';
	                	echo '<input type="hidden" name="userid" value="'.$userid.'" />';
	                	echo '<input type="hidden" name="postid" value="'.get_the_ID().'" />';
	                	echo '<input type="hidden" name="action" value="new_desaprovar_time" />';
				echo '<button class="ns_submit" type="submit" name="submit">';
					esc_html_e( 'Désapprouver le temps', 'monemploi' );
				echo '</button>';
			echo '</form>';
			echo '<form action="'. $_SERVER['REQUEST_URI'] .'" method="post">';
	                	echo '<input type="hidden" name="userid" value="'.$userid.'" />';
	                	echo '<input type="hidden" name="postid" value="'.get_the_ID().'" />';
	                	echo '<input type="hidden" name="action" value="new_delete_time" />';
				echo '<button class="ns_submit" type="submit" name="submit">';
					esc_html_e( 'Supprimer l&#8216;horaire', 'monemploi' );
				echo '</button>';
			echo '</form>';
			echo '<button><a href="'.$current_url.'?dayoff=true">Demandes de congé</a></button>';
		echo '</div>';
	    }

	    ?>
	<?php } else {
	
		echo '<h2>Vous n&#8216;avez pas l&#8216;autorisation pour consulter cette page.</h2>';
	
	}
	
}

if ($_GET['dayoff'] == 'true') {

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
	$employee_horaire = get_post_meta( get_the_ID(), 'employee_horaire_key', true);
	$datewithoutone = strtotime($datepickerstarthoraire.'T'.$timestarthoraire.' -1 hour');
	$datestartstrtotime = strtotime($datepickerstarthoraire.'T'.$timestarthoraire);
	$dateendstrtotime = strtotime($datepickerendhoraire.'T'.$timeendhoraire);	
	if($user_role == 'employeur' || $user_role == 'employer'){ ?>
	<div class="entry-meta-job-wrapper">
	    <header class="entry-header">
                <h1>Demande de congé</h1>
            </header>
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
	    
	    echo '<p>UUID - '.get_the_title(get_the_ID()).'</p>';
	    
	    echo '<p>ID - '.get_the_ID().'</p>';
	    
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
	    
	    $dayoff_status = get_post_meta( get_the_ID(), 'dayoff_status_key', true );
	    $employee_replace = get_post_meta( get_the_ID(), 'employee_replace_key', true );
	    if($employee_replace != '' && $dayoff_status == 3){
		    echo '<h4>Remplacent</h4>';
		    $get_employee_replace_by_id = get_user_by('ID', $employee_replace);
		    $hide_adresse = get_user_meta( $employee_replace, 'hide_adresse_key', true);
		    $hide_contact = get_user_meta( $employee_replace, 'hide_contact_key', true);
		    
		    echo $get_employee_replace_by_id->user_nicename;
		    echo ' - ';
		    echo $get_employee_replace_by_id->user_firstname;
		    echo ' ';
		    echo $get_employee_replace_by_id->user_lastname;
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
			    echo $get_employee_replace_by_id->user_email;	    
			    echo '<br>';
		    }
	    }

	    
	    echo '<form action="'. $_SERVER['REQUEST_URI'] .'" method="post"  enctype="multipart/form-data">';
	    	$dayoff_status = get_post_meta( get_the_ID(), 'dayoff_status_key', true );
	    	if($user_role == 'employeur'){
	    		echo '<br>';
			echo '<select name="dayoff-status" id="dayoff-status">';
				if($dayoff_status  == ''){
					echo '<option value="" selected>Sélectionner un type de status de congé</option>';
				} else {
					echo '<option value="">Sélectionner un type de status de congé</option>';
				}
				if($dayoff_status  == 1){
					echo '<option value="1" selected>En revue</option>';
				} else {
					echo '<option value="1">En revue</option>';
				}
				if($dayoff_status  == 2){
					echo '<option value="2" selected>Refusé</option>';
				} else {
					echo '<option value="2">Refusé</option>';
				}
				if($dayoff_status  == 3){
					echo '<option value="3" selected>Accepté</option>';
				} else {
					echo '<option value="3">Accepté</option>';
				}
				if($dayoff_status  == 4){
					echo '<option value="4" selected>Manque d&#8216;information</option>';
				} else {
					echo '<option value="4">Manque d&#8216;information</option>';
				}
			echo '</select>';	
			echo '<br>';   
	     	} else {
		     	if($dayoff_status  == 1){
		     		echo '<h4>En revue</h4>';
		     	} elseif($dayoff_status  == 2){
		     		echo '<h4>Refusé</h4>';
		     	} elseif($dayoff_status  == 3){
		     		echo '<h4>Accepté</h4>';	
		     	} elseif($dayoff_status  == 4){
		     		echo '<h4>Manque d&#8216;information</h4>';
		     	}	
	    	}
	    	
	    	echo '<br>';
	    	$dayoff_reason = get_post_meta( get_the_ID(), 'dayoff_reason_key', true );
		echo '<select name="dayoff-reason" id="dayoff-reason" class="dayoff-reason">';
			if($dayoff_reason == ''){
				echo '<option value="" selected>Sélectionner un type de congé</option>';
			} else {
				echo '<option value="">Sélectionner un type de congé</option>';
			}
			if($dayoff_reason == 1){
				echo '<option value="1" selected>Congés annuels (Vacances)</option>';
			} else {
				echo '<option value="1">Congés annuels (Vacances)</option>';
			}
			if($dayoff_reason == 2){
				echo '<option value="2" selected>Congés de maladie ou médicaux</option>';
			} else {
				echo '<option value="2">Congés de maladie ou médicaux</option>';
			}
			if($dayoff_reason == 3){
				echo '<option value="3" selected>Congés parentaux</option>';
			} else {
				echo '<option value="3">Congés parentaux</option>';
			}
			if($dayoff_reason == 4){
				echo '<option value="4" selected>Congés familiaux ou de deuil</option>';
			} else {
				echo '<option value="4">Congés familiaux ou de deuil</option>';
			}
			if($dayoff_reason == 5){
				echo '<option value="5" selected>Congés sans solde</option>';
			} else {
				echo '<option value="5">Congés sans solde</option>';
			}
			if($dayoff_reason == 6){
				echo '<option value="6" selected>Faire une demande de remplacement</option>';
			} else {
				echo '<option value="6">Faire une demande de remplacement</option>';
			}
		echo '</select>';
		
		echo '<br>';
		echo '<br>';
		$my_employees = get_user_meta( $get_author_id, 'my_employee_key', true);
		$employee_replace = get_post_meta( get_the_ID(), 'employee_replace_key', true );
		if($dayoff_reason == 6){
			echo '<select name="employee-replace" id="employee-replace" class="employee-replace">';
		} else {
			echo '<select name="employee-replace" id="employee-replace" class="employee-replace" style="display: none;">';
		}
		echo '<option value="">Sélectionner un employé</option>';
			foreach($my_employees as $employee){
				$user_by_id = get_user_by('id', $employee);
				if($employee_replace == $employee){
					echo '<option value="'.$employee.'" selected>'. $user_by_id->user_nicename .' - ' . $user_by_id->user_firstname . ' ' . $user_by_id->user_lastname . '</option>';
				} else {
					echo '<option value="'.$employee.'">'. $user_by_id->user_nicename .' - ' . $user_by_id->user_firstname . ' ' . $user_by_id->user_lastname . '</option>';
				}
			}
		echo '</select>';
		
		echo '<br>';
		echo '<br>';
		$dayoff_explication = get_post_meta( get_the_ID(), 'dayoff_explication_key', true );
		echo '<label for="dayoff-explication">Explication de votre demande:</label>';
		echo '<textarea id="dayoff-explication" name="dayoff-explication" rows="4" cols="50">';
			echo $dayoff_explication;
		echo '</textarea>';
		
		echo '<br>';
		echo '<br>';
		echo '<input type="file" name="dayoff_upload" id="dayoff_upload" />';		

		echo '<br>';
		echo '<br>';
		$dayoff_attachment = get_post_meta( get_the_ID(), 'dayoff_attachment_key', true );
		if($dayoff_attachment != ''){
			$url_attachment = wp_get_attachment_url($dayoff_attachment);
			echo '<a href="'.$url_attachment.'">'.basename($url_attachment).'</a>';
		}
			    
	    	echo '<br>';
	    	echo '<br>';
	        echo '<input type="hidden" name="postid" value="'.get_the_ID().'" />';
	        echo '<input type="hidden" name="userid" value="'.$employee_horaire.'" />';
	    	echo '<input type="hidden" name="action" value="new_dayoff" />';
	    	echo '<button type="submit" name="submit">';
	    		esc_html_e( 'Faire la demande de congé', 'monemploi' );
	    	echo '</button>';
	    	
	    echo '</form>';
	    
	}
}

if ($_GET['edit'] == 'true') {
	
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
	$employee_horaire = get_post_meta( get_the_ID(), 'employee_horaire_key', true);
	$datewithoutone = strtotime($datepickerstarthoraire.'T'.$timestarthoraire.' -1 hour');
	$datestartstrtotime = strtotime($datepickerstarthoraire.'T'.$timestarthoraire);
	$dateendstrtotime = strtotime($datepickerendhoraire.'T'.$timeendhoraire);	
	if($user_role == 'employeur'){ ?>
	<div class="entry-meta-job-wrapper">
	    <header class="entry-header">
                <h1>Éditer</h1>
            </header>
        </div>
        <?php
            $get_author_id = get_the_author_meta('ID');
            $employee_horaire = get_post_meta( get_the_ID(), 'employee_horaire_key', true );
	    $job_horaire = get_post_meta( get_the_ID(), 'job_horaire_key', true );
	    $datepickerstarthoraire = get_post_meta( get_the_ID(), 'datepickerstarthoraire_key', true );
	    $timestarthoraire = get_post_meta( get_the_ID(), 'timestarthoraire_key', true );
	    $datepickerendhoraire = get_post_meta( get_the_ID(), 'datepickerendhoraire_key', true );
	    $timeendhoraire = get_post_meta( get_the_ID(), 'timeendhoraire_key', true );
	    $datepickerstartpause = get_post_meta( get_the_ID(), 'datepickerstartpause_key', true );
	    $timestartpause = get_post_meta( get_the_ID(), 'timestartpause_key', true );
	    $datepickerendpause = get_post_meta( get_the_ID(), 'datepickerendpause_key', true );
	    $timeendpause = get_post_meta( get_the_ID(), 'timeendpause_key', true );
	    $timebrake = get_post_meta( get_the_ID(), 'timebrake_key', true );
	    $salaire = get_post_meta( get_the_ID(), 'salaire_key', true );
	    
	    echo '<h2>'.get_the_title($job_horaire).'</h2>';
	    
	    echo '<span>UUID - '.get_the_title(get_the_ID()).'</span>';
	    
	    echo '<br>';
	    
	    echo '<span>ID - '.get_the_ID().'</span>';
	    
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
	    
	    $dayoff_status = get_post_meta( get_the_ID(), 'dayoff_status_key', true );
	    $employee_replace = get_post_meta( get_the_ID(), 'employee_replace_key', true );
	    if($employee_replace != '' && $dayoff_status == 3){
		    echo '<h4>Remplacent</h4>';
		    $get_employee_replace_by_id = get_user_by('ID', $employee_replace);
		    $hide_adresse = get_user_meta( $employee_replace, 'hide_adresse_key', true);
		    $hide_contact = get_user_meta( $employee_replace, 'hide_contact_key', true);
		    
		    echo $get_employee_replace_by_id->user_nicename;
		    echo ' - ';
		    echo $get_employee_replace_by_id->user_firstname;
		    echo ' ';
		    echo $get_employee_replace_by_id->user_lastname;
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
			    echo $get_employee_replace_by_id->user_email;	    
			    echo '<br>';
		    }
	    }
	    
    echo '<form action="'. $_SERVER['REQUEST_URI'] .'" method="post">';
	    echo '<br>';
	    echo 'Début de l&#8216;horaire: <input type="text" id="datepickerstarthoraire" class="datepickerstarthoraire" name="datepickerstarthoraire" data-toggle="datepickerstarthoraire" value='. $datepickerstarthoraire .' required> - <input type="time" id="timestarthoraire" name="timestarthoraire" value='. $timestarthoraire .' required>';
	    echo '<br>';
	    echo 'Début de la pause: <input type="text" id="datepickerstartpause" class="datepickerstartpause" name="datepickerstartpause" data-toggle="datepickerstartpause" value='. $datepickerstartpause .' required> - <input type="time" id="timestartpause" name="timestartpause" value='. $timestartpause .' required>';
	    echo '<br>';
	    echo 'Fin de la pause: <input type="text" id="datepickerendpause" class="datepickerendpause" name="datepickerendpause" data-toggle="datepickerendpause" value='. $datepickerendpause .' required> - <input type="time" id="timeendpause" name="timeendpause" value='. $timeendpause .' required>';
	    echo '<br>';
	    echo 'Fin de l&#8216;horaire: <input type="text" id="datepickerendhoraire" class="datepickerendhoraire" name="datepickerendhoraire" data-toggle="datepickerendhoraire" value='. $datepickerendhoraire .' required> - <input type="time" id="timeendhoraire" name="timeendhoraire" value='. $timeendhoraire .' required>';
	    echo '<br>';
	    echo 'Vous avez droit à '. $timebrake .' minutes de pause';
	    echo '<br>';
	    echo 'Votre salaire horaire est de <input type="number" class="salaire" name="salaire" id="salaire" step=".01" value='. $salaire .' required>$ de l&#8216;heure';
	    echo '<br>';
	    
	    echo '<h4>Vos entrée/sortie</h4>';
	    echo '<br>';
	    echo '<input type="number" id="punchquantity" class="punchquantity" name="punchquantity" style="display: none;">';
	    $i = 1;
	    $y = 0;
	    $datetimes = [];
	    $push_ = get_post_meta( get_the_ID(), 'push_key', true );
	    if($push_ == ''){
	    	$push_ = [];
	    }
	    foreach($push_ as $push){
	    	if($push[0] == 'entrer'){
			$date = date('m/d/Y', $push[1]);
			$time = date('H:i:s', $push[1]);
	    		echo $push[0] . ' - <input type="text" id="punchdateinout-'.$i.'" class="punchdateinout" name="punchdateinout-'.$i.'" data-toggle="punchdateinout-'.$i.'" value="' . $date . '"> - <input type="time" id="punchtimeinout-'.$i.'" class="punchtimeinout" name="punchtimeinout-'.$i.'" value="'. $time .'">';
	    		$datetimes[$y] = $push[1];
	        	echo '<br>';
	    	}
	    	if($push[0] == 'sortie'){
			$date = date('m/d/Y', $push[1]);
			$time = date('H:i:s', $push[1]);
	    		echo $push[0] . ' - <input type="text" id="punchdateinout-'.$i.'" class="punchdateinout" name="punchdateinout-'.$i.'" data-toggle="punchdateinout-'.$i.'" value="'. $date .'"> - <input type="time" id="punchtimeinout-'.$i.'" class="punchtimeinout" name="punchtimeinout-'.$i.'" value="'. $time .'">';
	    		$datetimes[$y] = $push[1];
	    		echo '<br>';
	    	}
	    	$i++;
	    	$y++;
	    }
	    echo '<div class="addpunchdatetime"></div>';
	    echo '<br>';
	    $pay = [];
	    $datetimescount = count($datetimes);
	    for ($i = 0; $i < $datetimescount; $i++) {
	    	if ($i % 2 == 0) {
			if($datetimes[$i] != '' && $datetimes[$i+1] != ''){
			    $diffdatetime = $datetimes[$i+1] - $datetimes[$i];
			    $seconds = $diffdatetime;
			    $hours = floor($seconds / 3600);
			    $minutes = floor(($seconds / 60) % 60);
			    $secs = $seconds % 60;
			    echo 'Dans: '.sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
			    echo '<br>';
			    $gethours = $hours;
			    $getminutes = $minutes;
			    $worktime = ($gethours * 60) + $getminutes;
			    $salary = $salaire/60;
			    $pay_once = $worktime * $salary;
			    $pay[] = $worktime * $salary;
			    echo 'Votre salaire brute: '.round($pay_once, 2).'$';
			    echo '<br>';
		    	}
		} else {
			if($datetimes[$i] != '' && $datetimes[$i+1] != ''){
			    $diffdatetime = $datetimes[$i+1] - $datetimes[$i];
			    echo 'Sortie: '.gmdate("H:i:s", $diffdatetime);
			    echo '<br>';
		    	}
		}
	    }
	    $pay_sum = array_sum($pay);
	    if($pay_sum != 0){
	    	    echo '<br>';
		    echo '<span>Somme des salaires</span>';
		    echo '<br>';
		    echo 'Le total de vos montants brute: '. round($pay_sum, 2).'$';
		    echo '<br>';
	    }
	    
 	    $fristpush = array_first($push_);
	    if($fristpush[0] == 'entrer'){
	    	if($fristpush[1] <= $datestartstrtotime){
		    	echo '<br>';
		    	$endpushcalc = $datestartstrtotime - $fristpush[1];
		    	echo 'Nombre de temps en avance.';
		    	echo '<br>';
	           	$seconds = $endpushcalc;
			$hours = floor($seconds / 3600);
			$minutes = floor(($seconds / 60) % 60);
			$secs = $seconds % 60;
			echo sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
		    	echo '<br>';
	    	}
	    }
	   if($fristpush[0] == 'entrer'){
	    	if($fristpush[1] >= $datestartstrtotime){
		    	echo '<br>';
		    	$endpushcalc = $fristpush[1] -  $datestartstrtotime;
		    	echo 'Nombre de temps en retard.';
		    	echo '<br>';
	           	$seconds = $endpushcalc;
			$hours = floor($seconds / 3600);
			$minutes = floor(($seconds / 60) % 60);
			$secs = $seconds % 60;
			echo sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
		    	echo '<br>';
	    	}
	    }
	    $endpush = end($push_);
	    if($endpush[0] == 'entrer'){
	    	echo '<br>';
	    	$endpushcalc = $current_time - $endpush[1];
	    	echo 'Nombre de temps de pointages.';
		echo '<br>';
                $seconds = $endpushcalc;
		$hours = floor($seconds / 3600);
		$minutes = floor(($seconds / 60) % 60);
		$secs = $seconds % 60;
		echo sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
	    	echo '<br>';
	    }
	    if($endpush[0] == 'entrer'){
	    	if($current_time >= $dateendstrtotime){
		    	echo '<br>';
		    	$endpushcalc = $current_time - $dateendstrtotime;
		    	echo 'Nombre de temps en supplémentaire.';
		    	echo '<br>';
	           	$seconds = $endpushcalc;
			$hours = floor($seconds / 3600);
			$minutes = floor(($seconds / 60) % 60);
			$secs = $seconds % 60;
			echo sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
		    	echo '<br>';
		    	echo '<br>';
	    	}
	    }
	    if($endpush[0] == 'sortie'){
	    	if($endpush[1] >= $dateendstrtotime){
		    	echo '<br>';
		    	$endpushcalc = $endpush[1] - $dateendstrtotime;
		    	echo 'Nombre de temps en supplémentaire.';
		    	echo '<br>';
	           	$seconds = $endpushcalc;
			$hours = floor($seconds / 3600);
			$minutes = floor(($seconds / 60) % 60);
			$secs = $seconds % 60;
			echo sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
		    	echo '<br>';
		    	echo '<br>';
	    	}
	    }
	    if($endpush[0] == 'sortie'){
	    	if($endpush[1] <= $dateendstrtotime){
		    	echo '<br>';
		    	$endpushcalc = $dateendstrtotime - $endpush[1];
		    	echo 'Nombre de temps de depart hâtif.';
		    	echo '<br>';
	           	$seconds = $endpushcalc;
			$hours = floor($seconds / 3600);
			$minutes = floor(($seconds / 60) % 60);
			$secs = $seconds % 60;
			echo sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
		    	echo '<br>';
		    	echo '<br>';
	    	}
	    }
	    $i = 0;
	    $x = 0;
	    $pausetime = 0;
	    foreach($push_ as $push){
	    	 if($push[0] == 'entrer'){
	    		$entrer[$x] = $push[1];
	    		$x++;
	    	}
	    	if($push[0] == 'sortie'){
	    		$sortie[$i] = $push[1];
	    		$i++;
	    	}
	    }
	    
	    $entrercount = count($entrer);
	    $pausetime = 0;
	    for ($i = 1; $i < $entrercount; $i++) {
		if(($entrer[$i] != 0 || $entrer[$i] != '') && ($sortie[$i-1] != 0 || $sortie[$i-1] != '')){
	    		$pausetime = $pausetime + ($entrer[$i] - $sortie[$i-1]);
	    	}
	    }


		$seconds = $pausetime;
		$hours = floor($seconds / 3600);
		$minutes = floor(($seconds / 60) % 60);
		$secs = $seconds % 60;
		if($minutes != 0){
			echo 'Vous avez passer ce nombre de temps en pause.';
		    	echo '<br>';
			echo sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
			echo '<br>';
			echo '<br>';
		}
		
		if($minutes > $timebrake){
			$timebrakecalc = $minutes - $timebrake;
			echo 'Vous avez depasé le temps de pause de '.$timebrakecalc.' minutes.';
			echo '<br>';
			echo '<br>';
		}
		if($minutes < $timebrake){
			$timebrakecalc_ = $timebrake - $minutes;
			echo 'Il vous reste '.$timebrakecalc_.' minutes de pause.';
			echo '<br>';
			echo '<br>';
		}
	    if($current_time <= $dateendstrtotime && $current_time >= $datestartstrtotime){
		    if($endpush[0] == 'sortie'){
		    	echo '<br>';
		    	$endpushcalc = $current_time - $endpush[1];
		    	if($endpushcalc <= 12600 && $endpushcalc >= -12600){
			    	echo 'Le nombre de temps qui vous avez passé en pause.';
			    	echo '<br>';
	                	$seconds = $endpushcalc;
			        $hours = floor($seconds / 3600);
			        $minutes = floor(($seconds / 60) % 60);
			        $secs = $seconds % 60;
			        echo sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
			    	echo '<br>';
			    	echo '<br>';
		    	}
		    }
	    }
	    
    	echo '<br>';
    	echo '<br>';
        echo '<input type="hidden" name="postid" value="'.get_the_ID().'" />';
        echo '<input type="hidden" name="userid" value="'.$employee_horaire.'" />';
    	echo '<input type="hidden" name="action" value="edit_horaire" />';
    	echo '<button class="ns_submit" type="submit" name="submit">';
    		esc_html_e( 'Sauvegarder', 'monemploi' );
    	echo '</button>';
    	
    echo '</form>';
    
        echo '<br>';
    	echo '<button class="addpunch">Ajouter un pointage</button>';

	    
	}

}
	
	
?>

</article><!-- #post-## -->
