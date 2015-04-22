<!--BEGIN #sidebar .aside-->
<div id="sidebar" class="aside">
	testing
	<?php if(!is_page() && get_post_type() != 'portfolio') {
		dynamic_sidebar();
		echo 'testing first';
	} elseif(get_post_type() == 'portfolio') {
		dynamic_sidebar('Portfolio Sidebar'); 
		echo 'testing middle';
	} else {
		dynamic_sidebar('Page Sidebar'); 
		echo 'testing last';
	} ?>
</div>
<!--END #sidebar .aside-->