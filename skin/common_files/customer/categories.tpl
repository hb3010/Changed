{*
$Id: categories.tpl,v 1.3.2.2 2010/12/17 15:12:37 aim Exp $
vim: set ts=2 sw=2 sts=2 et:
*}
{if $categories_menu_list ne '' or $fancy_use_cache}
{capture name=menu}

{if $active_modules.Flyout_Menus}

  {include file="modules/Flyout_Menus/categories.tpl"}
  {assign var="additional_class" value="menu-fancy-categories-list"}

{else}


			<div class="quick-order-categories-box">
				<div class="quick-order-categories">
				<input type="hidden" name="base_url" id="base_url" value="{$baseUrl}" />
    {foreach from=$categories_menu_list item=c name=categories}
      
    
 
 					<div class="quick-order-category-item">
 						{if $sub_cat_show[$c.categoryid] ne '' }  						
  						<div class="quick-order-category quick-order-category-click" id="{$c.categoryid}" onclick="return Hide_Show('{$c.categoryid}_cat');">{$c.category|amp}</div>
  						<div class="quick-order-subcategories" id="{$c.categoryid}_cat">
  							{foreach from=$sub_cat_show[$c.categoryid] item=sc key=sub_cat}
							<div class="quick-order-subcategory-item has-products">
 								<div class="quick-order-subcategory quick-order-category-click" id="{$sc.id}" onclick="return loadProducts('{$sc.id}', 'home');">{$sc.name}</div>
							</div>							
							{/foreach}
  						</div>
  						{else}
  						<div class="quick-order-category quick-order-category-click" id="{$c.categoryid}" onclick="return loadProducts('{$c.categoryid}', 'home');">{$c.category|amp}</div>
  						{/if}
 					</div>

 					<div class="quick-order-category-sep"></div>
 					{/foreach}
 				</div>
 			</div>	

  

  {assign var="additional_class" value="menu-categories-list"}

{/if}

{/capture}
{include file="customer/menu_dialog.tpl" title=$lng.lbl_categories content=$smarty.capture.menu}
{/if}
