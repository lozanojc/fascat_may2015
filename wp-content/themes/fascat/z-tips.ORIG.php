<?php

// File Security Check

if ( ! function_exists( 'wp' ) && ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {

    die ( 'You do not have sufficient permissions to access this page!' );

}

?>

<?php

/**
  * Template Name: Tips
 *
 * Here we setup all logic and XHTML that is required for the index template, used as both the homepage
 * and as a fallback template, if a more appropriate template file doesn't exist for a specific context.
 *
  *
 * @package WooFramework
 * @subpackage Template
 */


  get_header("tips");
  global $woo_options;


	

?>

    <div id="content" class="col-full tips-content-cpt">

      <?php woo_main_before(); ?>

           <?php if (have_posts()) : while (have_posts()) : the_post(); 
	   	        $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
		        $i++; //add 1 to the total count
           ?>

          <div class="custom_page_header page_headers tips-header" style="background: url(<?php echo $cfs->get('header_image'); ?>) no-repeat top center;">
	      	<div class="header_txt">
                 <h2><?php echo $cfs->get('custom_header_heading'); ?></h2>
                 <p><?php echo $cfs->get('custom_header_text'); ?></p>
             </div>
	   </div>

	<?php endwhile;?>
	<?php endif; ?>

<?php if (is_category()) { ?>
<section class="content_wrapper">
        <article <?php post_class(); ?>>
        <section  class="entry tips">


    <?php //if (have_posts()) : 

    $cur_cat_id = get_cat_id( single_cat_title("",false) );

    $args = array( 'post_type' => 'tips', 'cat' => $cur_cat_id );
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post();

    //while (have_posts()) : the_post(); 
      $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
      $i++; //add 1 to the total count
       ?>
                <section class="entry fix">
                <div style="width:60%;float:left;">
            <h2> <?php the_title(); ?></h2>
                    <p> <?php the_excerpt(); ?> </p>
                    <a class="button small_txt" href="<?php the_permalink(); ?>">Read More</a>
                </div>
                <div style="width:30%;float:left;">
                <?php the_post_thumbnail('full'); ?>
               <?php echo $cfs->get('text_contents'); ?>
               <p class="text-center bold"><?php the_author(); ?></p>
               <p class="text-center smaller"><?php the_author_meta('description'); ?></p>
                </div>
                </section>

    <?php endwhile;?>
    <?php //endif; ?>  

            </section><!-- #main -->
        </article><!-- .post -->
    
   </section><!-- .content_wrapper -->
<?php } else { ?>
	<section class="content_wrapper">
            <article <?php post_class(); ?>>
            		<section  class="entry tips">

                   <?php query_posts(array(
                    'post_type'=> 'tips',
        	  	    'posts_per_page' => 1000,
        	  	    'orderby' => 'post_date',
        	  	    'order' => 'DESC',
        	      	 ));
                   ?>

                <?php if (have_posts()) : while (have_posts()) : the_post(); 
          	   	  $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
          		  $i++; //add 1 to the total count
                     ?>

      	         <section class="entry fix">
            				<h2>
                      <a href="<?php the_permalink(); ?>"><?php the_title(); ?>
                        <span class="orange italic">(<?php the_date('n.d.y'); ?>)</span>
                      </a>
                    </h2>
                       
                    <h3> <?php echo $cfs->get('tips_subtitle'); ?></h3>
                    <p class="author"><strong>By:</strong> <?php the_author(); ?></p>
                    <a class="button small_txt" href="<?php the_permalink(); ?>">Read More</a>
      			     </section>

               	<?php endwhile;?>
        		<?php endif; ?>  
           <a href="#"> <div class="tips-cats"></a>
              <h4 class="tips-cats-toggler">Categories</h4>
              <ul class = "tips-cats-list">
              
              <?php $customPostTaxonomies = get_object_taxonomies('tips');

                  if(count($customPostTaxonomies) > 0)
                  {
                       foreach($customPostTaxonomies as $tax)
                       {
                         $args = array(
                              'orderby' => 'name',
                              'show_count' => 0,
                              'pad_counts' => 0,
                              'hierarchical' => 1,
                              'taxonomy' => $tax,
                              'title_li' => ''
                            );

                         wp_list_categories( $args );
                       }
                }
                ?>
              </ul>

             </div>
            
          <div class= "authors">
          
            <a href="#"> <div class="tips-coaches"></a>
                <h4 class="tips-cats-toggler">Coaches</h4>


            <?php 
                  function getUsersByRole( $role ) {
                      // find all users with given role
                      // via http://sltaylor.co.uk/blog/get-wordpress-users-by-role/
                      
                      if ( class_exists( 'WP_User_Search' ) ) {
                        $wp_user_search = new WP_User_Search( '', '', $role );
                        $userIDs = $wp_user_search->get_results();
                      } else {
                        global $wpdb;
                        $userIDs = $wpdb->get_col('
                          SELECT ID
                          FROM '.$wpdb->users.' INNER JOIN '.$wpdb->usermeta.'
                          ON '.$wpdb->users.'.ID = '.$wpdb->usermeta.'.user_id
                          WHERE '.$wpdb->usermeta.'.meta_key = \''.$wpdb->prefix.'capabilities\'
                          AND '.$wpdb->usermeta.'.meta_value LIKE \'%"'.$role.'"%\'
                        ');
                      }
                      return $userIDs;
                    }

                    function midea_list_authors($user_role='author', $show_fullname = true) {
                      // Generate a list of authors for a given role
                      // default is to list authors and show full name
                      
                      global $wpdb;
                      
                      $blog_url = get_bloginfo('url'); // store base URL of blog
                      $holding_pen = array(); // this is cheap, a holder for author data
                     
                      echo '<ul class="tips-coaches-list">';
                      
                      // get array of all author ids for a role
                      $authors = getUsersByRole( $user_role );
                        
                      foreach ( $authors as $item ) {
                      
                        // get number of posts by this author; custom query
                        $post_count = $wpdb->get_results("SELECT COUNT( * ) as cnt 
                        FROM  $wpdb->posts
                        WHERE  post_author =" . $item . "
                        AND  post_type =  'tips'
                        AND  post_status =  'publish'");

                        // only output authors with posts; ugly way to get to the result, but it works....
                        
                        if ($post_count[0]->cnt) {

                          // load info on this user
                          $author = get_userdata( $item);
                                
                          // store output in temp array; we use last names as an index in this array
                          $holding_pen[$author->last_name] =  '<li><a href="' . $blog_url . '/author/'  . $author->user_login  . '"> ' . $author->display_name . ' (' . $post_count[0]->cnt . ')</a> </li>';
                        }

                      }
                      
                      // now sort the array on the index to get alpha order
                      ksort($holding_pen);
                      
                      // now we can spit the output out.
                      foreach ($holding_pen as $key=>$value) {
                        echo $value;
                      }
                      echo '</ul>';
                    }
            ?>
              
            <?php midea_list_authors(); ?> 
                
          

          </div><!--authors-->

			    </section><!-- #main -->
            </article><!-- .post -->


        
       </section><!-- .content_wrapper -->
<?php } ?>  

    </div><!-- #content -->
    <?php woo_main_after(); ?>

<?php get_footer(); ?>
