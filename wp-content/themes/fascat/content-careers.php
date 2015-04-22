<?php

// File Security Check

if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {

    die ( 'You do not have sufficient permissions to access this page!' );

}

?>

<?php

/**

 * The default template for displaying content

 */



	global $woo_options;

 

/**

 * The Variables

 *

 * Setup default variables, overriding them if the "Theme Options" have been saved.

 */



 	$settings = array(

					'thumb_w' => 787, 

					'thumb_h' => 300, 

					'thumb_align' => 'aligncenter'

					);

					

	$settings = woo_get_dynamic_values( $settings );

 

?>



	<article <?php post_class(); ?>>

		<section class="post-content">

			<header>

				<h3><a href="<?php echo($link = get_the_permalink());?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a><?php if(1 === $cfs->get('filled')){?><span class="job_filled"><i class="fa fa-check"></i> Filled</span><?php }?></h3>

			</header>

	

			<section class="entry">

			<p style="margin-bottom:20px"><?php echo $cfs->get('lead_in');?>... <span><a href="<?php echo $link?>">Apply Now &raquo;</a></span></p>

			</section>

	

			  

		</section><!--/.post-content -->



	</article><!-- /.post -->
