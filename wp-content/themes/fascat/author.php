<?php

// File Security Check

if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {

    die ( 'You do not have sufficient permissions to access this page!' );

}

?>

<?php get_header(); ?>


        <?php $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));?>


        <?php 
        $classes = get_body_class();
            if (in_array('author-frank-author',$classes)) {
               ?>  <div id="content" class="col-full tips-content-cpt" style="background-color:#fff; text-align:left">
                      <div class="custom_page_header page_headers tips-header" style="background: url(/wp-content/uploads/2015/01/frankheader13.png) no-repeat top center;">
                              <div class="header_txt">
                                   <h2 style="text-align:left; color:#fff;">Coaching Tips from <?php echo $curauth->nickname; ?></h2>
                                   <p style="text-align:left; color:#fff;"><?php echo $curauth->user_description?></p>

                              </div>

                      </div>
         <?php   } elseif (in_array('author-jason',$classes)) { ?>

                  <div id="content" class="col-full tips-content-cpt" style="background-color:#fff; text-align:left">
                      <div class="custom_page_header page_headers tips-header" style="background: url(/wp-content/uploads/2015/01/fascat_header_v1__0007_jason.jpg) no-repeat top center;">
                              <div class="header_txt">
                                   <h2 style="text-align:left; color:#fff;">Coaching Tips from <?php echo $curauth->nickname; ?></h2>
                                   <p style="text-align:left; color:#fff;"><?php echo $curauth->user_description?></p>

                              </div>

                      </div> 
          <?php  } elseif (in_array('author-carson',$classes)) { ?>

                  <div id="content" class="col-full tips-content-cpt" style="background-color:#fff; text-align:left">
                      <div class="custom_page_header page_headers tips-header" style="background: url(/wp-content/uploads/2015/01/fascat_header_v1__0014_carson.jpg) no-repeat top center;">
                              <div class="header_txt">
                                   <h2 style="text-align:left; color:#fff;">Coaching Tips from <?php echo $curauth->nickname; ?></h2>
                                   <p style="text-align:left; color:#fff;"><?php echo $curauth->user_description?></p>

                              </div>

                      </div> 
          <?php  } elseif (in_array('author-jake',$classes)) { ?>

                  <div id="content" class="col-full tips-content-cpt" style="background-color:#fff; text-align:left">
                      <div class="custom_page_header page_headers tips-header" style="background: url(/wp-content/uploads/2015/01/fascat_header_v1__0008_jake.jpg) no-repeat top center;">
                              <div class="header_txt">
                                   <h2 style="text-align:left; color:#fff;">Coaching Tips from <?php echo $curauth->nickname; ?></h2>
                                   <p style="text-align:left; color:#fff;"><?php echo $curauth->user_description?></p>

                              </div>

                      </div> 
          <?php  } elseif (in_array('author-nate',$classes)) { ?>

                  <div id="content" class="col-full tips-content-cpt" style="background-color:#fff; text-align:left">
                      <div class="custom_page_header page_headers tips-header" style="background: url(/wp-content/uploads/2015/01/nateheader1.png) no-repeat top center;">
                              <div class="header_txt">
                                   <h2 style="text-align:left; color:#fff;">Coaching Tips from <?php echo $curauth->nickname; ?></h2>
                                   <p style="text-align:left; color:#fff;"><?php echo $curauth->user_description?></p>

                              </div>

                      </div> 
          
        <?php  } elseif (in_array('author-melissa',$classes)) { ?>

                  <div id="content" class="col-full tips-content-cpt" style="background-color:#fff; text-align:left">
                      <div class="custom_page_header page_headers tips-header" style="background: url(/wp-content/uploads/2015/01/coach_melissa.png) no-repeat top center;">
                              <div class="header_txt">
                                   <h2 style="text-align:left; color:#fff;">Coaching Tips from <?php echo $curauth->nickname; ?></h2>
                                   <p style="text-align:left; color:#fff;"><?php echo $curauth->user_description?></p>

                              </div>

                      </div> 



          <?php  } else { ?>

                  <div id="content" class="col-full tips-content-cpt" style="background-color:#fff; text-align:left">
                      <div class="custom_page_header page_headers tips-header" style="background: url(/wp-content/uploads/2015/01/fascat_dots.png) no-repeat top center;">
                              <div class="header_txt">
                                   <h2 style="text-align:left; color:#fff;">Coaching Tips from <?php echo $curauth->nickname; ?></h2>
                                   <p style="text-align:left; color:#fff;"><?php echo $curauth->user_description?></p>

                              </div>

                      </div> 
          <?php  } ?>
        

    <section class="content_wrapper">
            <section  class="tips entry">

           
        <?php //if (have_posts()) : 





        $args = array( 'post_type' => 'tips', 'author' => $curauth->ID );
        $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post();

        //while (have_posts()) : the_post(); 
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
        <?php //endif; ?>  

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
                
          
        </div>

                </section><!-- #main -->
        
       </section><!-- .content_wrapper -->
        

<?php get_footer(); ?>
