 <?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
/**
 * Single Post Template for camps
 *
 * This template is the default page template. It is used to display content when someone is viewing a
 * singular view of a post ('post' post_type).
 * @link http://codex.wordpress.org/Post_Types#Post
 *
 * @package WooFramework
 * @subpackage Template
 */
  get_header();
  global $woo_options;
?>

    <div id="content" class="col-full">

        <?php
        woo_main_before();
          if ( have_posts() ) { $count = 0;

            while ( have_posts() ) : the_post(); $count++;
//var_dump(get_post_meta(get_the_ID()));echo"<br/>\nPost Type: ";global $post;var_dump($post->post_type);
        ?>

    <article <?php post_class();?>>

             <header>
            <div class="custom_page_header" style="background: url(<?php echo $cfs->get('header_image'); ?>) no-repeat top center;">
              <div class="header_txt">
                <h2><?php the_title();?></h2>
                  <p><?php echo $cfs->get('camp_subtitle'); ?></p>
                   <a class="button small_txt camps-sign-up" href="#">Sign Up <img class="right_arrow" src="<?php echo get_template_directory_uri() ?>/images/right_arrow.png" alt="right arrow icon" /></a>
                   <?php the_content();?>
               </div>
           </div>
       </header>
         
        <section class="content_wrapper">
                  <section class="entry fix">
            <ul id="submenu">
                  <?php 
                  $temp = get_the_ID();

                  query_posts(array(
                  'post_type'=> 'camps',
                  'posts_per_page' => 5,
                  'orderby' => 'post_date',
                  'order' => 'DESC',
                   ));
                  ?>
                   <?php if (have_posts()) : while (have_posts()) : the_post(); 
                      $i++; //add 1 to the total count
                      $class = ( $temp == get_the_ID() ) ? 'active' : '';
                   ?>

                    <li class= "<?php echo $class ?>">
                      <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                      </a>
                    </li>
                  <?php endwhile;?>
                    <?php endif; wp_reset_query();?>

                  </ul>

                    <?php echo $cfs->get('short_code_stripe'); ?>    

                <div class="clear"> </div>                   
             </section>
          </section><!-- .content_wrapper -->
        </article><!-- .post -->
                  
              <?php endwhile;?>
          <?php } ?>  

        
        
      <div class="dots_bg camps_listing">
       <?php query_posts(array(
          'post_type'=> 'camps',
          'posts_per_page' => 4,
          'orderby' => 'post_date',
            'post__not_in' => array($post->ID),
          'order' => 'DESC',
            ));
      ?>
               
        <div class="content_wrapper">
          <section class="entry fix">
            <h2>Camps</h2>
           <?php if (have_posts()) : while (have_posts()) : the_post(); 
              $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
            $i++; //add 1 to the total count
            ?>
              <div class="featured_image">
                <a href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail(); ?>
                  <h5><?php the_title();?></h5>
                </a>
              </div>  <!-- featured_image ends -->
            
              <?php endwhile;?>
            <?php endif; ?>

          <div class="clearfix"> </div>
        </section>

       </div> <!-- .content_wrapper ends -->

      </div>

  <?php //woo_main_after(); ?>

    </div><!-- #content -->

<?php get_footer(); ?>