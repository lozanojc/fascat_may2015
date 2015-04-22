=== Plugin Name ===
Contributors: aytechnet
Donate link: http://www.aytechnet.fr/donate
Tags: prestashop, cart, e-commerce, ecommerce, eshop, shop, shopping cart, web shop, store, shopping, shortcode, widgets
Requires at least: 3.3.0
Tested up to: 3.6.0
Stable tag: 0.9

Add integration using shortcodes and plugins from a PrestaShop e-commerce to your blog

== Description ==

This plugins defines three widgets and a shortcode to integrate WordPress and PrestaShop release 1.4 or 1.5.

This plugins defines a shortcode that can be used to display products on your blog. Only products list has been defined by using `[ps_product_list id_category=X n=C p=P tpl=TPL]` where X is the category id of the category you want to display (by default the home category 1 is used), C is the number of product you want to display (by default 10), P is the page number (by default 1) and TPL is the Smarty template to use (by default `product-list.tpl`). You may replace id_category by id_product list of product ids separated by comma.

Note that the module will import the current theme of PrestaShop to your blog (both CSS and Javascript) but this is optional since 0.6. Generally you need a WordPress theme that is translated from the PrestaShop theme : it need to have the same XHTML layout and you have to replace PrestaShop HOOK markers by widget area in your blog theme, maybe like this :

    <div class="prestashop-sidebar"><ul class="xoxo">
      <?php dynamic_sidebar( 'hooktop-widget-area' ); ?>
    </ul></div><!-- .prestashop-sidebar -->

Furthermore, you may need to replace internal Javascript library by the PrestaShop one to avoid conflicts. For more information about the plugin, please check [PrestaShop Integration](http://www.aytechnet.fr/blog/plugin-wordpress/prestashop-integration) page in french.

The available widgets are :

= PrestaShop Integration Hook =

This widget is used to insert one of the main PrestaShop hooks :

* Top of pages
* Left column block
* Right column block
* Footer

= PrestaShop Integration Module =

This widget is used to insert a PrestaShop module directly, the module must be attached to one of the main hooks to be displayed.

= PrestaShop Integration Products =

This widget is used to display the product list attached to a WordPress post.

== Installation ==

1. Upload `prestashop-integration` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Configure the plugin to set the relative path to the PrestaShop installation
1. Use an almost empty theme created from your PrestaShop theme XHTML layout
1. Add `PrestaShop Integration` widgets to the appropriate sidebars

== Frequently Asked Questions ==

= Does the plugin work with PrestaShop 1.0, 1.1, 1.2 or 1.3 ? =

No, the plugin will not work with any PrestaShop older than 1.4 because the internal structure of PrestaShop has been improved since 1.4 by using a FrontController class. This plugin add support by adding a specific controller for integration with WordPress. It could be possible to add support for PrestaShop 1.3 or older, but it need to be coded. So to get support for PrestaShop Integration, the better is that you upgrade your PrestaShop to at least 1.4 series. You will get furthermore newer functionnalities and bug fixes.

= Does the plugin work with PrestaShop 1.4 ? =

Yes, it should. But If It doesn't work, you may need to update PrestaShop autoload behaviour as indicated below.

= Does the plugin work with PrestaShop 1.5 ? =

Yes, only since version 0.8 which is still compatible with PrestaShop 1.4.

= I can't access my WordPress frontpage due to a redirection to the PrestaShop frontpage =

If you are using PrestaShop 1.5 and you installed WordPress in root of your hosting and PrestaShop in a subdirectory, you will get this error. You need to patch PrestaShop file `classes/shop/Shop.php` as follows :

    --- classes/shop/Shop.php.orig        2013-01-07 09:18:32.000000000 +0100
    +++ classes/shop/Shop.php       2013-01-07 09:25:26.000000000 +0100
    @@ -368,6 +368,9 @@
                            if (!Validate::isLoadedObject($default_shop))
                                    throw new PrestaShopException('Shop not found');
     
    +                       if (defined('PRESTASHOP_INTEGRATION_VERSION')) {
    +                               $shop = $default_shop;
    +                       } else {
                            $params = $_GET;
                            unset($params['id_shop']);
                            if (!Configuration::get('PS_REWRITING_SETTINGS'))
    @@ -388,6 +391,7 @@
                            }
                            header('location: '.$url);
                            exit;
    +                       }
                    }
            }

But you may notice other redirection which should be deactivated also, according to your PrestaShop version.

This bug is caused by PrestaShop trying to figure out which shop is used as it support now the multishop feature. The way it is done is causing the bug, the patch above is mandatory to avoid a redirection being made to the default shop.

= I get an error message about autoloader =

You may be using a WordPress plugin that use PHP autoloader, but PrestaShop assume it is the only one using PHP autoloader : you need to modify the `config/autoload.php` file by changing the name of the function (for example : `__autoload_prestashop`) and to add at the end of the file the following line :

    spl_autoload_register('__autoload_prestashop');

= If a customer logon in PrestaShop, informations about the user/cart is lost in WordPress =

You need to patch PrestaShop cookie management because this problems occurs where PrestaShop is installed in a child directory of WordPress. Please replace the `$this->_path ` in `setcookie` invocation by simply `'/'`. This will make the cookie available to WordPress. you may use override functionnality in PrestaShop to simplify PrestaShop update in the future.

If you try to use two distinct domains for the blog and the shop, it will not work and it is not fixable. At least you need to use two subdomains of the same domain for the blog and the shop, and apply the cookie management to the common domain.

This patch is not necessary when WordPress is installed in a child directory of PrestaShop installation, typically named `blog`.

== Changelog ==

= 0.9 =
* fixed setMedia() invocation for PrestaShop 1.5.4.1 and above.
* added many global function for easier integration with PrestaShop in WordPress theme : ps_l, ps_include, ps_template_vars, ps_get_template_vars, ps_set_template_vars, ps_page_link.
* fixed PrestaShop page name under WordPress.
* fixed JS insertion under WordPress to be earlier.
* added new shortcode : ps_new_product to display new products.
* added new widget : Template Widget to display a template with some Smarty variables instanciated (causing Products Widget to be obsoleted).

= 0.8.3 =
* added a global warning in admin pages if the plugin is not well configured.

= 0.8.2 =
* really fix the warning as stated in 0.8.1.
* added missing smarty variables as indicated by madn3ss75.
* try to avoid execution error when the plugin is badly (or not) configured.
* updated french translation.

= 0.8.1 =
* fixed a warning inspired by Prestance Design resolution (see support forum).
* fixed redirection when PrestaShop 1.5 installation is under WordPress one (see FAQ).

= 0.8 =
* add support for PrestaShop 1.4.9 and 1.5.
* added missing documentation about the two new widget introduced in 0.7.
* define a smarty variable {$prestashop_integration} to access the class object directly.
* added fix from bubatalazi from WordPress support forum.

= 0.7 =
* use blog language to integrate PrestaShop (if no corresponding language found in PrestaShop, fallback to default language).
* add support for WPML for finding blog language.
* add support for Polylang for finding blog language.
* added new widget to handle product list without hooks widget.
* added new widget to handle module directly without hooks widget.
* added feature to attach product to a post.

= 0.6 =
* added configuration for importing PrestaShop CSS, JS and favicon.
* added checking for existence of FrontController class to activate internal controller.
* improved [ps_product_list] shortcode to use id_product and a specific smarty template.

= 0.5 =
* try to protect WordPress execution from PrestaShop importation.

= 0.4 =
* another readme.txt fix.

= 0.3 =
* fixed readme.txt and plugin header.

= 0.2 =
* added french translation.
* first available version.

= 0.1 =
* initial internal version.

