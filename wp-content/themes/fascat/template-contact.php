<?php

// File Security Check

if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {

    die ( 'You do not have sufficient permissions to access this page!' );

}

?>

<?php

/**
 * Template Name: Contact Form
 *
 * The contact form page template displays the a
 * simple contact form in your website's content area.
 *
 * @package WooFramework
 * @subpackage Template
 */

 

global $woo_options;

get_header(); ?>

    <div id="content" class="col-full contact">


                        <?php if ( isset($woo_options['woo_contactform_map_coords']) && $woo_options['woo_contactform_map_coords'] != '' ) { $geocoords = $woo_options['woo_contactform_map_coords']; }  else { $geocoords = ''; }?>

                		<?php if ($geocoords != '') { ?>

                		<?php woo_maps_contact_output("geocoords=$geocoords"); ?>

                		<?php //echo do_shortcode( '[hr]' ); ?>

                		<?php } ?>

	<div class="header_txt"><?php echo $cfs->get('map_text'); ?></div>


	<section class="fullwidth content_wrapper">
           <ul id="submenu">
              <li><a href="<?php echo($siteUrl = site_url());?>/about/">Overview</a></li>
              <li><a href="<?php echo $siteUrl?>/about/partners/">Partners</a></li>
              <li><a href="<?php echo $siteUrl?>/careers/">Careers</a></li>
              <li class="active"><a href="<?php echo $siteUrl?>/contact-us/">Contact</a></li>
              <li><a href="<?php echo $siteUrl?>/athlete-handbook/">New Athlete Handbook</a></li>
              <li><a href="<?php echo $siteUrl?>/core-value/">Core Coaching Values</a></li>
            </ul>
        <div class="clear"></div>


            <article id="contact-page" class="page">


                <?php if ( have_posts() ) { ?>
                <?php while ( have_posts() ) { the_post(); ?>

                        <section class="entry">
	                        <?php the_content(); ?>
                        </section>

	 		<?php

                    		} // End WHILE Loop

                    	}

                    ?>

            </article><!-- /#contact-page -->

			
	</section>	<!-- content_wrapper ends -->

    </div><!-- /#content -->

<?php get_footer(); ?>
