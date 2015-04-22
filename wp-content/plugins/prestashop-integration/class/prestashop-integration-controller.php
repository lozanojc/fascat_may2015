<?php
/*  Copyright 2010-2013  François Pons  (email : fpons@aytechnet.fr)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

global $prestashop_integration;
if ( $prestashop_integration->psabspath != '' && file_exists( $prestashop_integration->psabspath . 'config/config.inc.php' )
                                              && ( file_exists( $prestashop_integration->psabspath . 'classes/FrontController.php' ) ||
                                                   file_exists( $prestashop_integration->psabspath . 'classes/controller/FrontController.php' ) ) ) {
	require_once( $prestashop_integration->psabspath . 'config/config.inc.php' );

	class PrestaShopIntegration_FrontController extends FrontController {
		//public $php_self = 'wordpress';

		public function init() {
			$this->page_name = 'wordpress';
			parent::init();
		}

		function displayHeader() {
			global $prestashop_integration;

			/* HACK to inform PrestaShop being under control of WordPress...
			   ...and to avoid bug of modules not displayed on PrestaShop home being not displayed on blog too */
			$_SERVER['QUERY_STRING'] = str_replace( "index.php", "wordpress.php", $_SERVER['QUERY_STRING'] );
			$_SERVER['PHP_SELF'] = str_replace( "index.php", "wordpress.php", $_SERVER['PHP_SELF'] );

			$smarty = isset( $this->context) ? $this->context->smarty : self::$smarty;

			if ( isset( $this->context) ) {
				if (!isset($this->context->cart))
					$this->context->cart = new Cart();
				if ($this->context->getMobileDevice() == false)
				{
					// These hooks aren't used for the mobile theme.
					// Needed hooks are called in the tpl files.
					if (!isset($this->context->cart))
						$this->context->cart = new Cart();
					$smarty->assign(array(
						'prestashop_integration' => $prestashop_integration,
						'HOOK_HEADER' => Hook::exec('displayHeader'),
						'HOOK_TOP' => Hook::exec('displayTop'),
						'HOOK_LEFT_COLUMN' => ($this->display_column_left ? Hook::exec('displayLeftColumn') : ''),
						'HOOK_RIGHT_COLUMN' => ($this->display_column_right ? Hook::exec('displayRightColumn', array('cart' => $this->context->cart)) : ''),
						'HOOK_FOOTER' => Hook::exec('displayFooter'),
					));
				}
				else
				{
					$smarty->assign(array(
						'prestashop_integration' => $prestashop_integration,
						'HOOK_MOBILE_HEADER' => Hook::exec('displayMobileHeader'),
					));
				}

				$smarty->assign(array(
					'time' => time(),
					'img_update_time' => Configuration::get('PS_IMG_UPDATE_TIME'),
					'static_token' => Tools::getToken(false),
					'token' => Tools::getToken(),
					'priceDisplayPrecision' => _PS_PRICE_DISPLAY_PRECISION_,
					'content_only' => (int)Tools::getValue('content_only'),
					'conditions' => Configuration::get('PS_CONDITIONS'),
					'id_cgv' => Configuration::get('PS_CONDITIONS_CMS_ID'),
					'PS_SHOP_NAME' => Configuration::get('PS_SHOP_NAME'),
					'PS_ALLOW_MOBILE_DEVICE' => isset($_SERVER['HTTP_USER_AGENT']) && (bool)Configuration::get('PS_ALLOW_MOBILE_DEVICE') && @filemtime(_PS_THEME_MOBILE_DIR_)
				));
				if (method_exists($this, 'initLogoAndFavicon'))
					$smarty->assign($this->initLogoAndFavicon());

				Tools::safePostVars();

				// assign css_files and js_files at the very last time
				if ((Configuration::get('PS_CSS_THEME_CACHE') || Configuration::get('PS_JS_THEME_CACHE')) && is_writable(_PS_THEME_DIR_.'cache'))
				{
					// CSS compressor management
					if (Configuration::get('PS_CSS_THEME_CACHE'))
						$this->css_files = Media::cccCSS($this->css_files);
					//JS compressor management
					if (Configuration::get('PS_JS_THEME_CACHE'))
						$this->js_files = Media::cccJs($this->js_files);
				}

				$smarty->assign('css_files', $this->css_files);
				$smarty->assign('js_files', array_unique($this->js_files));
				$smarty->assign(array(
					'errors' => $this->errors,
					'display_header' => $this->display_header,	
					'display_footer' => $this->display_footer,
				));

				// Don't use live edit if on mobile device
				if ($this->context->getMobileDevice() == false && Tools::isSubmit('live_edit'))
					$smarty->assign('live_edit', $this->getLiveEditFooter());

				$layout = $this->getLayout();
				if ($layout)
				{
					if ($this->template)
						$smarty->assign('template', $smarty->fetch($this->template));
				}
				/* FIXME : Do not call directly the following else the template page will be outputed:
				   $this->smartyOutputContent($layout); */
			} else {
				global $css_files, $js_files;
				global $cookie;

				$current_id_lang = $cookie->id_lang;
				$cookie->id_lang = $prestashop_integration->psLang();
				if ( $current_id_lang && $current_id_lang != $cookie->id_lang )
					$cookie->write();

				if (Validate::isLoadedObject($ps_language = new Language((int)$cookie->id_lang)))
					self::$smarty->assign( 'lang_iso', $ps_language->iso_code );

				$smarty->assign( array(
					'prestashop_integration' => $prestashop_integration,
					'time' => time(),
					'img_update_time' => Configuration::get('PS_IMG_UPDATE_TIME'),
					'static_token' => Tools::getToken(false),
					'token' => Tools::getToken(),
					'logo_image_width' => Configuration::get('SHOP_LOGO_WIDTH'),
					'logo_image_height' => Configuration::get('SHOP_LOGO_HEIGHT'),
					'priceDisplayPrecision' => _PS_PRICE_DISPLAY_PRECISION_,
					'content_only' => (int)Tools::getValue('content_only')
				) );

				$smarty->assign( array(
					'HOOK_HEADER' => Module::hookExec('header'),
					'HOOK_TOP' => Module::hookExec('top'),
					'HOOK_LEFT_COLUMN' => Module::hookExec('leftColumn'),
					'HOOK_RIGHT_COLUMN' => Module::hookExec('rightColumn', array('cart' => self::$cart)),
					'HOOK_FOOTER' => Module::hookExec('footer')
				) );

				if ((Configuration::get('PS_CSS_THEME_CACHE') OR Configuration::get('PS_JS_THEME_CACHE')) AND is_writable(_PS_THEME_DIR_.'cache'))
				{
					if ($prestashop_integration->css_import) {
						// CSS compressor management
						if (Configuration::get('PS_CSS_THEME_CACHE'))
							Tools::cccCss();
					}

					if ($prestashop_integration->js_import) {
						//JS compressor management
						if (Configuration::get('PS_JS_THEME_CACHE'))
							Tools::cccJs();
					}
				}
				$smarty->assign('css_files', $css_files);
				$smarty->assign('js_files', array_unique($js_files));
			}

			if ($prestashop_integration->favicon_import) {
?>
<link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo $prestashop_integration->getTemplateVars( 'img_ps_dir' ); ?>favicon.ico?<?php echo $prestashop_integration->getTemplateVars( 'img_update_time' ); ?>" />
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $prestashop_integration->getTemplateVars( 'img_ps_dir' ); ?>favicon.ico?<?php echo $prestashop_integration->getTemplateVars( 'img_update_time' ); ?>" />
<?php
			}
?>
<script type="text/javascript">
	var baseDir = '<?php echo $prestashop_integration->getTemplateVars( 'content_dir' ); ?>';
<?php if ( $prestashop_integration->getTemplateVars( 'base_uri' ) ) { ?>
	var baseUri = '<?php echo $prestashop_integration->getTemplateVars( 'base_uri' ); ?>';
<?php } ?>
	var static_token = '<?php echo $prestashop_integration->getTemplateVars( 'static_token' ); ?>';
	var token = '<?php echo $prestashop_integration->getTemplateVars( 'token' ); ?>';
	var priceDisplayPrecision = <?php echo $prestashop_integration->getTemplateVars( 'priceDisplayPrecision' )*$prestashop_integration->getTemplateVars( 'currency' )->decimals; ?>;
	var priceDisplayMethod = <?php echo $prestashop_integration->getTemplateVars( 'priceDisplay' ); ?>;
	var roundMode = <?php echo $prestashop_integration->getTemplateVars( 'roundMode' ); ?>;
</script>
<?php
			if ($prestashop_integration->css_import) {
				foreach ( $prestashop_integration->getTemplateVars( 'css_files' ) as $css_uri => $media )
					echo '<link href="'.$css_uri.'" rel="stylesheet" type="text/css" media="'.$media.'" />'."\n";
			}
			if ($prestashop_integration->js_import) {
				foreach ( $prestashop_integration->getTemplateVars( 'js_files' ) as $js_uri )
					echo '<script type="text/javascript" src="'.$js_uri.'"></script>'."\n";
			}

			echo $prestashop_integration->getTemplateVars( 'HOOK_HEADER' );
                }
	}
}

?>
