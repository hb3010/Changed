<?php
/* vim: set ts=4 sw=4 sts=4 et: */
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| X-Cart Software license agreement                                           |
| Copyright (c) 2001-2012 Qualiteam software Ltd <info@x-cart.com>            |
| All rights reserved.                                                        |
+-----------------------------------------------------------------------------+
| PLEASE READ  THE FULL TEXT OF SOFTWARE LICENSE AGREEMENT IN THE "COPYRIGHT" |
| FILE PROVIDED WITH THIS DISTRIBUTION. THE AGREEMENT TEXT IS ALSO AVAILABLE  |
| AT THE FOLLOWING URL: http://www.x-cart.com/license.php                     |
|                                                                             |
| THIS AGREEMENT EXPRESSES THE TERMS AND CONDITIONS ON WHICH YOU MAY USE THIS |
| SOFTWARE PROGRAM AND ASSOCIATED DOCUMENTATION THAT QUALITEAM SOFTWARE LTD   |
| (hereinafter referred to as "THE AUTHOR") OF REPUBLIC OF CYPRUS IS          |
| FURNISHING OR MAKING AVAILABLE TO YOU WITH THIS AGREEMENT (COLLECTIVELY,    |
| THE "SOFTWARE"). PLEASE REVIEW THE FOLLOWING TERMS AND CONDITIONS OF THIS   |
| LICENSE AGREEMENT CAREFULLY BEFORE INSTALLING OR USING THE SOFTWARE. BY     |
| INSTALLING, COPYING OR OTHERWISE USING THE SOFTWARE, YOU AND YOUR COMPANY   |
| (COLLECTIVELY, "YOU") ARE ACCEPTING AND AGREEING TO THE TERMS OF THIS       |
| LICENSE AGREEMENT. IF YOU ARE NOT WILLING TO BE BOUND BY THIS AGREEMENT, DO |
| NOT INSTALL OR USE THE SOFTWARE. VARIOUS COPYRIGHTS AND OTHER INTELLECTUAL  |
| PROPERTY RIGHTS PROTECT THE SOFTWARE. THIS AGREEMENT IS A LICENSE AGREEMENT |
| THAT GIVES YOU LIMITED RIGHTS TO USE THE SOFTWARE AND NOT AN AGREEMENT FOR  |
| SALE OR FOR TRANSFER OF TITLE. THE AUTHOR RETAINS ALL RIGHTS NOT EXPRESSLY  |
| GRANTED BY THIS AGREEMENT.                                                  |
+-----------------------------------------------------------------------------+
\*****************************************************************************/

/**
 * Includes common scripts for specified area
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2012 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    $Id: common.php,v 1.9.2.6 2012/03/27 11:18:19 aim Exp $
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header('Location: ../'); die('Access denied'); }

if (!isset($current_area)) {

    return;

}

switch ($current_area) {

    case 'C':

        x_load('category');

        // Build categories tree for the Flyout menus module

        if (
            empty($active_modules['Flyout_Menus'])
            || !func_fc_use_cache()
            || !func_fc_has_cache()
            || strpos($config['alt_skin'], 'artistictunes') !== false //Display Horizontal menu categories, when cache is used
        ) {

            if (
                !isset($cat)
                || $config['General']['root_categories'] == 'Y'
            ) {

                $categories = func_get_categories_list(0, false);

            } else {

                $categories = func_get_categories_list($cat, false);
        
            }
        }

        if (!empty($active_modules['Flyout_Menus'])) {

            include $xcart_dir . '/modules/Flyout_Menus/fancy_categories.php';

        }

        // Get categories menu data
        if (!empty($categories)) {
            $smarty->assign('categories_menu_list', $categories);
        }

        if (!empty($active_modules['Manufacturers'])) {

            include $xcart_dir . '/modules/Manufacturers/customer_manufacturers.php';

        }

        if (!empty($active_modules['Bestsellers'])) {

            include $xcart_dir . '/modules/Bestsellers/bestsellers.php';

        }

        break;

    case 'A':
        break;

    case 'P':
        break;

    case 'B':
        break;
}

// BON ADD FOR CHANGE SHOW SUBCATEGORY 
$sub_cat = array();
foreach ($categories as $k => $v){
	$i = 0;
	$sub_cat_query = db_query("Select categoryid, category from $sql_tbl[categories] WHERE parentid='$k'");
	while ($result = db_fetch_array($sub_cat_query)){
		$sub_cat[$k][$i]["id"] = $result["categoryid"];
		$sub_cat[$k][$i]["name"] = $result["category"];
		$i++;
	}
}
//(print_r($sub_cat));die();
$smarty->assign('sub_cat_show', $sub_cat);
// END BON ADD

//Add for ajax load products list
if(isset($_POST["ajax_load"])&&isset($_POST["catid"])){
	
	sleep(1);
	
	$catid = $_POST["catid"];
	
	$baseUrl_ajax = $_SERVER['PHP_SELF'];
	$smarty->assign("baseUrl", $baseUrl_ajax);
	
	$products_ajax_load = array();
	
	$plist_ajax_query = db_query("Select pe.productid, pe.product, pe.descr, imt.image_path, p.list_price, pr.price From xcart_products_lng_en pe, $sql_tbl[images_T] imt, $sql_tbl[products] p, $sql_tbl[products_categories] pc, $sql_tbl[pricing] pr WHERE pe.productid=pc.productid and imt.id=pc.productid and p.productid=pc.productid and p.productid=pr.productid and pc.categoryid='$catid' group by pe.productid");
	$i = 0;
	while ($result = db_fetch_array($plist_ajax_query)){
		$products_ajax_load[$i] = $result;
		$image_path_ajax = $result["image_path"];
		$img_ajax = explode("\\", $image_path_ajax);
		$products_ajax_load[$i]["image_path"] = $img_ajax[3];
		$i++;
	}
		
	print_r(json_encode($products_ajax_load));
	
	die();
}
//End add ajax load

//Add for ajax load manufacture products
if(isset($_POST["ajax_load"])&&isset($_POST["manufactureid"])){
	
	sleep(1);
	
	$manufactureid = $_POST["manufactureid"];
	
	$baseUrl_ajax = $_SERVER['PHP_SELF'];
	$smarty->assign("baseUrl", $baseUrl_ajax);
	
	$products_ajax_load = array();
	
	$plist_ajax_query = db_query("Select pe.productid, pe.product, pe.descr, imt.image_path, p.list_price, pr.price From xcart_products_lng_en pe, $sql_tbl[images_T] imt, $sql_tbl[products] p, $sql_tbl[pricing] pr WHERE pe.productid=p.productid and imt.id=p.productid and p.productid=pr.productid and p.manufacturerid='$manufactureid' group by p.productid");
	$i = 0;
	while ($result = db_fetch_array($plist_ajax_query)){
		$products_ajax_load[$i] = $result;
		$image_path_ajax = $result["image_path"];
		$img_ajax = explode("\\", $image_path_ajax);
		$products_ajax_load[$i]["image_path"] = $img_ajax[3];
		$i++;
	}
		
	print_r(json_encode($products_ajax_load));
	
	die();
}
//End add ajax load

?>
