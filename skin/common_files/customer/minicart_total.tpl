{*
$Id: minicart_total.tpl,v 1.1.2.3 2011/11/10 09:20:44 aim Exp $
vim: set ts=2 sw=2 sts=2 et:
*}
<div class="minicart" id="ajax_minicart" style="height: 300px; overflow:auto">
  {if $minicart_total_items gt 0}
  
  	<div class="quick-order-cart-products-box">
  		<div class="quick-order-cart-products-display">
  			{foreach from=$mini_cart_ajax item=product name=products} 
   			<div class="quick-order-cart-product" id="item-4">
    			<div class="quick-order-cart-product-box">
	     			<div class="quick-order-cart-product-x"><span>x</span></div>
	     			<div class="quick-order-cart-product-main">
	      				<div class="quick-order-cart-product-title">{$product.product}</div>
	      				<div class="quick-order-cart-product-subtotal">{$product.amount} x <span class="currency">${$product.price}</span> = <span class="currency">${$product.subtotal}</span></div>
	     			</div>
    			</div>
   			</div>
   			<div class="quick-order-cart-sep"></div>   
   			{/foreach}
   			<div><strong>Total: &nbsp;{capture name=tt assign=val}
              {currency value=$minicart_total_cost}
            {/capture}
            {include file="main/tooltip_js.tpl" class="help-link" title=$val text=$lng.txt_minicart_total_note}</strong></div>
  		</div>
 	</div>
    
  {else}

    <div class="valign-middle empty">

      <strong>{$lng.lbl_cart_is_empty}</strong>

    </div>

  {/if}

{if $minicart_total_standalone}
{load_defer_code type="css"}
{load_defer_code type="js"}
{/if}
</div>
