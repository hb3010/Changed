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
 * Retreive manufacturers list
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2012 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    $Id: customer_manufacturers.php,v 1.27.2.4 2012/03/27 11:18:33 aim Exp $
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../"); die("Access denied"); }

$manufacturers_count = func_query_first_cell("SELECT COUNT(manufacturerid) FROM $sql_tbl[manufacturers] USE INDEX (avail) WHERE avail = 'Y'");

if ($manufacturers_count > 0) {

    
    
    //BON ADD FOR AJAX LOAD MANUFACTURE BY COUNTRY
    /* Load manufactures for country by ajax */
    if (isset($_POST["manufacture_load"])&&($_POST["manufacture_load"]=="yes")){
    	
    	sleep(1);
    	
    	$countryid = $_POST["countryId"];
    	$manufactures_ajax_list = array();
	    
    	$manufactures_ajax_list_query = db_query("SELECT m.manufacturerid , m.manufacturer FROM $sql_tbl[manufacturers] m, $sql_tbl[manufacturers_to_categories] mct WHERE m.manufacturerid=mct.manufacturerid AND mct.countries_iso_code_2='$countryid'");
	    
	    $i=0;
	    while ($result=db_fetch_array($manufactures_ajax_list_query)){
	    	$manufactures_ajax_list[$i] = $result;
	    	$i++;
	    }
	    print_r(json_encode($manufactures_ajax_list));
	    die();
	    
    }
	
    
    /* Load all country */
    $country_list = array();
    $country_list_query = db_query("SELECT mc.countries_name as name, mc.countries_iso_code_2 as code FROM $sql_tbl[manufacture_categories] mc, $sql_tbl[manufacturers_to_categories] mct WHERE mc.countries_iso_code_2=mct.countries_iso_code_2 GROUP BY mc.countries_iso_code_2");
    
    $i=0;
    while ($result=db_fetch_array($country_list_query)){
    	$country_list[$i] = $result;
    	$i++;
    }
    $smarty -> assign("manufacture_country", $country_list);
    //END BON ADD
    
    if ($config['Manufacturers']['manufacturers_limit'] > 0) {

        $smarty->assign('show_other_manufacturers', ($manufacturers_count > $config['Manufacturers']['manufacturers_limit']));

    }

    $manufacturers = func_get_manufacturers_list(true, $config['Manufacturers']['manufacturers_limit']);

    $smarty->assign('manufacturers_menu', $manufacturers);

}

?>
