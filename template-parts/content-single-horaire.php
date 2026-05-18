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
	if($user_role == 'employer'){ ?>
		<div class="entry-meta-job-wrapper">
			<header class="entry-header">
                <h1>Horaire</h1>
            </header>
        </div>
        <?php
        $employee_horaire = get_post_meta( get_the_ID(), 'employee_horaire_key', true );
	    $job_horaire = get_post_meta( get_the_ID(), 'job_horaire_key', true );
	    $datepickerstarthoraire = get_post_meta( get_the_ID(), 'datepickerstarthoraire_key', true );
	    $timestarthoraire = get_post_meta( get_the_ID(), 'timestarthoraire_key', true );
	    $datepickerendhoraire = get_post_meta( get_the_ID(), 'datepickerendhoraire_key', true );
	    $timeendhoraire = get_post_meta( get_the_ID(), 'timeendhoraire_key', true );
	    $salaire = get_post_meta( get_the_ID(), 'salaire_key', true );
	    
	    echo $employee_horaire;
	    echo '<br>';
	    echo $job_horaire;
	    echo '<br>';
	    echo $datepickerstarthoraire . ' - ' . $timestarthoraire;
	    echo '<br>';
	    echo $datepickerendhoraire . ' - ' . $timeendhoraire;
	    echo '<br>';
	    echo $salaire;
	    
	    ?>
	<?php } else {
	
		echo '<h2>Vous n&#8216;avez pas l&#8216;autorisation pour consulter cette page</h2>';
	
	}
?>

</article><!-- #post-## -->
