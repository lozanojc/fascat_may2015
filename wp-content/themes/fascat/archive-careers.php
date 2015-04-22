<?php

// File Security Check

if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {

    die ( 'You do not have sufficient permissions to access this page!' );

}

?>

<?php get_header(); ?>

    <div id="content" class="page col-full">
       <header>
                <div class="custom_page_header" style="background: url(<?php echo($siteUrl = site_url());?>/wp-content/uploads/2014/06/page.jpg) no-repeat top center;">
			      <div class="header_txt" style="width:100%">
                    <h2><?php post_type_archive_title()?></h2>
                    <p style="width:42%">What differentiates FasCat from other coaches and coaching groups is our COMMUNICATION.</p>
                    <a class="button small_txt" href="<?php echo $siteUrl?>/coaching/">How We Coach <i class="fa fa-chevron-right"></i></a>
                  </div>
			    </div>
	        </header>
       <div class="content_wrapper">    	

    	<?php woo_main_before(); ?>

    	

		<section class="fullwidth"> 
			<ul id="submenu">
              <li><a href="<?php echo($siteUrl = site_url());?>/about/">Overview</a></li>
              <li><a href="<?php echo $siteUrl?>/about/partners/">Partners</a></li>
              <li class="active"><a href="<?php echo $siteUrl?>/careers/">Careers</a></li>
              <li><a href="<?php echo $siteUrl?>/contact-us/">Contact</a></li>
              <li><a href="<?php echo $siteUrl?>/athlete-handbook/">New Athlete Handbook</a></li>
              <li><a href="<?php echo $siteUrl?>/core-value/">Core Coaching Values</a></li>
            </ul>
        <div class="clear"></div>


		<?php if (have_posts()) : $count = 0;global $cfs;?>


        <?php

        	// Display the description for this archive, if it's available.

        	woo_archive_description();

        ?>

        

	        <div class="fix"></div>

        

        	<?php woo_loop_before(); ?>

        	

			<?php /* Start the Loop */ ?>

			<?php while ( have_posts() ) : the_post(); $count++; ?>



				<?php

					/* Include the Post-Format-specific template for the content.

					 * If you want to overload this in a child theme then include a file

					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.

					 */
					get_template_part( 'content-careers');

				?>



			<?php endwhile; ?>

            

	        <?php else: ?>

	        

	            <article <?php post_class(); ?>>

	                <p><?php _e( 'Sorry, no posts matched your criteria.', 'fascat' ); ?></p>

	            </article><!-- /.post -->

	        

	        <?php endif; ?>  

	        

	        <?php woo_loop_after(); ?>

    

			<?php woo_pagenav(); ?>

                

		</section><!-- /#main -->

		

		<?php woo_main_after(); ?>



        <?php //get_sidebar(); ?>

	</div>	<!-- /.content_wrapper ends -->

    </div><!-- /#content -->

		

<?php get_footer(); ?>
