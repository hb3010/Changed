{*
$Id: menu_manufacturers.tpl,v 1.1.2.2 2010/12/09 14:00:53 aim Exp $
vim: set ts=2 sw=2 sts=2 et:
*}
{if $manufacturers_menu ne ''}

  {capture name=menu}
    <div>
    	<select name="manufacture_country_code" id="manufacture_country_code" class="InputWidth" onchange="return loadManufacture();">
    		<option value="">Select Country</option>
		{foreach from=$manufacture_country item=c key=manufacture_country}
	    	<option value="{$c.code}"{if $c.code eq $manufacturer.country} selected="selected"{/if}>{$c.name}</option>
		{/foreach}
	    </select>
	  
	</div>
  {/capture}
  {include file="customer/menu_dialog.tpl" title="Manufacture Country" content=$smarty.capture.menu additional_class="menu-manufacturers"}	

  {capture name=menu}
  <div id="manufactures_list"  style="height: 200px; overflow:auto">
    <ul>

      {foreach from=$manufacturers_menu item=m}
         <li><span onclick="return loadProductsManufacture('{$m.manufacturerid}');">{$m.manufacturer|amp}</span></li>
      {/foreach}

      {if $show_other_manufacturers}
        <li><a href="manufacturers.php">{$lng.lbl_other_manufacturers}</a></li>
      {/if}

    </ul>
   </div> 
  {/capture}
  {include file="customer/menu_dialog.tpl" title=$lng.lbl_manufacturers content=$smarty.capture.menu additional_class="menu-manufacturers"}

	
  
{/if}


