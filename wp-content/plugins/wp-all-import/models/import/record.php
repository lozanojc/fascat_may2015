<?php

class PMXI_Import_Record extends PMXI_Model_Record {

	public static $cdata = array();

	protected $errors;	
	
	/**
	 * Some pre-processing logic, such as removing control characters from xml to prevent parsing errors
	 * @param string $xml
	 */
	public static function preprocessXml( & $xml) {		
		
		if ( empty(PMXI_Plugin::$session->is_csv) and empty(PMXI_Plugin::$is_csv)){ 
		
			self::$cdata = array();			

			$xml = preg_replace_callback('/<!\[CDATA\[[^\]\]>]*\]\]>/s', 'pmxi_cdata_filter', $xml );

			$xml = str_replace("&", "&amp;", str_replace("&amp;","&", $xml));

			if ( ! empty(self::$cdata) ){
			    foreach (self::$cdata as $key => $val) {
			        $xml = str_replace('{{CPLACE_' . ($key + 1) . '}}', $val, $xml);
			    }
			}
		}		
	}

	/**
	 * Validate XML to be valid for import
	 * @param string $xml
	 * @param WP_Error[optional] $errors
	 * @return bool Validation status
	 */
	public static function validateXml( & $xml, $errors = NULL) {
		if (FALSE === $xml or '' == $xml) {
			$errors and $errors->add('form-validation', __('WP All Import can\'t read your file.<br/><br/>Probably, you are trying to import an invalid XML feed. Try opening the XML feed in a web browser (Google Chrome is recommended for opening XML files) to see if there is an error message.<br/>Alternatively, run the feed through a validator: http://validator.w3.org/<br/>99% of the time, the reason for this error is because your XML feed isn\'t valid.<br/>If you are 100% sure you are importing a valid XML feed, please contact WP All Import support.', 'pmxi_plugin'));
		} else {
						
			PMXI_Import_Record::preprocessXml($xml);																						

			if ( function_exists('simplexml_load_string')){
				libxml_use_internal_errors(true);
				libxml_clear_errors();
				$_x = @simplexml_load_string($xml);
				$xml_errors = libxml_get_errors();			
				libxml_clear_errors();
				if ($xml_errors) {								
					$error_msg = '<strong>' . __('Invalid XML', 'pmxi_plugin') . '</strong><ul>';
					foreach($xml_errors as $error) {
						$error_msg .= '<li>';
						$error_msg .= __('Line', 'pmxi_plugin') . ' ' . $error->line . ', ';
						$error_msg .= __('Column', 'pmxi_plugin') . ' ' . $error->column . ', ';
						$error_msg .= __('Code', 'pmxi_plugin') . ' ' . $error->code . ': ';
						$error_msg .= '<em>' . trim(esc_html($error->message)) . '</em>';
						$error_msg .= '</li>';
					}
					$error_msg .= '</ul>';
					$errors and $errors->add('form-validation', $error_msg);				
				} else {
					return true;
				}
			}
			else{
				$errors and $errors->add('form-validation', __('Required PHP components are missing.', 'pmxi_plugin'));				
				$errors and $errors->add('form-validation', __('WP All Import requires the SimpleXML PHP module to be installed. This is a standard feature of PHP, and is necessary for WP All Import to read the files you are trying to import.<br/>Please contact your web hosting provider and ask them to install and activate the SimpleXML PHP module.', 'pmxi_plugin'));				
			}
		}
		return false;
	}

	/**
	 * Initialize model instance
	 * @param array[optional] $data Array of record data to initialize object with
	 */
	public function __construct($data = array()) {
		parent::__construct($data);
		$this->setTable(PMXI_Plugin::getInstance()->getTablePrefix() . 'imports');
		$this->errors = new WP_Error();
	}
	
	public $post_meta_to_insert = array();

	/**
	 * Perform import operation
	 * @param string $xml XML string to import
	 * @param callback[optional] $logger Method where progress messages are submmitted
	 * @return PMXI_Import_Record
	 * @chainable
	 */
	public function process($xml, $logger = NULL, $chunk = false, $is_cron = false, $xpath_prefix = '', $loop = 0) {
		add_filter('user_has_cap', array($this, '_filter_has_cap_unfiltered_html')); kses_init(); // do not perform special filtering for imported content
		
		kses_remove_filters();

		$cxpath = $xpath_prefix . $this->xpath;		

		$this->options += PMXI_Plugin::get_default_import_options(); // make sure all options are defined
		
		$avoid_pingbacks = PMXI_Plugin::getInstance()->getOption('pingbacks');

		$cron_sleep = (int) PMXI_Plugin::getInstance()->getOption('cron_sleep');
		
		if ( $avoid_pingbacks and ! defined( 'WP_IMPORTING' ) ) define( 'WP_IMPORTING', true );

		$postRecord = new PMXI_Post_Record();		
		
		$tmp_files = array();
		// compose records to import
		$records = array();

		$is_import_complete = false;
		
		try { 						
			
			$chunk == 1 and $logger and call_user_func($logger, __('Composing titles...', 'pmxi_plugin'));
			if ( ! empty($this->options['title'])){
				$titles = XmlImportParser::factory($xml, $cxpath, $this->options['title'], $file)->parse($records); $tmp_files[] = $file;							
			}
			else{
				$loop and $titles = array_fill(0, $loop, '');
			}

			$chunk == 1 and $logger and call_user_func($logger, __('Composing excerpts...', 'pmxi_plugin'));			
			$post_excerpt = array();
			if ( ! empty($this->options['post_excerpt']) ){
				$post_excerpt = XmlImportParser::factory($xml, $cxpath, $this->options['post_excerpt'], $file)->parse($records); $tmp_files[] = $file;
			}
			else{
				count($titles) and $post_excerpt = array_fill(0, count($titles), '');
			}			

			if ( "xpath" == $this->options['status'] ){
				$chunk == 1 and $logger and call_user_func($logger, __('Composing statuses...', 'pmxi_plugin'));			
				$post_status = array();
				if (!empty($this->options['status_xpath'])){
					$post_status = XmlImportParser::factory($xml, $cxpath, $this->options['status_xpath'], $file)->parse($records); $tmp_files[] = $file;
				}
				else{
					count($titles) and $post_status = array_fill(0, count($titles), '');
				}
			}

			$chunk == 1 and $logger and call_user_func($logger, __('Composing authors...', 'pmxi_plugin'));			
			$post_author = array();
			$current_user = wp_get_current_user();

			if (!empty($this->options['author'])){
				$post_author = XmlImportParser::factory($xml, $cxpath, $this->options['author'], $file)->parse($records); $tmp_files[] = $file;
				foreach ($post_author as $key => $author) {
					$user = get_user_by('login', $author) or $user = get_user_by('slug', $author) or $user = get_user_by('email', $author) or ctype_digit($author) and $user = get_user_by('id', $author);					
					$post_author[$key] = (!empty($user)) ? $user->ID : $current_user->ID;
				}
			}
			else{								
				count($titles) and $post_author = array_fill(0, count($titles), $current_user->ID);
			}			

			$chunk == 1 and $logger and call_user_func($logger, __('Composing slugs...', 'pmxi_plugin'));			
			$post_slug = array();
			if (!empty($this->options['post_slug'])){
				$post_slug = XmlImportParser::factory($xml, $cxpath, $this->options['post_slug'], $file)->parse($records); $tmp_files[] = $file;
			}
			else{
				count($titles) and $post_slug = array_fill(0, count($titles), '');
			}

			$chunk == 1 and $logger and call_user_func($logger, __('Composing menu order...', 'pmxi_plugin'));			
			$menu_order = array();
			if (!empty($this->options['order'])){
				$menu_order = XmlImportParser::factory($xml, $cxpath, $this->options['order'], $file)->parse($records); $tmp_files[] = $file;
			}
			else{
				count($titles) and $menu_order = array_fill(0, count($titles), '');
			}

			$chunk == 1 and $logger and call_user_func($logger, __('Composing contents...', 'pmxi_plugin'));			 						
			if (!empty($this->options['content'])){
				$contents = XmlImportParser::factory(
					((!empty($this->options['is_keep_linebreaks']) and intval($this->options['is_keep_linebreaks'])) ? $xml : preg_replace('%\r\n?|\n%', ' ', $xml)),
					$cxpath,
					$this->options['content'],
					$file)->parse($records
				); $tmp_files[] = $file;						
			}
			else{
				count($titles) and $contents = array_fill(0, count($titles), '');
			}
										
			$chunk == 1 and $logger and call_user_func($logger, __('Composing dates...', 'pmxi_plugin'));
			if ('specific' == $this->options['date_type']) {
				$dates = XmlImportParser::factory($xml, $cxpath, $this->options['date'], $file)->parse($records); $tmp_files[] = $file;
				$warned = array(); // used to prevent the same notice displaying several times
				foreach ($dates as $i => $d) {
					if ($d == 'now') $d = current_time('mysql'); // Replace 'now' with the WordPress local time to account for timezone offsets (WordPress references its local time during publishing rather than the server’s time so it should use that)
					$time = strtotime($d);
					if (FALSE === $time) {
						in_array($d, $warned) or $logger and call_user_func($logger, sprintf(__('<b>WARNING</b>: unrecognized date format `%s`, assigning current date', 'pmxi_plugin'), $warned[] = $d));
						$logger and !$is_cron and PMXI_Plugin::$session->warnings++;
						$time = time();
					}
					$dates[$i] = date('Y-m-d H:i:s', $time);
				}
			} else {
				$dates_start = XmlImportParser::factory($xml, $cxpath, $this->options['date_start'], $file)->parse($records); $tmp_files[] = $file;
				$dates_end = XmlImportParser::factory($xml, $cxpath, $this->options['date_end'], $file)->parse($records); $tmp_files[] = $file;
				$warned = array(); // used to prevent the same notice displaying several times
				foreach ($dates_start as $i => $d) {
					$time_start = strtotime($dates_start[$i]);
					if (FALSE === $time_start) {
						in_array($dates_start[$i], $warned) or $logger and call_user_func($logger, sprintf(__('<b>WARNING</b>: unrecognized date format `%s`, assigning current date', 'pmxi_plugin'), $warned[] = $dates_start[$i]));
						$logger and !$is_cron and PMXI_Plugin::$session->warnings++;
						$time_start = time();
					}
					$time_end = strtotime($dates_end[$i]);
					if (FALSE === $time_end) {
						in_array($dates_end[$i], $warned) or $logger and call_user_func($logger, sprintf(__('<b>WARNING</b>: unrecognized date format `%s`, assigning current date', 'pmxi_plugin'), $warned[] = $dates_end[$i]));
						$logger and !$is_cron and PMXI_Plugin::$session->warnings++;
						$time_end = time();
					}					
					$dates[$i] = date('Y-m-d H:i:s', mt_rand($time_start, $time_end));
				}
			}
						
			// [custom taxonomies]
			require_once(ABSPATH . 'wp-admin/includes/taxonomy.php');

			$taxonomies = array();						
			$exclude_taxonomies = (class_exists('PMWI_Plugin')) ? array('post_format', 'product_type', 'product_shipping_class') : array('post_format');	
			$post_taxonomies = array_diff_key(get_taxonomies_by_object_type(array($this->options['custom_type']), 'object'), array_flip($exclude_taxonomies));
			if ( ! empty($post_taxonomies) ):
				foreach ($post_taxonomies as $ctx): if ("" == $ctx->labels->name or (class_exists('PMWI_Plugin') and strpos($ctx->name, "pa_") === 0 and $this->options['custom_type'] == "product")) continue;
					$chunk == 1 and $logger and call_user_func($logger, sprintf(__('Composing terms for `%s` taxonomy...', 'pmxi_plugin'), $ctx->labels->name));
					$tx_name = $ctx->name;
					$mapping_rules = ( ! empty($this->options['tax_mapping'][$tx_name])) ? json_decode($this->options['tax_mapping'][$tx_name], true) : false;
					$taxonomies[$tx_name] = array();
					if ( ! empty($this->options['tax_logic'][$tx_name]) ){
						switch ($this->options['tax_logic'][$tx_name]){
							case 'single':
								if ( ! empty($this->options['tax_single_xpath'][$tx_name]) ){
									$txes = XmlImportParser::factory($xml, $cxpath, str_replace('\'','"',$this->options['tax_single_xpath'][$tx_name]), $file)->parse($records); $tmp_files[] = $file;		
									foreach ($txes as $i => $tx) {
										$taxonomies[$tx_name][$i][] = pmxi_ctx_mapping(array(
											'name' => $tx,
											'parent' => false,
											'assign' => $this->options['tax_assing'][$tx_name],
											'is_mapping' => (!empty($this->options['tax_enable_mapping'][$tx_name]))
										), $mapping_rules, $tx_name);
									}									
								}
								break;
							case 'multiple':
								if ( ! empty($this->options['tax_multiple_xpath'][$tx_name]) ){
									$txes = XmlImportParser::factory($xml, $cxpath, str_replace('\'','"',$this->options['tax_multiple_xpath'][$tx_name]), $file)->parse($records); $tmp_files[] = $file;		
									foreach ($txes as $i => $tx) {
										$delimeted_taxonomies = explode( ! empty($this->options['tax_multiple_delim'][$tx_name]) ? $this->options['tax_multiple_delim'][$tx_name] : ',', $tx);
										if ( ! empty($delimeted_taxonomies) ){
											foreach ($delimeted_taxonomies as $cc) {												
												$taxonomies[$tx_name][$i][] = pmxi_ctx_mapping(array(
													'name' => $cc,
													'parent' => false,
													'assign' => $this->options['tax_assing'][$tx_name],
													'is_mapping' => (!empty($this->options['tax_enable_mapping'][$tx_name]))
												), $mapping_rules, $tx_name);
											}
										}
									}
								}
								break;
							case 'hierarchical':
								if ( ! empty($this->options['tax_hierarchical_logic'][$tx_name])){
									switch ($this->options['tax_hierarchical_logic'][$tx_name]) {
										case 'entire':
											if (! empty($this->options['tax_hierarchical_xpath'][$tx_name])){
												$txes = XmlImportParser::factory($xml, $cxpath, str_replace('\'','"',$this->options['tax_hierarchical_xpath'][$tx_name]), $file)->parse($records); $tmp_files[] = $file;		
												foreach ($txes as $i => $tx) {
													$delimeted_taxonomies = explode( ! empty($this->options['tax_hierarchical_delim'][$tx_name]) ? $this->options['tax_hierarchical_delim'][$tx_name] : ',', $tx);
													if ( ! empty($delimeted_taxonomies) ){
														foreach ($delimeted_taxonomies as $j => $cc) {												
															$taxonomies[$tx_name][$i][] = pmxi_ctx_mapping(array(
																'name' => $cc,
																'parent' => (!empty($taxonomies[$tx_name][$i][$j - 1])) ? $taxonomies[$tx_name][$i][$j - 1] : false,
																'assign' => $this->options['tax_assing'][$tx_name],
																'is_mapping' => (!empty($this->options['tax_enable_mapping'][$tx_name]))
															), $mapping_rules, $tx_name);
														}
													}
												}
											}
											break;										
										case 'manual':
											if ( ! empty($this->options['post_taxonomies'][$tx_name]) ){
												$taxonomies_hierarchy = json_decode($this->options['post_taxonomies'][$tx_name], true);
												
												foreach ($taxonomies_hierarchy as $k => $taxonomy){	if ("" == $taxonomy['xpath']) continue;								
													$txes_raw =  XmlImportParser::factory($xml, $cxpath, str_replace('\'','"',$taxonomy['xpath']), $file)->parse($records); $tmp_files[] = $file;						
													$warned = array();
													
													foreach ($txes_raw as $i => $cc) {
														if (empty($taxonomies_hierarchy[$k]['txn_names'][$i])) $taxonomies_hierarchy[$k]['txn_names'][$i] = array();
														if (empty($taxonomies[$tx_name][$i])) $taxonomies[$tx_name][$i] = array();
														$count_cats = count($taxonomies[$tx_name][$i]);																											
														
														if (!empty($taxonomy['parent_id'])) {																			
															foreach ($taxonomies_hierarchy as $key => $value){
																if ($value['item_id'] == $taxonomy['parent_id'] and !empty($value['txn_names'][$i])){													
																	foreach ($value['txn_names'][$i] as $parent) {																			
																		$taxonomies[$tx_name][$i][] = pmxi_ctx_mapping(array(
																			'name' => trim($cc),
																			'parent' => $parent,
																			'assign' => $this->options['tax_assing'][$tx_name],
																			'is_mapping' => (!empty($this->options['tax_enable_mapping'][$tx_name]))
																		), $mapping_rules, $tx_name);																		
																	}																												
																}
															}															
														}
														else {																
															$taxonomies[$tx_name][$i][] = pmxi_ctx_mapping(array(
																'name' => trim($cc),
																'parent' => false,
																'assign' => $this->options['tax_assing'][$tx_name],
																'is_mapping' => (!empty($this->options['tax_enable_mapping'][$tx_name]))
															), $mapping_rules, $tx_name);
														}								
														
														if ($count_cats < count($taxonomies[$tx_name][$i])) $taxonomies_hierarchy[$k]['txn_names'][$i][] = $taxonomies[$tx_name][$i][count($taxonomies[$tx_name][$i]) - 1];
													}
												}
											}
											break;

										default:
											
											break;
									}
								}								
								break;

							default:
											
								break;
						}
					}
				endforeach;
			endif;			
			// [/custom taxonomies]												

			// Composing featured images
			if ( ! (($uploads = wp_upload_dir()) && false === $uploads['error'])) {
				$logger and call_user_func($logger, __('<b>WARNING</b>', 'pmxi_plugin') . ': ' . $uploads['error']);
				$logger and call_user_func($logger, __('<b>WARNING</b>: No featured images will be created. Uploads folder is not found.', 'pmxi_plugin'));				
				$logger and !$is_cron and PMXI_Plugin::$session->warnings++;				
			} else {
				$chunk == 1 and $logger and call_user_func($logger, __('Composing URLs for featured images...', 'pmxi_plugin'));
				$featured_images = array();				
				if ( "no" == $this->options['download_images']){
					if ($this->options['featured_image']) {					
						$featured_images = XmlImportParser::factory($xml, $cxpath, $this->options['featured_image'], $file)->parse($records); $tmp_files[] = $file;																				
					} else {
						count($titles) and $featured_images = array_fill(0, count($titles), '');
					}					
				}
				else{
					if ($this->options['download_featured_image']) {					
						$featured_images = XmlImportParser::factory($xml, $cxpath, $this->options['download_featured_image'], $file)->parse($records); $tmp_files[] = $file;																				
					} else {
						count($titles) and $featured_images = array_fill(0, count($titles), '');
					}
				}				
			}	
			
			// Composing images meta titles
			if ( $this->options['set_image_meta_title'] ){																	
				$chunk == 1 and $logger and call_user_func($logger, __('Composing image meta data (titles)...', 'pmxi_plugin'));
				$image_meta_titles = array();				

				if ($this->options['image_meta_title']) {					
					$image_meta_titles = XmlImportParser::factory($xml, $cxpath, $this->options['image_meta_title'], $file)->parse($records); $tmp_files[] = $file;						
				} else {
					count($titles) and $image_meta_titles = array_fill(0, count($titles), '');
				}
			}

			// Composing images meta captions
			if ( $this->options['set_image_meta_caption'] ){	
				$chunk == 1 and $logger and call_user_func($logger, __('Composing image meta data (captions)...', 'pmxi_plugin'));
				$image_meta_captions = array();				
				if ($this->options['image_meta_caption']) {					
					$image_meta_captions = XmlImportParser::factory($xml, $cxpath, $this->options['image_meta_caption'], $file)->parse($records); $tmp_files[] = $file;								
				} else {
					count($titles) and $image_meta_captions = array_fill(0, count($titles), '');
				}
			}

			// Composing images meta alt text
			if ( $this->options['set_image_meta_alt'] ){	
				$chunk == 1 and $logger and call_user_func($logger, __('Composing image meta data (alt text)...', 'pmxi_plugin'));
				$image_meta_alts = array();				
				if ($this->options['image_meta_alt']) {					
					$image_meta_alts = XmlImportParser::factory($xml, $cxpath, $this->options['image_meta_alt'], $file)->parse($records); $tmp_files[] = $file;						
				} else {
					count($titles) and $image_meta_alts = array_fill(0, count($titles), '');
				}
			}

			// Composing images meta description
			if ( $this->options['set_image_meta_description'] ){	
				$chunk == 1 and $logger and call_user_func($logger, __('Composing image meta data (description)...', 'pmxi_plugin'));
				$image_meta_descriptions = array();				
				if ($this->options['image_meta_description']) {					
					$image_meta_descriptions = XmlImportParser::factory($xml, $cxpath, $this->options['image_meta_description'], $file)->parse($records); $tmp_files[] = $file;						
				} else {
					count($titles) and $image_meta_descriptions = array_fill(0, count($titles), '');
				}								
			}

			if ( "yes" == $this->options['download_images'] ){
				// Composing images suffix
				$chunk == 1 and $this->options['auto_rename_images'] and $logger and call_user_func($logger, __('Composing images suffix...', 'pmxi_plugin'));			
				$auto_rename_images = array();
				if ( $this->options['auto_rename_images'] and ! empty($this->options['auto_rename_images_suffix'])){
					$auto_rename_images = XmlImportParser::factory($xml, $cxpath, $this->options['auto_rename_images_suffix'], $file)->parse($records); $tmp_files[] = $file;
				}
				else{
					count($titles) and $auto_rename_images = array_fill(0, count($titles), '');
				}

				// Composing images extensions
				$chunk == 1 and $this->options['auto_set_extension'] and $logger and call_user_func($logger, __('Composing images extensions...', 'pmxi_plugin'));			
				$auto_extensions = array();
				if ( $this->options['auto_set_extension'] and ! empty($this->options['new_extension'])){
					$auto_extensions = XmlImportParser::factory($xml, $cxpath, $this->options['new_extension'], $file)->parse($records); $tmp_files[] = $file;
				}
				else{
					count($titles) and $auto_extensions = array_fill(0, count($titles), '');
				}
			}

			// Composing attachments
			if ( ! (($uploads = wp_upload_dir()) && false === $uploads['error'])) {
				$logger and call_user_func($logger, __('<b>WARNING</b>', 'pmxi_plugin') . ': ' . $uploads['error']);				
				$logger and call_user_func($logger, __('<b>WARNING</b>: No attachments will be created', 'pmxi_plugin')); 				
				$logger and !$is_cron and PMXI_Plugin::$session->warnings++;
			} else {
				$chunk == 1 and $logger and call_user_func($logger, __('Composing URLs for attachments files...', 'pmxi_plugin'));
				$attachments = array();

				if ($this->options['attachments']) {
					// Detect if attachments is separated by comma
					$atchs = explode(',', $this->options['attachments']);					
					if (!empty($atchs)){
						$parse_multiple = true;
						foreach($atchs as $atch) if (!preg_match("/{.*}/", trim($atch))) $parse_multiple = false;			

						if ($parse_multiple)
						{							
							foreach($atchs as $atch) 
							{								
								$posts_attachments = XmlImportParser::factory($xml, $cxpath, trim($atch), $file)->parse($records); $tmp_files[] = $file;																
								foreach($posts_attachments as $i => $val) $attachments[$i][] = $val;								
							}
						}
						else
						{
							$attachments = XmlImportParser::factory($xml, $cxpath, $this->options['attachments'], $file)->parse($records); $tmp_files[] = $file;								
						}
					}
					
				} else {
					count($titles) and $attachments = array_fill(0, count($titles), '');
				}
			}				

			$chunk == 1 and $logger and call_user_func($logger, __('Composing unique keys...', 'pmxi_plugin'));
			if (!empty($this->options['unique_key'])){
				$unique_keys = XmlImportParser::factory($xml, $cxpath, $this->options['unique_key'], $file)->parse($records); $tmp_files[] = $file;
			}
			else{
				count($titles) and $unique_keys = array_fill(0, count($titles), '');
			}
			
			$chunk == 1 and $logger and call_user_func($logger, __('Processing posts...', 'pmxi_plugin'));
			
			if ('post' == $this->options['type'] and '' != $this->options['custom_type']) {
				$post_type = $this->options['custom_type'];
			} else {
				$post_type = $this->options['type'];
			}					
			
			$custom_type_details = get_post_type_object( $post_type );

			$addons = array();
			$addons_data = array();

			// data parsing for WP All Import add-ons
			$chunk == 1 and $logger and call_user_func($logger, __('Data parsing via add-ons...', 'pmxi_plugin'));
			$parsingData = array(
				'import' => $this,
				'count'  => count($titles),
				'xml'    => $xml,
				'logger' => $logger,
				'chunk'  => $chunk,
				'xpath_prefix' => $xpath_prefix
			);			
			foreach (PMXI_Admin_Addons::get_active_addons() as $class) {							
				$model_class = str_replace("_Plugin", "_Import_Record", $class);	
				if (class_exists($model_class)){						
					$addons[$class] = new $model_class();
					$addons_data[$class] = ( method_exists($addons[$class], 'parse') ) ? $addons[$class]->parse($parsingData) : false;				
				}
				else{
					$parse_func = $class . '_parse';					
					if (function_exists($parse_func)) $addons_data[$class] = call_user_func($parse_func, $parsingData);					
				}
			}

			// save current import state to variables before import			
			$created = $this->created;
			$updated = $this->updated;
			$skipped = $this->skipped;			
			
			$specified_records = array();

			if ($this->options['is_import_specified']) {
				$chunk == 1 and $logger and call_user_func($logger, __('Calculate specified records to import...', 'pmxi_plugin'));
				foreach (preg_split('% *, *%', $this->options['import_specified'], -1, PREG_SPLIT_NO_EMPTY) as $chank) {
					if (preg_match('%^(\d+)-(\d+)$%', $chank, $mtch)) {
						$specified_records = array_merge($specified_records, range(intval($mtch[1]), intval($mtch[2])));
					} else {
						$specified_records = array_merge($specified_records, array(intval($chank)));
					}
				}

			}					

			foreach ($titles as $i => $void) {			

				if ($is_cron and $cron_sleep) sleep($cron_sleep);		

				$logger and call_user_func($logger, __('---', 'pmxi_plugin'));
				$logger and call_user_func($logger, sprintf(__('Record #%s', 'pmxi_plugin'), $this->imported + $i + 1));

				wp_cache_flush();

				$logger and call_user_func($logger, __('<b>ACTION</b>: pmxi_before_post_import ...', 'pmxi_plugin'));
				do_action('pmxi_before_post_import', $this->id);															

				if ( empty($titles[$i]) ) {
					if ( ! empty($addons_data['PMWI_Plugin']) and !empty($addons_data['PMWI_Plugin']['single_product_parent_ID'][$i]) ){
						$titles[$i] = $addons_data['PMWI_Plugin']['single_product_parent_ID'][$i] . ' Product Variation';
					}					
					else{
						$logger and call_user_func($logger, __('<b>WARNING</b>: title is empty.', 'pmxi_plugin'));
						$logger and !$is_cron and PMXI_Plugin::$session->warnings++;
					}
				}				
				
				if ( $this->options['custom_type'] == 'import_users' ){					
					$articleData = array(			
						'user_pass' => $addons_data['PMUI_Plugin']['pmui_pass'][$i],
						'user_login' => $addons_data['PMUI_Plugin']['pmui_logins'][$i],
						'user_nicename' => $addons_data['PMUI_Plugin']['pmui_nicename'][$i],
						'user_url' =>  $addons_data['PMUI_Plugin']['pmui_url'][$i],
						'user_email' =>  $addons_data['PMUI_Plugin']['pmui_email'][$i],
						'display_name' =>  $addons_data['PMUI_Plugin']['pmui_display_name'][$i],
						'user_registered' =>  $addons_data['PMUI_Plugin']['pmui_registered'][$i],
						'first_name' =>  $addons_data['PMUI_Plugin']['pmui_first_name'][$i],
						'last_name' =>  $addons_data['PMUI_Plugin']['pmui_last_name'][$i],
						'description' =>  $addons_data['PMUI_Plugin']['pmui_description'][$i],
						'nickname' => $addons_data['PMUI_Plugin']['pmui_nickname'][$i],
						'role' => ('' == $addons_data['PMUI_Plugin']['pmui_role'][$i]) ? 'subscriber' : $addons_data['PMUI_Plugin']['pmui_role'][$i],
					);		
					$logger and call_user_func($logger, sprintf(__('Combine all data for user %s...', 'pmxi_plugin'), $articleData['user_login']));
				} 
				else {					
					$articleData = array(
						'post_type' => $post_type,
						'post_status' => ("xpath" == $this->options['status']) ? $post_status[$i] : $this->options['status'],
						'comment_status' => $this->options['comment_status'],
						'ping_status' => $this->options['ping_status'],
						'post_title' => (!empty($this->options['is_leave_html'])) ? html_entity_decode($titles[$i]) : $titles[$i], 
						'post_excerpt' => apply_filters('pmxi_the_excerpt', ((!empty($this->options['is_leave_html'])) ? html_entity_decode($post_excerpt[$i]) : $post_excerpt[$i]), $this->id),
						'post_name' => $post_slug[$i],
						'post_content' => apply_filters('pmxi_the_content', ((!empty($this->options['is_leave_html'])) ? html_entity_decode($contents[$i]) : $contents[$i]), $this->id),
						'post_date' => $dates[$i],
						'post_date_gmt' => get_gmt_from_date($dates[$i]),
						'post_author' => $post_author[$i],						
						'menu_order' => (int) $menu_order[$i],
						'post_parent' => (int) $this->options['parent']
					);
					$logger and call_user_func($logger, sprintf(__('Combine all data for post `%s`...', 'pmxi_plugin'), $articleData['post_title']));		
				}						
				
				// Re-import Records Matching
				$post_to_update = false; $post_to_update_id = false;
				
				// if Auto Matching re-import option selected
				if ( "manual" != $this->options['duplicate_matching'] ){
					
					// find corresponding article among previously imported				
					$logger and call_user_func($logger, sprintf(__('Find corresponding article among previously imported for post `%s`...', 'pmxi_plugin'), $articleData['post_title']));
					$postRecord->clear();
					$postRecord->getBy(array(
						'unique_key' => $unique_keys[$i],
						'import_id' => $this->id,
					));

					if ( ! $postRecord->isEmpty() ) {
						$logger and call_user_func($logger, sprintf(__('Duplicate post was founded for post %s with unique key `%s`...', 'pmxi_plugin'), $articleData['post_title'], $unique_keys[$i]));
						if ( $this->options['custom_type'] == 'import_users'){
							$post_to_update = get_user_by('id', $post_to_update_id = $postRecord->post_id);							
						}
						else{
							$post_to_update = get_post($post_to_update_id = $postRecord->post_id);
						}
					}
					else{
						$logger and call_user_func($logger, sprintf(__('Duplicate post wasn\'t founded with unique key `%s`...', 'pmxi_plugin'), $unique_keys[$i]));
					}
																
				// if Manual Matching re-import option seleted
				} else {
										
					if ('custom field' == $this->options['duplicate_indicator']) {
						$custom_duplicate_value = XmlImportParser::factory($xml, $cxpath, $this->options['custom_duplicate_value'], $file)->parse($records); $tmp_files[] = $file;
						$custom_duplicate_name = XmlImportParser::factory($xml, $cxpath, $this->options['custom_duplicate_name'], $file)->parse($records); $tmp_files[] = $file;
					}
					else{
						count($titles) and $custom_duplicate_name = $custom_duplicate_value = array_fill(0, count($titles), '');
					}
					
					$logger and call_user_func($logger, sprintf(__('Find corresponding article among database for post `%s`...', 'pmxi_plugin'), $articleData['post_title']));
					// handle duplicates according to import settings
					if ($duplicates = pmxi_findDuplicates($articleData, $custom_duplicate_name[$i], $custom_duplicate_value[$i], $this->options['duplicate_indicator'])) {															
						$duplicate_id = array_shift($duplicates);						
						if ($duplicate_id) {	
							$logger and call_user_func($logger, sprintf(__('Duplicate post was founded for post `%s`...', 'pmxi_plugin'), $articleData['post_title']));
							if ( $this->options['custom_type'] == 'import_users'){													
								$post_to_update = get_user_by('id', $post_to_update_id = $duplicate_id);
							}
							else{
								$post_to_update = get_post($post_to_update_id = $duplicate_id);
							}
						}	
						else{
							$logger and call_user_func($logger, sprintf(__('Duplicate post wasn\'n founded for post `%s`...', 'pmxi_plugin'), $articleData['post_title']));
						}					
					}					
				}

				if ( ! empty($specified_records) ) {

					if ( ! in_array($created + $updated + $skipped + 1, $specified_records) ){

						if ( ! $postRecord->isEmpty() ) $postRecord->set(array('iteration' => $this->iteration))->update();

						$skipped++;											
						$logger and call_user_func($logger, __('<b>SKIPPED</b>: by specified records option', 'pmxi_plugin'));
						$logger and !$is_cron and PMXI_Plugin::$session->warnings++;					
						$logger and !$is_cron and PMXI_Plugin::$session->chunk_number++;
						PMXI_Plugin::$session->save_data();						
						continue;
					}										
				}				

				// Duplicate record is founded
				if ($post_to_update){

					//$logger and call_user_func($logger, sprintf(__('Duplicate record is founded for `%s`', 'pmxi_plugin'), $articleData['post_title']));

					// Do not update already existing records option selected
					if ("yes" == $this->options['is_keep_former_posts']) {	

						if ( ! $postRecord->isEmpty() ) $postRecord->set(array('iteration' => $this->iteration))->update();	

						do_action('pmxi_do_not_update_existing', $post_to_update_id, $this->id, $this->iteration);																																											

						$skipped++;
						$logger and call_user_func($logger, sprintf(__('<b>SKIPPED</b>: Previously imported record found for `%s`', 'pmxi_plugin'), $articleData['post_title']));
						$logger and !$is_cron and PMXI_Plugin::$session->warnings++;							
						$logger and !$is_cron and PMXI_Plugin::$session->chunk_number++;	
						PMXI_Plugin::$session->save_data();	
						continue;
					}					

					$articleData['ID'] = $post_to_update_id;					
					// Choose which data to update
					if ( $this->options['update_all_data'] == 'no' ){

						if ( ! in_array($this->options['custom_type'], array('import_users'))){

							// preserve date of already existing article when duplicate is found					
							if ( ! $this->options['is_update_categories'] or ($this->options['is_update_categories'] and $this->options['update_categories_logic'] != "full_update")) { 							
								$logger and call_user_func($logger, sprintf(__('Preserve taxonomies of already existing article for `%s`', 'pmxi_plugin'), $articleData['post_title']));	
								$existing_taxonomies = array();
								foreach (array_keys($taxonomies) as $tx_name) {
									$txes_list = get_the_terms($articleData['ID'], $tx_name);
									if (is_wp_error($txes_list)) {
										$logger and call_user_func($logger, sprintf(__('<b>WARNING</b>: Unable to get current taxonomies for article #%d, updating with those read from XML file', 'pmxi_plugin'), $articleData['ID']));
										$logger and !$is_cron and PMXI_Plugin::$session->warnings++;		
									} else {
										$txes_new = array();
										if (!empty($txes_list)):
											foreach ($txes_list as $t) {
												$txes_new[] = $t->term_taxonomy_id;
											}
										endif;
										$existing_taxonomies[$tx_name][$i] = $txes_new;								
									}
								}							
							}	
										
							if ( ! $this->options['is_update_dates']) { // preserve date of already existing article when duplicate is found
								$articleData['post_date'] = $post_to_update->post_date;
								$articleData['post_date_gmt'] = $post_to_update->post_date_gmt;
								$logger and call_user_func($logger, sprintf(__('Preserve date of already existing article for `%s`', 'pmxi_plugin'), $articleData['post_title']));								
							}
							if ( ! $this->options['is_update_status']) { // preserve status and trashed flag
								$articleData['post_status'] = $post_to_update->post_status;
								$logger and call_user_func($logger, sprintf(__('Preserve status of already existing article for `%s`', 'pmxi_plugin'), $articleData['post_title']));								
							}
							if ( ! $this->options['is_update_content']){ 
								$articleData['post_content'] = $post_to_update->post_content;
								$logger and call_user_func($logger, sprintf(__('Preserve content of already existing article for `%s`', 'pmxi_plugin'), $articleData['post_title']));								
							}
							if ( ! $this->options['is_update_title']){ 
								$articleData['post_title'] = $post_to_update->post_title;		
								$logger and call_user_func($logger, sprintf(__('Preserve title of already existing article for `%s`', 'pmxi_plugin'), $articleData['post_title']));																		
							}
							if ( ! $this->options['is_update_slug']){ 
								$articleData['post_name'] = $post_to_update->post_name;			
								$logger and call_user_func($logger, sprintf(__('Preserve slug of already existing article for `%s`', 'pmxi_plugin'), $articleData['post_title']));																	
							}
							if ( ! $this->options['is_update_excerpt']){ 
								$articleData['post_excerpt'] = $post_to_update->post_excerpt;
								$logger and call_user_func($logger, sprintf(__('Preserve excerpt of already existing article for `%s`', 'pmxi_plugin'), $articleData['post_title']));																				
							}										
							if ( ! $this->options['is_update_menu_order']){ 
								$articleData['menu_order'] = $post_to_update->menu_order;
								$logger and call_user_func($logger, sprintf(__('Preserve menu order of already existing article for `%s`', 'pmxi_plugin'), $articleData['post_title']));								
							}
							if ( ! $this->options['is_update_parent']){ 
								$articleData['post_parent'] = $post_to_update->post_parent;
								$logger and call_user_func($logger, sprintf(__('Preserve post parent of already existing article for `%s`', 'pmxi_plugin'), $articleData['post_title']));								
							}
							if ( ! $this->options['is_update_author']){ 
								$articleData['post_author'] = $post_to_update->post_author;
								$logger and call_user_func($logger, sprintf(__('Preserve post author of already existing article for `%s`', 'pmxi_plugin'), $articleData['post_title']));
							}
						}
						else {
							if ( ! $this->options['is_update_first_name'] ) $articleData['first_name'] = $post_to_update->first_name;
							if ( ! $this->options['is_update_last_name'] ) $articleData['last_name'] = $post_to_update->last_name;
							if ( ! $this->options['is_update_role'] ) unset($articleData['role']);
							if ( ! $this->options['is_update_nickname'] ) $articleData['nickname'] = get_user_meta($post_to_update->ID, 'nickname', true);
							if ( ! $this->options['is_update_description'] ) $articleData['description'] = get_user_meta($post_to_update->ID, 'description', true);
							if ( ! $this->options['is_update_login'] ) $articleData['user_login'] = $post_to_update->user_login; 
							if ( ! $this->options['is_update_password'] ) unset($articleData['user_pass']);
							if ( ! $this->options['is_update_nicename'] ) $articleData['user_nicename'] = $post_to_update->user_nicename;
							if ( ! $this->options['is_update_email'] ) $articleData['user_email'] = $post_to_update->user_email;
							if ( ! $this->options['is_update_registered'] ) $articleData['user_registered'] = $post_to_update->user_registered;
							if ( ! $this->options['is_update_display_name'] ) $articleData['display_name'] = $post_to_update->display_name;
							if ( ! $this->options['is_update_url'] ) $articleData['user_url'] = $post_to_update->user_url;
						}

						$logger and call_user_func($logger, sprintf(__('Applying filter `pmxi_article_data` for `%s`', 'pmxi_plugin'), $articleData['post_title']));	
						$articleData = apply_filters('pmxi_article_data', $articleData, $this, $post_to_update);
																
					}

					if ( ! in_array($this->options['custom_type'], array('import_users'))){

						if ( $this->options['update_all_data'] == 'yes' or ( $this->options['update_all_data'] == 'no' and $this->options['is_update_attachments'])) {
							$logger and call_user_func($logger, sprintf(__('Deleting attachments for `%s`', 'pmxi_plugin'), $articleData['post_title']));								
							wp_delete_attachments($articleData['ID'], true, 'files');
						}
						// handle obsolete attachments (i.e. delete or keep) according to import settings
						if ( $this->options['update_all_data'] == 'yes' or ( $this->options['update_all_data'] == 'no' and $this->options['is_update_images'] and $this->options['update_images_logic'] == "full_update")){
							$logger and call_user_func($logger, sprintf(__('Deleting images for `%s`', 'pmxi_plugin'), $articleData['post_title']));								
							wp_delete_attachments($articleData['ID'], ($this->options['download_images'] == 'yes'), 'images');
						}

					}
				}
				elseif ( ! $postRecord->isEmpty() ){
					
					// existing post not found though it's track was found... clear the leftover, plugin will continue to treat record as new
					$postRecord->clear();
					
				}					
				
				// no new records are created. it will only update posts it finds matching duplicates for
				if ( ! $this->options['create_new_records'] and empty($articleData['ID'])){ 
					
					if ( ! $postRecord->isEmpty() ) $postRecord->set(array('iteration' => $this->iteration))->update();

					$logger and call_user_func($logger, __('<b>SKIPPED</b>: by do not create new posts option.', 'pmxi_plugin'));
					$logger and !$is_cron and PMXI